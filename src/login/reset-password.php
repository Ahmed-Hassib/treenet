<?php
// create an object of User class
$user_obj = new User();
// get token
$token = isset($_GET['token']) && !empty($_GET['token']) ? trim($_GET['token'], '\n\r\t\v') : null;
// get phone number
$phone = isset($_GET['ph0']) && !empty($_GET['ph0']) ? base64_decode(trim($_GET['ph0'], '\n\r\t\v')) : null;
// get company code
$company_code = isset($_GET['ccode']) && !empty($_GET['ccode']) ? base64_decode(trim($_GET['ccode'])) : null;

// array of error
$err_arr = array();

// make validation on phone
if ($phone == null) {
  $err_arr[] = 'phone empty';
}

// make validation on company_code
if ($company_code == null) {
  $err_arr[] = 'company code empty';
}

// get user info depending on phone and company code
$is_exist_data = $user_obj->get_user_info_reset_password($phone, $company_code);

// check phone number is exist in database
if ($is_exist_data == null) {
  $err_arr[] = 'phone not exist';
}

// get latest password reset
$reset_pass_info = $user_obj->get_reset_password_info($phone, $company_code);
// check last rest password info
if ($reset_pass_info != null && count($reset_pass_info) > 0) {
  // get last password reset time
  $last_pass_reset_time = date_create($reset_pass_info['created_at']);
  // get time name
  $time_now = date_create(get_time_now('Y-m-d H:i:s'));
  // get diffrence between times
  $time_diff = date_diff($time_now, $last_pass_reset_time);

  // check number of days and hours
  if (($time_diff->y > 0 && $time_diff->m > 0 && $time_diff->d > 0 && $time_diff->h > 0) || ($time_diff->y == 0 && $time_diff->m == 0 && $time_diff->d == 0 && $time_diff->h == 0 && $time_diff->i > 15)) {
    $err_arr[] = 'link expired';
  } elseif ($reset_pass_info['token'] != $token) { // check token in database is equal to token in link
    $err_arr[] = 'token not equal';
  }
} else {
  $err_arr[] = 'link expired';
}


// check array of error
if (empty($err_arr)) {
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
            <?php echo lang('RESET PASSWORD', $lang_file) ?>
          </h4>
        </header>
        <!-- login form -->
        <form class="login-form" id="reset-password-form"
          action="?d=<?php echo base64_encode('process-reset-password') ?>" method="POST">
          <input type="hidden" name="phone_" value="<?php echo base64_encode($phone) ?>">
          <input type="hidden" name="token_" value="<?php echo $token ?>">
          <div class=" mb-3 form-floating">
          <input type="password" class="form-control" id="password" name="password"
            placeholder="<?php echo lang('PASSWORD') ?>"
            onblur="confirm_password(confirm_pass, this, 'reset-password-form')" value="" required>
          <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
          <label for="password">
            <?php echo lang('PASSWORD') ?>
          </label>
      </div>
      <div class="mb-3 form-floating">
        <input type="password" class="form-control" id="confirm_pass" name="confirm_pass"
          placeholder="<?php echo lang('CONFIRM PASSWORD', $lang_file) ?>"
          onblur="confirm_password(this, password, 'reset-password-form')" value="" required>
        <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
        <label for="confirm_pass">
          <?php echo lang('CONFIRM PASSWORD', $lang_file) ?>
        </label>
      </div>
      <div class="mb-3 form-floating login">
        <input type="text" class="form-control" id="reset-code" name="reset-code"
          placeholder="<?php echo lang('RESET CODE') ?>" value="" required>
        <label for="reset-code">
          <?php echo lang('RESET CODE', $lang_file) ?>
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
          <i class="bi bi-check-all"></i>
          <?php echo lang('SAVE') ?>
        </button>
      </div>
      <div class="hstack gap-1 my-2" dir="rtl">
        <div>
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
<?php } else {
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
  // return home
  redirect_home(null, $_SERVER['PHP_SELF'], 0);
}