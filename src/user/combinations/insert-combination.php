<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {

    // get piece info from the form
    $admin_id = isset($_POST['admin-id']) && !empty($_POST['admin-id']) ? base64_decode($_POST['admin-id']) : null;
    $tech_id = isset($_POST['technical-id']) && !empty($_POST['technical-id']) ? base64_decode($_POST['technical-id']) : null;
    $client_name = isset($_POST['client-name']) && !empty($_POST['client-name']) ? $_POST['client-name'] : null;
    $client_phone = isset($_POST['client-phone']) && !empty($_POST['client-phone']) ? $_POST['client-phone'] : null;
    $client_addr = isset($_POST['client-address']) && !empty($_POST['client-address']) ? $_POST['client-address'] : null;
    $client_notes = isset($_POST['client-notes']) && !empty($_POST['client-notes']) ? $_POST['client-notes'] : null;
    $client_coordinates = isset($_POST['coordinates']) && !empty($_POST['coordinates']) ? $_POST['coordinates'] : null;

    // validate the form
    $formErorr = array(); // error array 

    // validate admin id
    if (empty($admin_id) || $admin_id == null) {
      $formErorr[] = 'admin null';
    }

    // validate technical id
    if (empty($tech_id)) {
      $formErorr[] = 'tech null';
    }

    // validate client name
    if (empty($client_name) || $client_name == null) {
      $formErorr[] = 'client null';
    }

    // validate technical id
    if (empty($client_phone)) {
      $formErorr[] = 'phone null';
    }

    // validate username
    if (empty($client_addr)) {
      $formErorr[] = 'address null';
    }

    // check if empty form error
    if (empty($formErorr)) {
      // create an empty array of comination info
      $comb_info = array();

      // create an object of Combination
      $comb_obj = new Combination();
      // get next combination id
      $comb_id = $comb_obj->get_next_id("jsl_db", "combinations");

      // push info into the array
      array_push($comb_info, $client_name, $client_phone, $client_addr, $client_coordinates, $client_notes, $tech_id, $admin_id, base64_decode($_SESSION['sys']['company_id']));

      // call insert_new_combination function
      $is_inserted = $comb_obj->insert_new_combination($comb_info);

      // check if inserted
      if ($is_inserted == true) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'INSERTED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = $lang_file;
        // add an new detail record
        $comb_obj->add_combination_updates(array($comb_id, $admin_id, 'insert combination', base64_decode($_SESSION['sys']['company_id'])));

        // // get admin info
        // $admin_info = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = $admin_id")['username'];
        // // get technical man info
        // $tech_info = $comb_obj->select_specific_column("`username`, `phone`, `is_activated_phone`", "`users`", "WHERE `UserID` = $tech_id");
        // // client info
        // $client_info = ["name" => $client_name, "addr" => $client_addr, "phone" => $client_phone, "notes" => $client_notes];
        // // send a notification to technical man
        // $comb_obj->send_notification($admin_info, $tech_info, $client_info, $lang_file);
        // // add an new detail record
        // $comb_obj->add_combination_updates(array($comb_id, 0, 'send notification', base64_decode($_SESSION['sys']['company_id'])));
      } else {
        // assign $_POST values to session
        $_SESSION['request_data'] = $_POST;
        // prepare flash session variables
        $_SESSION['flash_message'] = 'QUERY PROBLEM';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
    } else {
      // assign $_POST values to session
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
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // return home
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}