<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // create an object of Pieces class
    $pcs_obj = new Pieces();
    // get clients counter 
    $company_clients_counter = intval($db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])));
    // get plan clients
    $plan_clients_counter = intval($db_obj->select_specific_column("`clients`", "`pricing_plans`", "WHERE `id` = " . base64_decode($_SESSION['sys']['plan_id']))[0]['clients']);
    // get latest id in pieces table
    $latest_id = intval($pcs_obj->get_latest_records("`id`", "`pieces_info`", "", "`id`", 1)[0]['id']);
    // get next id
    $id = $latest_id + 1;
    // get piece info from the form
    $full_name = isset($_POST['full-name']) && !empty($_POST['full-name']) ? trim($_POST['full-name'], ' ') : '';
    $ip = isset($_POST['ip']) && !empty($_POST['ip']) ? trim($_POST['ip'], ' ') : null;
    $port = isset($_POST['port']) && !empty($_POST['port']) ? trim($_POST['port'], ' ') : null;
    $username = isset($_POST['user-name']) && !empty($_POST['user-name']) ? trim($_POST['user-name'], ' ') : null;
    $password = isset($_POST['password']) && !empty($_POST['password']) ? trim($_POST['password'], ' ') : null;
    $dir_id = isset($_POST['direction']) && !empty($_POST['direction']) ? base64_decode(trim($_POST['direction'], ' ')) : '';

    // make it client
    $is_client = 1;
    $device_type = 0;

    // get source id
    $source_id = isset($_POST['source-id']) ? trim($_POST['source-id'], ' ') : -1;
    $alt_source_id = isset($_POST['alt-source-id']) ? trim($_POST['alt-source-id'], ' ') : -1;
    $device_id = isset($_POST['device-id']) ? base64_decode(trim($_POST['device-id'], ' ')) : null;
    $model_id = isset($_POST['device-model']) ? trim($_POST['device-model'], ' ') : null;

    $phone = !empty(trim($_POST['phone-number'], ' ')) ?  trim($_POST['phone-number'], ' ') : null;
    $address = !empty(trim($_POST['address'], ' ')) ?  trim($_POST['address'], ' ') : null;
    $conn_type = isset($_POST['conn-type']) && !empty($_POST['conn-type']) ? base64_decode(trim($_POST['conn-type'], ' ')) : null;
    $notes = empty(trim($_POST['notes'], ' ')) ? 'لا توجد ملاحظات' : trim($_POST['notes'], ' ');
    $visit_time = isset($_POST['visit-time']) ? $_POST['visit-time'] : 1;
    $ssid = !empty(trim($_POST['ssid'], ' ')) ? trim($_POST['ssid'], ' ') : null;
    $pass_conn = !empty(trim($_POST['password-connection'], ' ')) ? trim($_POST['password-connection'], ' ') : null;
    $frequency = isset($_POST['frequency']) && !empty($_POST['frequency']) ? trim($_POST['frequency'], ' ') : null;
    $wave = isset($_POST['wave']) && !empty($_POST['wave']) ? trim($_POST['wave'], ' ') : null;
    $mac_add = !empty(trim($_POST['mac-add'], ' ')) ? trim($_POST['mac-add'], ' ') : null;
    $coordinates = !empty(trim($_POST['coordinates'], ' ')) ? trim($_POST['coordinates'], ' ') : null;

    // validate the form
    $err_arr = array(); // error array

    if ($source_id == $id) {
      $source_id = 0;
    }

    if ($alt_source_id == $id) {
      $alt_source_id = 0;
    }

    // check if user is exist in database or not
    $is_exist_name = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `full_name` = '$full_name' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
    $is_exist_mac = !empty($macAdd) && filter_var($macAdd, FILTER_VALIDATE_MAC) !== false ? $pcs_obj->count_records("`id`", "`pieces_info`", "`mac_add` = '{$mac_add}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])) : 0;

    // check piece name
    if ($is_exist_name > 0) {
      $err_arr[] = 'name exist';
    }

    // check piece mac
    if ($is_exist_mac > 0) {
      $err_arr[] = 'mac exist';
    }

    // check piece mac
    if (!is_null($ip) && $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `ip` = '{$ip}' AND `direction_id` = {$dir_id} AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']))) {
      $err_arr[] = 'ip exist';
    }

    // check number of clients and its plan clients
    if ($company_clients_counter >= $plan_clients_counter) {
      $err_arr[] = 'clients max limit';
    }

    // check if empty form error
    if (empty($err_arr)) {
      // get current date
      $date_now = get_date_now();
      // call insert function
      $is_inserted = $pcs_obj->insert_new_piece(array($full_name, $ip, $port, $username, $password, $conn_type, $dir_id, $source_id, $alt_source_id, $is_client, $device_type, $device_id, $model_id, $address, $coordinates, $frequency, $mac_add, $pass_conn, $ssid, $wave, base64_decode($_SESSION['sys']['UserID']), base64_decode($_SESSION['sys']['company_id']), $notes, $visit_time));

      // check phones
      if (!empty($phone)) {
        // echo "<br>* phone is not empty<br>";
        // insert phones
        $pcs_obj->insert_phones($id, $phone);
      }

      // check if inserted
      if ($is_inserted) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'INSERTED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = $lang_file;
      } else {
        // assign POST request data to session
        $_SESSION['request_data'] = $_POST;
        // prepare flash session variables
        $_SESSION['flash_message'] = 'QUERY PROBLEM';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
    } else {
      // assign POST request data to session
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
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect to previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
