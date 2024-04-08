<?php
// check if Get request userid is numeric and get the integer value
$userid = isset($_GET['userid']) && !empty($_GET['userid']) ? base64_decode($_GET['userid']) : 0;
// get back flage value
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// create an object of User class
$user_obj = new User();

// check if user is exist
$is_exist = $user_obj->is_exist("`UserID`", "`users`", $userid);
// if user exist
if ($is_exist == true) {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get user name
    $username = $user_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $userid)['username'];
    // call delete user function
    $is_deleted = $user_obj->temp_delete_user($userid);
    
    // check if deleted
    if ($is_deleted) {
      // log message
      $log_msg = "Users dept:: user deleted temporary successfully.";
      create_logs($_SESSION['sys']['username'], $log_msg);
      
      // prepare flash session variables
      $_SESSION['flash_message'] = 'TEMP DELETED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'QUERY PROBLEM';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  }
  // redirect to home page
  redirect_home(null, $is_back, 0);
} else {
  // include_once no data founded module
  include_once $globmod .'no-data-founded.php';
}