<?php
// check if post request was fired
if (isset($_POST) && isset($_POST['mikrotik_status'])) {
  // company id
  $company_id = base64_decode($_POST['company_id']);
  // get status
  $status = $_POST['mikrotik_status'];

  // create an object of Mikrotik class
  $mikrotik_obj = new Mikrotik();
  // check if company has a mikrotik info in database
  $is_exist_data = $mikrotik_obj->is_exist("`company_id`", "`mikrotik_settings`", $company_id);
  // check if exists
  if ($is_exist_data) {
    // call update mikrotik service status
    $is_updated = $mikrotik_obj->update_mikrotik_status($status, $company_id);
  } else {
    // insert new values
    $is_updated = $mikrotik_obj->insert_mikrotik_info(array($company_id, null, null, null, null, $status));
  }

  // check if changed
  if ($is_updated) {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'MIKROTIK SERVICE STATUS ' . ($status ? 'ACTIVATED' : 'DEACTIVATED');
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = $lang_file;
    // log message
    $log_msg = "mikrotik service status was updated successfully by " . $_SESSION['sys']['username'] . " at " . date('D d/m/Y h:i a');
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NO CHANGES';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'info';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
    // log message
    $log_msg = "there is no data was added to update mikrotik service status";
  }

  // create an object of Session class
  $session_obj = new Session();
  // get user info
  $user_info = $session_obj->get_user_info(base64_decode($_SESSION['sys']['UserID']));
  // check if done
  if ($user_info[0] == true) {
    // set user session
    $session_obj->set_user_session($user_info[1]);
  }
  // create a log
  create_logs($_SESSION['sys']['username'], $log_msg);
} else {
  // log message
  $log_msg = "there is no permission to update mikrotik service status";
  // prepare flash session variables
  $_SESSION['flash_message'] = 'PERMISSION FAILED';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'info';
  $_SESSION['flash_message_status'] = false;
  $_SESSION['flash_message_lang_file'] = 'global_';
}
// redirect home
redirect_home(null, $_SERVER['SCRIPT_NAME'], 0);