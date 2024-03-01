<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of User class
  $user_obj = new User();

  // array of error
  $err_arr = array();

  // get user phone
  $phone = isset($_POST['phone']) && !empty($_POST['phone']) ? trim($_POST['phone'], "\n\r\t\v") : null;
  // get company code
  $company_code = isset($_POST['company-code']) && !empty($_POST['company-code']) ? trim($_POST['company-code']) : null;
  // get latest password reset
  $last_pass_reset_info = $user_obj->get_reset_password_info($phone, $company_code);
  // check last rest password info
  if ($last_pass_reset_info != null && count($last_pass_reset_info) > 0) {
    // get last password reset time
    $last_pass_reset_time = date_create($last_pass_reset_info['created_at']);
    // get time name
    $time_now = date_create(get_time_now('Y-m-d H:i:s'));
    // get diffrence between times
    $time_diff = date_diff($time_now, $last_pass_reset_time);

    // check number of days and hours
    if ($time_diff->y == 0 && $time_diff->m == 0 && $time_diff->d == 0 && $time_diff->h == 0 && $time_diff->i <= 15) {
      // prepare flash session message
      $_SESSION['flash_message'] = 'PASSWORD RESET CODE SENT BEFORE';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
      // return home
      redirect_home(null, $_SERVER['PHP_SELF'], 0);
    }
  }

  // make validation on phone
  if ($phone == null) {
    $err_arr[] = 'phone empty';
  }

  // make validation on company_code
  if ($company_code == null) {
    $err_arr[] = 'company code empty';
  }

  // Ultramsg.com token
  $ultramsg_token = "xgkn9ejfc8b9ti1a";
  // Ultramsg.com instance id
  $instance_id = "instance46427";
  // create an object of Whatsapp class
  $whatsapp_obj = new WhatsAppApi($ultramsg_token, $instance_id);

  // get user info depending on phone and company code
  $is_exist_data = $user_obj->get_user_info_reset_password($phone, $company_code);

  // check phone number is exist in database
  if ($is_exist_data == null) {
    $err_arr[] = 'phone not exist';
  }

  $w_phone = !starts_with($phone, "+2") ? "+2$phone" : $phone;
  // check employee phone if valid whatsapp account
  $is_whatsapp_account = $whatsapp_obj->checkContact($w_phone);

  if ((!key_exists('error', $is_whatsapp_account) || !key_exists('Error', $is_whatsapp_account)) && !key_exists('status', $is_whatsapp_account) && $is_whatsapp_account['status'] != 'valid') {
    $err_arr[] = 'not valid whatsapp';
  } elseif (key_exists('error', $is_whatsapp_account)) {
    $err_arr[] = $is_whatsapp_account['error'];
  }

  // check array or error if empty
  if (empty($err_arr)) {
    // get current time
    $time_period = date('a');
    // create an reset code
    $reset_code = generate_random_string(3) . random_digits(3);

    // prepare message
    $msg = ($time_period == 'am' ? lang('GOOD MORNING') : lang('GOOD AFTERNOON')) . " " . $is_exist_data['username'] . " " . lang('DEAR CUSTOMER') . "\n";
    $msg .= $reset_code;
    $msg .= " " . lang('PASSWORD RESET CODE MSG', $lang_file) . " " . lang('SYS TREE') . ", ";
    $msg .= " " . lang('PASSWORD RESET CODE ALERT', $lang_file) . "... ";
    $msg .= "\n" . lang('PASSWORD RESET CODE EXPIRE', $lang_file) . "... ";

    // prepare password reset link
    $link = $_SERVER['HTTP_ORIGIN'] . $_SERVER['PHP_SELF'] . "?d=" . base64_encode('reset-password') . "&token=" . sha1($reset_code) . "&ph0=" . base64_encode($phone) . "&ccode=" . base64_encode($company_code);
    // send message content
    $is_msg_sent = $whatsapp_obj->sendChatMessage($w_phone, $msg);
    // send message link
    $whatsapp_obj->sendLinkMessage($w_phone, $link);

    // check message status
    if (isset($is_msg_sent['sent']) && $is_msg_sent['sent'] == 'true') {
      // add a record into database
      $user_obj->add_password_reset_code(array($phone, sha1($reset_code), $company_code));
      // prepare flash session message
      $_SESSION['flash_message'] = 'RESET PASS CODE SENT';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session message
      $_SESSION['flash_message'] = 'SENT MSG ERROR';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // loop on errors
    foreach ($err_arr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
      // check if link expiration message is exist to remove previous password reset info
      if ($error == 'link expired') {
        // delete reset password info from database
        $user_obj->delete_password_reset_code($phone, $company_code);
      }
    }
  }
  // return home
  redirect_home(null, $_SERVER['PHP_SELF'], 0);
} else {
  ?>
  <div class="loginPageContainer">
    <div class="imgBox">
      <div class="hero-content">
        <img loading="lazy" src="<?php echo $assets ?>images/login-2.svg" alt="" />
      </div>
    </div>
    <div class="contentBox" dir="rtl">
      <div class="formBox">
        <header class="mb-3">
          <h4 class="h4 text-center">
            <?php echo lang('FORGET PASSWORD') ?>
          </h4>
        </header>
        <!-- login form -->
        <form class="login-form" id="login-form" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo lang('PHONE') ?>"
              value="" required>
            <label for="phone">
              <?php echo lang('PHONE') ?>
            </label>
          </div>
          <div class="mb-3 form-floating login">
            <input type="text" class="form-control" id="company-code" name="company-code"
              placeholder="<?php echo lang('COMPANY CODE') ?>" value="" required>
            <label for="company-code">
              <?php echo lang('COMPANY CODE') ?>
            </label>
          </div>
          <div class="mb-2">
            <button type="submit" class="btn btn-primary w-100 text-capitalize" style="border-radius: 6px">
              <i class="bi bi-whatsapp"></i>
              <?php echo lang('SEND CODE') ?>
            </button>
          </div>
          <div class="hstack gap-1 my-2" dir="rtl">
            <div>
              <span>
                <?php echo lang("DON`T HAVE ACCOUNT", $lang_file) ?>&nbsp;
              </span>
              <a href="signup.php" class="text-capitalize" style="border-radius: 6px">
                <?php echo lang('SIGNUP', $lang_file) ?>
              </a>
            </div>
            <div class="me-auto">
              <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="text-capitalize" style="border-radius: 6px">
                <span>
                  <?php echo lang("LOGIN") ?>
                </span>
              </a>
            </div>
          </div>
        </form>
        <hr>
        <div class="row g-2">
          <div class="col-10">
            <a href="../../index.php" class="btn btn-outline-primary w-100">
              <?php echo lang("SPONSOR") ?>
            </a>
          </div>
          <div class="col-2">
            <a href="https://www.facebook.com/LeaderGroupEGYPT" target="_blank"
              class="btn btn-outline-primary w-100 px-0"><i class="bi bi-facebook"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>