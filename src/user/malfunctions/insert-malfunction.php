<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get piece info from the form
    $mng_id = isset($_POST['admin-id']) ? base64_decode($_POST['admin-id']) : null;
    $tech_id = isset($_POST['technical-id']) ? base64_decode($_POST['technical-id']) : null;
    $client_id = isset($_POST['client-id']) ? $_POST['client-id'] : null;
    $descreption = isset($_POST['descreption']) ? $_POST['descreption'] : null;

    // validate the form
    $formErorr = array(); // error array 

    // validate manager id
    if (empty($mng_id) || $mng_id == null) {
      $formErorr[] = 'admin null';
    }
    // validate technical id
    if (empty($tech_id) || $tech_id == null) {
      $formErorr[] = 'tech null';
    }
    // validate client
    if (empty($client_id) || $client_id == null) {
      $formErorr[] = 'clt null';
    }
    // validate descreption
    if (empty($descreption) || $descreption == null) {
      $formErorr[] = 'desc null';
    }

    // check if empty form error
    if (empty($formErorr)) {
      // array of malfunction information
      $mal_info = array();
      // push info into the array
      array_push($mal_info, $mng_id, $tech_id, $client_id, $descreption, base64_decode($_SESSION['sys']['company_id']));

      // create an object of Malfunction class
      $mal_obj = new Malfunction();
      // get next malfunction id
      $mal_id = $mal_obj->get_next_id("jsl_db", "malfunctions");

      // call insert function
      $is_inserted = $mal_obj->insert_new_malfunction($mal_info);

      // check if malfunction was inserted or not
      if ($is_inserted) {
        // prepare flash session variables
        $_SESSION['flash_message'][0] = 'INSERTED';
        $_SESSION['flash_message_icon'][0] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'][0] = 'success';
        $_SESSION['flash_message_status'][0] = true;
        $_SESSION['flash_message_lang_file'][0] = 'malfunctions';
        // add an new detail record
        $mal_obj->add_malfunction_updates(array($mal_id, 0, 'insert malfunction', base64_decode($_SESSION['sys']['company_id'])));

        // get admin info
        $admin_info = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = $mng_id")['username'];
        // get technical man info
        $tech_info = $mal_obj->select_specific_column("`username`, `phone`, `is_activated_phone`", "`users`", "WHERE `UserID` = $tech_id");

        // create an object of Pieces class
        $pcs_obj = new Pieces();
        // get client info
        $client_info = $pcs_obj->get_pieces("WHERE `pieces_info`.`id` = {$client_id}", 1);
        // send a notification to technical man
        $res = $mal_obj->send_notification($admin_info, $tech_info, $client_info, $descreption, $lang_file);
        // add an new detail record
        $mal_obj->add_malfunction_updates(array($mal_id, 0, 'send notification', base64_decode($_SESSION['sys']['company_id'])));
        // check result of malfunction info notification
        if ($res['mal_info']) {
          // prepare flash session variables
          $_SESSION['flash_message'][1] = 'SEND NOTIFICATION';
          $_SESSION['flash_message_icon'][1] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'][1] = 'success';
          $_SESSION['flash_message_status'][1] = true;
          $_SESSION['flash_message_lang_file'][1] = $lang_file;
        }
        // check result of malfunction info notification
        if ($res['location_info']) {
          // prepare flash session variables
          $_SESSION['flash_message'][2] = 'SEND LOCATION NOTIFICATION';
          $_SESSION['flash_message_icon'][2] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'][2] = 'success';
          $_SESSION['flash_message_status'][2] = true;
          $_SESSION['flash_message_lang_file'][2] = $lang_file;
        }
      } else {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'QUERY PROBLEM';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_status'] = 'global_';
      }
    } else {
      // assign post data to session
      $_SESSION['request_data'] = $_POST;
      // loop on errors
      foreach ($formErorr as $key => $error) {
        $_SESSION['flash_message'][$key] = strtoupper($error);
        $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'][$key] = 'danger';
        $_SESSION['flash_message_status'][$key] = false;
        $_SESSION['flash_message_lang_file'][$key] = $lang_file;
      }
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_status'] = 'global_';
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}