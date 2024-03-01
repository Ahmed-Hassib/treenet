<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get client info from the form
    $id = isset($_POST['client-id']) && !empty($_POST['client-id']) ? base64_decode(trim($_POST['client-id'], ' ')) : 0;
    $full_name = isset($_POST['full-name']) && !empty($_POST['full-name']) ? trim($_POST['full-name'], ' ') : '';
    $ip = isset($_POST['ip']) && !empty($_POST['ip']) ? trim($_POST['ip'], ' ') : '';
    $port = isset($_POST['port']) && !empty($_POST['port']) ? trim($_POST['port'], ' ') : '';
    $username = isset($_POST['user-name']) && !empty($_POST['user-name']) ? trim($_POST['user-name'], ' ') : '';
    $password = isset($_POST['password']) && !empty($_POST['password']) ? trim($_POST['password'], ' ') : '';
    $dir_id = isset($_POST['direction']) && !empty($_POST['direction']) ? base64_decode(trim($_POST['direction'], ' ')) : '';

    // make it client
    $is_client = 1;
    $device_type = 0;

    // get source id
    $source_id = isset($_POST['source-id']) ? base64_decode(trim($_POST['source-id'], ' ')) : -1;
    $alt_source_id = isset($_POST['alt-source-id']) ? base64_decode(trim($_POST['alt-source-id'], ' ')) : -1;
    $device_id = isset($_POST['device-id']) ? base64_decode(trim($_POST['device-id'], ' ')) : -1;
    $model_id = isset($_POST['device-model']) ? trim($_POST['device-model'], ' ') : -1;

    $phone = trim($_POST['phone-number'], ' ');
    $address = trim($_POST['address'], ' ');
    $conn_type = isset($_POST['conn-type']) && !empty($_POST['conn-type']) ? base64_decode(trim($_POST['conn-type'], ' ')) : '';
    $notes = empty(trim($_POST['notes'], ' ')) ? 'لا توجد ملاحظات' : trim($_POST['notes'], ' ');
    $visit_time = isset($_POST['visit-time']) ? $_POST['visit-time'] : 1;
    $ssid = trim($_POST['ssid'], ' ');
    $pass_conn = trim($_POST['password-connection'], ' ');
    $frequency = isset($_POST['frequency']) && !empty($_POST['frequency']) ? trim($_POST['frequency'], ' ') : 0;
    $wave = isset($_POST['wave']) && !empty($_POST['wave']) ? trim($_POST['wave'], ' ') : 0;
    $mac_add = trim($_POST['mac-add'], ' ');
    $coordinates = trim($_POST['coordinates'], ' ');


    $validIP = !empty($ip) ? preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $ip) : 1;
    $validMac = !empty($macAdd) ? preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $macAdd) : 1;

    // validate the form
    $err_arr= array(); // error array

    // validate client id
    if (empty($id) || $id <= 0) {
      $err_arr[] = 'query problem';
    }

    if ($source_id == $id) {
      $source_id = 0;
    }

    if ($alt_source_id == $id) {
      $alt_source_id = 0;
    }

    if (!isset($pcs_obj)) {
      // create an object of Pieces class
      $pcs_obj = new Pieces();
    }

    // check if client or client name is exist or not 
    if (!$pcs_obj->is_exist("`id`", "`pieces_info`", $id)) {
      $err_arr[] = 'no data';
    }

    // check if empty form error
    if (empty($err_arr)) {
      // create an array to collect all basic info
      $basic_info = [];
      // push all basic info in it
      array_push($basic_info, $full_name, $ip, $port, $username, $password, $conn_type, $dir_id, $source_id, $alt_source_id, $is_client, $device_type, $device_id, $model_id, $notes, $visit_time, $id);
      // update basic info
      $is_updated = $pcs_obj->update_piece_info($basic_info);

      // check if address was inserted befor
      $is_exist_addr = $pcs_obj->is_exist("`id`", "`pieces_addr`", $id);
      if ($is_exist_addr == true) {
        // update address
        $pcs_obj->update_address($id, $address);
      } elseif (!$is_exist_addr == true && !empty($address)) {
        // insert address
        $pcs_obj->insert_address($id, $address);
      }

      // check if frequency was inserted befor
      $is_exist_frequency = $pcs_obj->is_exist("`id`", "`pieces_frequency`", $id);
      if ($is_exist_frequency == true) {
        // update frequency
        $pcs_obj->update_frequency($id, $frequency);
      } elseif (!$is_exist_frequency == true && !empty($frequency)) {
        // insert frequency
        $pcs_obj->insert_frequency($id, $frequency);
      }

      // check if mac_add was inserted befor
      $is_exist_mac_addr = $pcs_obj->is_exist("`id`", "`pieces_mac_addr`", $id);
      if ($is_exist_mac_addr == true) {
        // update mac_add
        $pcs_obj->update_mac_add($id, $mac_add);
      } elseif (!$is_exist_mac_addr == true && !empty($mac_add)) {
        // insert mac_add
        $pcs_obj->insert_mac_add($id, $mac_add);
      }

      // check if pass_conn was inserted befor
      $is_exist_pass_connection = $pcs_obj->is_exist("`id`", "`pieces_pass_connection`", $id);
      if ($is_exist_pass_connection == true) {
        // update pass_connection
        $pcs_obj->update_pass_connection($id, $pass_conn);
      } elseif (!$is_exist_pass_connection == true && !empty($pass_conn)) {
        // insert pass_conn
        $pcs_obj->insert_pass_connection($id, $pass_conn);
      }

      // check if phone was inserted befor
      $is_exist_phone = $pcs_obj->is_exist("`id`", "`pieces_phones`", $id);
      if ($is_exist_phone == true) {
        // update phones
        $pcs_obj->update_phones($id, $phone);
      } elseif (!$is_exist_phone == true && !empty($phone)) {
        // insert phone
        $pcs_obj->insert_phones($id, $phone);
      }

      // check if ssid was inserted befor
      $is_exist_ssid = $pcs_obj->is_exist("`id`", "`pieces_ssid`", $id);
      if ($is_exist_ssid == true) {
        // update ssid
        $pcs_obj->update_ssid($id, $ssid);
      } elseif (!$is_exist_ssid == true && !empty($ssid)) {
        // insert ssid
        $pcs_obj->insert_ssid($id, $ssid);
      }

      // check if wave was inserted befor
      $is_exist_wave = $pcs_obj->is_exist("`id`", "`pieces_waves`", $id);
      if ($is_exist_wave == true) {
        // update wave
        $pcs_obj->update_wave($id, $wave);
      } elseif (!$is_exist_wave == true && !empty($wave)) {
        // insert wave
        $pcs_obj->insert_wave($id, $wave);
      }

      // check if wave was inserted befor
      $is_exist_coordinates = $pcs_obj->is_exist("`id`", "`pieces_Coordinates`", $id);
      if ($is_exist_coordinates == true) {
        // update internet source
        $pcs_obj->update_coordinates($id, $coordinates);
      } elseif (!$is_exist_coordinates == true && !empty($coordinates)) {
        // insert internet source
        $pcs_obj->insert_coordinates($id, $coordinates);
      }

      // check type of current piece
      if ($is_client == 0) {
        // update all children direction 
        $pcs_obj->update_children_direction($id, $dir_id);
      }

      // log message
      $log_msg = "Update piece or client info with name `$full_name`";
      create_logs($_SESSION['sys']['username'], $log_msg);

      // prepare flash session variables
      $_SESSION['flash_message'] = 'UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      foreach ($err_arr as $key => $error) {
        // prepare flash session variables
        $_SESSION['flash_message'][$key] = strtoupper($error);
        $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'][$key] = 'danger';
        $_SESSION['flash_message_status'][$key] = false;
        $_SESSION['flash_message_lang_file'][$key] = 'global_';
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
  
  if ($is_client == 0) {
    $target_url = $nav_up_level . "pieces/index.php?do=edit-piece&piece-id=$id";
  } else {
    $target_url = 'back';
  }
  // redirect to previous page
  redirect_home(null, $target_url, 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}