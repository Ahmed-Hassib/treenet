<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create an object of User class
  $user_obj = new User();
  // get rquest info 
  $token_ = isset($_POST['token_']) && !empty($_POST['token_']) ? trim($_POST['token_'], '\n\r\t\v') : null;
  $phone_ = isset($_POST['phone_']) && !empty($_POST['phone_']) ? base64_decode(trim($_POST['phone_'], '\n\r\t\v')) : null;
  $password = isset($_POST['password']) && !empty($_POST['password']) ? trim($_POST['password'], '\n\r\t\v') : null;
  $confirm_pass = isset($_POST['confirm_pass']) && !empty($_POST['confirm_pass']) ? trim($_POST['confirm_pass'], '\n\r\t\v') : null;
  $reset_code = isset($_POST['reset-code']) && !empty($_POST['reset-code']) ? trim($_POST['reset-code'], '\n\r\t\v') : null;
  $company_code = isset($_POST['company-code']) && !empty($_POST['company-code']) ? trim($_POST['company-code'], '\n\r\t\v') : null;


  // array of error
  $err_arr = array();

  // make validation on phone
  if ($phone_ == null) {
    $err_arr[] = 'phone empty';
  }

  // make validation on company_code
  if ($company_code == null) {
    $err_arr[] = 'company code empty';
  }

  // get user info depending on phone and company code
  $is_exist_data = $user_obj->get_user_info_reset_password($phone_, $company_code);

  // check phone number is exist in database
  if ($is_exist_data == null) {
    $err_arr[] = 'phone not exist';
  }

  // get latest password reset
  $reset_pass_info = $user_obj->get_reset_password_info($phone_, $company_code);
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
    } elseif ($reset_pass_info['token'] != $token_ && $reset_pass_info['token'] != sha1($reset_code)) { // check token in database is equal to token in link
      $err_arr[] = 'token not equal';
    }
  } else {
    $err_arr[] = 'link expired';
  }

  // check password equalization
  if ($password !== $confirm_pass) {
    $err_arr[] = 'password not equal';
  }

  // check array of error
  if (empty($err_arr)) {
    // reset user password in database
    $user_obj->reset_password(sha1($password), $is_exist_data['UserID']);
    // delete reset password info from database
    $user_obj->delete_password_reset_code($phone_, $company_code);
    $_SESSION['flash_message'] = 'PASSWORD UPDATED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = $lang_file;
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
        $user_obj->delete_password_reset_code($phone_, $company_code);
      }
    }
  }
  // return back
  redirect_home(null, $_SERVER['PHP_SELF'], 0);
} else {
  include_once $globmod . 'permission-error.php';
}