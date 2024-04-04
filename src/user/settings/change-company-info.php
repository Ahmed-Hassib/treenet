<?php
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  // create an object of Company class
  $company_obj = new Company();

  // get company new info
  $company_name = isset($_POST['company_name']) && !empty($_POST['company_name']) ? $_POST['company_name'] : null;
  $company_manager_name = isset($_POST['company_manager_name']) && !empty($_POST['company_manager_name']) ? $_POST['company_manager_name'] : null;
  $company_phone = isset($_POST['company_phone']) && !empty($_POST['company_phone']) ? $_POST['company_phone'] : null;
  $company_country = isset($_POST['country']) && !empty($_POST['country']) ? $_POST['country'] : null;

  // array of error
  $err_arr = array();

  // check company name
  if (empty($company_name)) {
    $err_arr[] = 'company empty';
  }

  // check manager name
  if (empty($company_manager_name)) {
    $err_arr[] = 'manager empty';
  }

  if (!is_triple_parts_name($company_manager_name)) {
    $err_arr[] = 'manager not triple';
  }

  // check manager phone
  if (empty($company_phone)) {
    $err_arr[] = 'phone empty';
  }

  // check country
  if (empty($company_country)) {
    $err_arr[] = 'country empty';
  }


  // log message
  $log_msg = '';

  // check array of error
  if (empty($err_arr)) {
    $is_updated = false;
    if ($is_updated) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'COMPANY INFO UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;

      // log message
      $log_msg = "company info was updated successfully by " . $_SESSION['sys']['username'] . " at " . date('D d/m/Y h:i a');

      // create an object of Session class
      $session_obj = new Session();
      // set user session
      $session_obj->update_session(base64_decode($_SESSION['sys']['UserID']));
      
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO CHANGES';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'info';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
      // log message
      $log_msg = "there is no changes was added to update company info";
    }
  } else {
    foreach ($err_arr as $key => $error) {
      // prepare flash session variables
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'login';
      $log_msg .= "there is no changes was added to update company info";
    }
  }
  // create a log
  create_logs($_SESSION['sys']['username'], $log_msg);
  // redirect home
  redirect_home(null, 'back', 0);
} else {
  // include_once per
  include_once $globmod . 'permission-error.php';
}
