<?php
// get request info
$username       = $_POST["username"];
$password       = $_POST["password"];
$company_code   = $_POST["company-code"];
$hashed_pass    = sha1($password);

// array of error
$err_arr = array();

// check username
if (empty($username)) {
  $err_arr[] = 'username empty';
}

// check password
if (empty($password)) {
  $err_arr[] = 'password empty';
}

// check company code
if (empty($company_code)) {
  $err_arr[] = 'code empty';
}

// check errors
if (empty($err_arr)) {
  // create an object of Login class
  $login_obj = new Login($username, $password, $company_code);

  // get user data 
  $user_info = $login_obj->emp_login();

  // if count > 0 this mean that user exist
  if ($user_info != null) {
    // create an object of Session class to set session
    $session_obj = !isset($session_obj) ? new Session() : $session_obj;
    // set session
    $session_obj->set_user_session($user_info);
    // check license expiration
    if (isset($_SESSION['sys']['isLicenseExpired']) && $_SESSION['sys']['isLicenseExpired'] == 1) {
      // query statement
      $query = "UPDATE `license` SET `isEnded`= 1 WHERE `ID` = ?";
      // prepare statement
      $stmt = $con->prepare($query);
      $stmt->execute(array($_SESSION['sys']['license_id']));
    }
    // set system language
    $_SESSION['sys']['lang'] = $_POST['language'];
    $lang = $_POST['language'] == 'ar' ? 0 : 1;
    // create an object of User class
    $user_obj =  new User();
    // call change_user_langugae
    $is_changed = $user_obj->change_user_language($lang, $_SESSION['sys']['UserID']);

    // prepare flash session variables
    $_SESSION['flash_message'] = 'LOGIN SUCCESS';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
    // check logined user
    if ($_SESSION['sys']['is_root'] == 1) {
      // redirect to admin page
      header("Location: {$treenet_root}dashboard/index.php");
      exit();
    } else {
      // redirect to user page
      header("Location: {$treenet_user}dashboard/index.php");
      exit();
    }
  } else {
    // prepare flash message variables
    $_SESSION['flash_message'] = 'LOGIN FAILED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
    // redirect back
    redirect_home(null, 'back', 0);
  }
} else {
  // prepare flash message variables
  foreach ($err_arr as $key => $err) {
    $_SESSION['flash_message'][$key] = strtoupper($err);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'login';
  }
  // redirect back
  redirect_home(null, 'back', 0);
}
