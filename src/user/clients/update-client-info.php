<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get client info from the form
    $id = isset($_POST['client-id']) && !empty($_POST['client-id']) ? base64_decode(trim($_POST['client-id'], ' ')) : 0;
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
    $source_id = isset($_POST['source-id']) && filter_var(intval(base64_decode(trim($_POST['source-id'], ' '))), FILTER_VALIDATE_INT) !== false ? base64_decode(trim($_POST['source-id'], ' ')) : -1;
    $alt_source_id = isset($_POST['alt-source-id']) && filter_var(intval(base64_decode(trim($_POST['alt-source-id'], ' '))), FILTER_VALIDATE_INT) !== false ? base64_decode(trim($_POST['alt-source-id'], ' ')) : -1;
    $device_id = isset($_POST['device-id']) && filter_var(intval(base64_decode(trim($_POST['device-id'], ' '))), FILTER_VALIDATE_INT) !== false ? base64_decode(trim($_POST['device-id'], ' ')) : null;
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

    $validIP = !empty($ip) && filter_var($ip, FILTER_VALIDATE_IP) ? preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $ip) : 1;
    $validMac = !empty($macAdd) && filter_var($mac_add, FILTER_VALIDATE_MAC) ? preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $macAdd) : 1;

    // validate the form
    $err_arr = array(); // error array

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
      array_push($basic_info, $full_name, $ip, $port, $username, $password, $conn_type, $dir_id, $source_id, $alt_source_id, $is_client, $device_type, $device_id, $model_id, $address, $coordinates, $frequency, $mac_add, $pass_conn, $ssid, $wave, $notes, $visit_time, $id);
      // update basic info
      $is_updated = $pcs_obj->update_piece_info($basic_info);

      // check if phone was inserted befor
      $is_exist_phone = $pcs_obj->is_exist("`id`", "`pieces_phones`", $id);
      if ($is_exist_phone == true) {
        // update phones
        $pcs_obj->update_phones($id, $phone);
      } elseif (!$is_exist_phone == true && !empty($phone)) {
        // insert phone
        $pcs_obj->insert_phones($id, $phone);
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
