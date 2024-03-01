<?php
// create an object from User class
$user_obj = new User();
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get user id
  $user_id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
  // get activation token
  $token = isset($_POST['token']) && !empty($_POST['token']) ? trim($_POST['token'], " \n\t\r\v") : null;
  // get mobile
  $mobile = isset($_POST['mobile']) && !empty($_POST['mobile']) ? $_POST['mobile'] : null;

  // array of errors
  $err_arr = [];

  // check id
  if ($user_id == null || $token == null || $mobile == null) {
    $err_arr[] = 'activation error';
  }

  if (empty($err_arr)) {
    // check if code was sent before
    $activation_info = $user_obj->get_activation_info($user_id, $mobile);

    // check info
    if ($activation_info != null) {
      // check activation code
      if ($activation_info['token'] == $token) {
        // activate mobile
        $user_obj->activate_phone($user_id);
        // delete activation code
        $user_obj->delete_activation_code($user_id, $mobile);

        $_SESSION['flash_message'] = 'MOBILE ACTIVATED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = 'employees';
      } else {
        $_SESSION['flash_message'] = 'QUERY PROBLEM';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
    } else {
      $_SESSION['flash_message'] = 'NO DATA';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    foreach ($err_arr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'employees';
    }
    $target_url = 'back';
  }
  // redirect to previous page
  redirect_home(null, $target_url, 0);

} elseif ($_SESSION['sys']['is_activated_phone'] == 0) { ?>
  <div class="container" dir="<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <?php
    $ultramsg_token = ""; // Ultramsg.com token
    $instance_id = ""; // Ultramsg.com instance id
    $client = new WhatsAppApi($ultramsg_token, $instance_id);
    // get current time
    $time_period = date('a');

    // get destination phone number
    $to = (!starts_with(trim($_SESSION['sys']['phone'], " \n\r\t\v"), "+2") ? "+2" : "") . trim($_SESSION['sys']['phone'], " \n\r\t\v");
    // check employee phone if valid whatsapp account
    $is_whatsapp_account = $client->checkContact($to);

    if (key_exists('status', $is_whatsapp_account) && $is_whatsapp_account['status'] == 'valid') {
      // generate activation code
      $activation_code = generate_random_string(3) . random_digits(3);

      // prepare message
      $msg = ($time_period == 'am' ? lang('GOOD MORNING') : lang('GOOD AFTERNOON')) . " " . $_SESSION['sys']['username'] . "\n";
      $msg .= $activation_code;
      $msg .= " " . lang('ACTIVATION CODE MSG', $lang_file) . "...";

      // assign message to body
      $body = $msg;

      // check if code was sent before
      $previous_activation_info = $user_obj->get_activation_info(base64_decode($_SESSION['sys']['UserID']), $to);

      // status
      $status = false;
      $expired = false;

      if (empty($previous_activation_info)) {
        // send message
        $api = $client->sendChatMessage($to, $body);
        // store activation code
        $user_obj->add_activation_code(array(base64_decode($_SESSION['sys']['UserID']), $to, $activation_code));

        // check api status
        if (key_exists('sent', $api) && $api['sent'] == 'true') {
          $response = lang('ACTIVATION CODE SENT', $lang_file);
          $status = true;
          $status_icon = 'check-circle-fill';
        } elseif (key_exists('error', $api)) {
          $status_icon = 'exclamation-triangle-fill';
          if ($api['error'][0]['to']) {
            $response = lang('WRONG PHONE', $lang_file);
          }
        }
      } else {
        // get date and time
        $previous_activation_time = new DateTime(date('H:i:s', strtotime($previous_activation_info['created_at'])));
        $previous_activation_date = date('d-m-Y', strtotime($previous_activation_info['created_at']));

        // get date and time different
        $date_diff = date_diff(date_create($previous_activation_date), date_create(date('d-m-Y H:i:s')));
        // check date different
        if ($date_diff->d > 0 || $date_diff->i > 15) {
          $user_obj->delete_activation_code(base64_decode($_SESSION['sys']['UserID']), $to);
          $response = lang('ACTIVATION CODE EXPIRED', $lang_file);
          $status = false;
          $status_icon = 'exclamation-triangle-fill';
          $expired = true;
        } else {
          $response = lang('ACTIVATION CODE VALID', $lang_file);
          $status = true;
          $status_icon = 'check-circle-fill';
        }
      }
    } else {
      $response = lang('INVALID WHATSAPP ACCOUNT', $lang_file);
      $status = false;
      $status_icon = 'exclamation-triangle-fill';
    }
    ?>

    <div class="section-block">
      <header class="section-header">
        <h5 class="h5 text-capitalize">
          <?php echo lang('ACTIVATE PHONE') ?>
        </h5>
        <hr>
      </header>

      <div class="section-content">
        <!-- alert for request response -->
        <div class="alert alert-<?php echo $status == false ? 'danger' : 'success' ?>" role="alert">
          <i class="bi bi-<?php echo $status_icon ?>"></i>&nbsp;
          <?php echo $response ?>

          <?php if (isset($expired) && $expired) { ?>
            <a href="">
              <?php echo lang('RESEND ACTIVATION CODE', $lang_file) ?>
            </a>
          <?php } ?>
        </div>
        <?php if ($status) { ?>
          <form action="?do=activate-phone" method="post" id="activate-phone" onchange="form_validation(this)">
            <input type="hidden" name="id" value="<?php echo $_SESSION['sys']['UserID'] ?>">
            <input type="hidden" name="mobile" value="<?php echo $to ?>">
            <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" maxlength="11" class="form-control" name="token" id="token"
                placeholder="<?php echo lang('ACTIVATION CODE') ?>" required>
              <label for="token">
                <?php echo lang('ACTIVATION CODE') ?>
              </label>
            </div>

            <div class="mt-3 hstack">
              <!-- submit button -->
              <button type="button" form="activate-phone"
                dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>"
                class="me-auto btn btn-primary text-capitalize py-1 fs-12" onclick="form_validation(this.form, 'submit')"><i
                  class="bi bi-check-all"></i>&nbsp;
                <?php echo lang('ACTIVATE') ?>
              </button>
            </div>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } else {
  include_once $globmod . 'no-data-founded.php';
} ?>