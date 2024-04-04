<?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>
  <div class="cntainer" dir="<?php echo $page_dir ?>">
    <div class="row row-cols-sm-1 justify-content-center align-items-center">
      <div class="contactus-section">
        <div class="section-block">
          <header class="section-header">
            <h3 class="h3"><?php echo lang('CONTACT US', $lang_file) ?></h3>
            <hr>
          </header>
          <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">

            <input type="hidden" name="userid" value="<?php echo $_SESSION['sys']['UserID'] ?>">
            <div class="mb-3 form-floating">
              <input type="text" class="form-control" placeholder="<?php echo lang('USERNAME') ?>" name="username" id="username" value="<?php echo $_SESSION['sys']['username'] ?>" readonly required>
              <label for="username"><?php echo lang('USERNAME') ?></label>
            </div>
            <div class="mb-3 form-floating">
              <input type="text" class="form-control" placeholder="<?php echo lang('PHONE', 'employees') ?>" name="phone" id="phone" value="<?php echo isset($_SESSION['request_data']['phone']) && !empty($_SESSION['request_data']['phone']) ? $_SESSION['request_data']['phone'] : $_SESSION['sys']['phone'] ?>" required>
              <label for="phone"><?php echo lang('PHONE', 'employees') ?></label>
            </div>
            <div class="mb-3 form-floating">
              <input type="email" class="form-control" placeholder="<?php echo lang('email', 'employees') ?>" value="<?php echo isset($_SESSION['request_data']['email']) && !empty($_SESSION['request_data']['email']) ? $_SESSION['request_data']['email'] : $_SESSION['sys']['email'] ?>" name="email" id="email" required>
              <label for="email"><?php echo lang('email', 'employees') ?></label>
            </div>
            <div class="mb-3 form-floating">
              <textarea name="message" id="message" placeholder="<?php echo lang('PUT YOUR MESSAGE HERE') ?>" class="form-control" required><?php echo isset($_SESSION['request_data']['message']) && !empty($_SESSION['request_data']['message']) ? $_SESSION['request_data']['message'] : null ?></textarea>
              <label for="message"><?php echo lang('PUT YOUR MESSAGE HERE', $lang_file) ?></label>
            </div>

            <div class="mb-3">
              <button class="btn btn-primary w-100" onclick="fom_validation(this.form)">
                <?php echo lang('SEND') ?>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get post request data
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  $user_id = isset($_POST['userid']) && !empty($_POST['userid']) ? base64_decode($_POST['userid']) : base64_decode($_SESSION['sys']['UserID']);
  $username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : $_SESSION['sys']['username'];
  $phone = isset($_POST['phone']) && !empty($_POST['phone']) ? $_POST['phone'] : $_SESSION['sys']['phone'];
  $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
  $message = isset($_POST['message']) && !empty($_POST['message']) ? $_POST['message'] : '';

  // array of error
  $err_arr = array();

  // validate post request data
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $err_arr[] = 'invalid email';
  }

  if (empty($message)) {
    $err_arr[] = 'empty message';
  }

  if (empty($err_arr)) {
  ?>

    <div class="container align-items-center" dir="<?php echo $page_dir ?>">
      <div class="row row-cols-sm-1 align-items-center justify-content-center">
        <div class="contact-form-loading">
          <?php echo lang('SENDING MESSAGE') ?>...
        </div>
        <div class="contact-form-alert d-none">
          <div class="alert alert-success">
            <i class="bi bi-send-check-fill"></i>
            <h3 class="h3">
              <?php echo lang('MESSAGE WAS SENT', $lang_file) ?>!
            </h3>

            <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="mt-3 btn btn-outline-primary w-100">
              <?php echo lang('BACK') ?>
            </a>
          </div>
        </div>
      </div>
    </div>

    <script>
      // prepare data
      let contact_form_data = {
        user_id: '<?php echo $user_id ?>',
        username: '<?php echo $username ?>',
        company_id: '<?php echo $company_id ?>',
        phone: '<?php echo $phone ?>',
        email: '<?php echo $email ?>',
        message: '<?php echo $message ?>'
      }
      // target url to send data to gmail
      let target_url = "https://script.google.com/macros/s/AKfycbwM1pyBn_3zslHWJOfco2ybrkoazEsqFRr4Ny3VIErzOMOcE8_iPCYVfyBTkeN_HRct/exec";
      // request data
      $.post(target_url, contact_form_data, (data) => {
        if (data.result == 'success') {
          document.querySelector('.contact-form-loading').remove();
          document.querySelector('.contact-form-alert').classList.remove('d-none');
        }
      })
    </script>
<?php } else {
    $_SESSION['request_data'] = $_POST;
    // loop on errors
    foreach ($err_arr as $key => $error) {
      // prepare flash session variables
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
    // redirect to previous page
    redirect_home(null, 'back', 0);
  }
} else {
  // include permission error
  include_once  $globmod . 'page-error.php';
} ?>