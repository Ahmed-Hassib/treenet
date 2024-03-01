<?php
// check rquest method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get system ststus
  $is_developing = isset($_POST['system_status']) ? trim($_POST['system_status']) : null;
  
  // array of error
  $err_arr = array();

  // check system status value
  if ($is_developing == null) {
    $err_arr[] = 'status required';
  }

  // check if array of error empty
  if (empty($err_arr)) {
    // create an object of SystemSettings class
    $sys_settings = new SystemSettings();

    // change status
    $is_changed = $sys_settings->update_system_status($is_developing);

    // check if changed
    if ($is_changed) {
      // prepare flash session variables
      $_SESSION['flash_message'] = strtoupper('system ' . (!$is_developing ? 'activated' : 'deactivated'));
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
      $_SESSION['flash_message_lang_file'] = $lang_file;
    }

  } else {
    // loop on errors
    foreach ($err_arr as $key => $error) {
      // prepare flash session variables
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
  }
  // redirect to previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}