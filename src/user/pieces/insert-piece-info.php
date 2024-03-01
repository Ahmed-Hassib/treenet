<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // create an object of Pieces class
    $pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
    // get latest id in pieces table
    $latest_id = intval($pcs_obj->get_latest_records("`id`", "`pieces_info`", "", "`id`", 1)[0]['id']);
    // get next id
    $id = $latest_id + 1;
    // get piece info from the form
    $full_name = isset($_POST['full-name']) && !empty($_POST['full-name']) ? trim($_POST['full-name'], ' ') : '';
    $ip = isset($_POST['ip']) && !empty($_POST['ip']) ? trim($_POST['ip'], ' ') : '';
    $port = isset($_POST['port']) && !empty($_POST['port']) ? trim($_POST['port'], ' ') : '';
    $username = isset($_POST['user-name']) && !empty($_POST['user-name']) ? trim($_POST['user-name'], ' ') : '';
    $password = isset($_POST['password']) && !empty($_POST['password']) ? trim($_POST['password'], ' ') : '';
    $dir_id = isset($_POST['direction']) && !empty($_POST['direction']) ? base64_decode(trim($_POST['direction'], ' ')) : '';

    // check if client or not
    if (isset($_POST['is-client'])) {
      // get value
      $is_client_value = $_POST['is-client'];
      // switch ... case
      switch ($is_client_value) {
        case 1:
          // make it transmitter
          $is_client = 0;
          $device_type = 1;
          break;

        case 2:
          // make it receiver
          $is_client = 0;
          $device_type = 2;
          break;

        default:
          // make it default
          $is_client = -1;
          $device_type = -1;
          break;
      }
    } else {
      // make it default
      $is_client = -1;
      $device_type = -1;
    }

    // get source id
    $source_id = isset($_POST['source-id']) ? trim($_POST['source-id'], ' ') : -1;
    $alt_source_id = isset($_POST['alt-source-id']) ? trim($_POST['alt-source-id'], ' ') : -1;
    $device_id = isset($_POST['device-id']) ? base64_decode(trim($_POST['device-id'], ' ')) : -1;
    $model_id = isset($_POST['device-model']) ? trim($_POST['device-model'], ' ') : -1;

    $phone = trim($_POST['phone-number'], ' ');
    $address = trim($_POST['address'], ' ');
    $conn_type = isset($_POST['conn-type']) && !empty($_POST['conn-type']) ? trim($_POST['conn-type'], ' ') : '';
    $notes = empty(trim($_POST['notes'], ' ')) ? 'لا توجد ملاحظات' : trim($_POST['notes'], ' ');
    $visit_time = isset($_POST['visit-time']) ? $_POST['visit-time'] : 1;
    $ssid = trim($_POST['ssid'], ' ');
    $pass_conn = trim($_POST['password-connection'], ' ');
    $frequency = trim($_POST['frequency'], ' ');
    $wave = trim($_POST['wave'], ' ');
    $mac_add = trim($_POST['mac-add'], ' ');
    $coordinates = trim($_POST['coordinates'], ' ');

    // validate the form
    $err_arr= array(); // error array

    if ($source_id == $id) {
      $source_id = 0;
    }

    if ($alt_source_id == $id) {
      $alt_source_id = 0;
    }

    // check if user is exist in database or not
    $is_exist_name = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `full_name` = $full_name AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
    $is_exist_mac = !empty($macAdd) ? $pcs_obj->count_records("`pieces_mac_addr`.`id`", "`pieces_mac_addr`", "LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` = $mac_add AND `pieces_info`.`company_id` = " . base64_decode($_SESSION['sys']['company_id'])) : 0;
    $is_exist_ip = $ip == '0.0.0.0' ? 0 : $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `ip` = '$ip' AND `direction_id` = $dir_id AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));

    // check piece name
    if ($is_exist_name > 0) {
      $err_arr[] = 'username exist';
    }

    // check piece mac
    if ($is_exist_mac > 0) {
      $err_arr[] = 'mac exist';
    }

    // check piece mac
    if ($is_exist_ip > 0) {
      $err_arr[] = 'ip exist';
    }

    // check if empty form error
    if (empty($err_arr)) {
      // get current date
      $date_now = get_date_now();
      // call insert function
      $is_inserted = $pcs_obj->insert_new_piece(array($full_name, $ip, $port, $username, $password, $conn_type, $dir_id, $source_id, $alt_source_id, $is_client, $device_type, $device_id, $model_id, base64_decode($_SESSION['sys']['UserID']), base64_decode($_SESSION['sys']['company_id']), $notes, $visit_time));

      // check address
      if (!empty($address)) {
        // insert address
        $pcs_obj->insert_address($id, $address);
      }

      // check frequency
      if (!empty($frequency)) {
        // insert frequency
        $pcs_obj->insert_frequency($id, $frequency);
      }

      // check mac_add
      if (!empty($mac_add)) {
        // insert mac_add
        $pcs_obj->insert_mac_add($id, $mac_add);
      }

      // check pass_connection
      if (!empty($pass_conn)) {
        // insert pass_conn
        $pcs_obj->insert_pass_connection($id, $pass_conn);
      }

      // check phones
      if (!empty($phone)) {
        // insert phones
        $pcs_obj->insert_phones($id, $phone);
      }

      // check ssid
      if (!empty($ssid)) {
        // insert ssid
        $pcs_obj->insert_ssid($id, $ssid);
      }

      // check wave
      if (!empty($wave)) {
        // insert wave
        $pcs_obj->insert_wave($id, $wave);
      }

      // check internet source
      if (!empty($coordinates)) {
        // insert internet source
        $pcs_obj->insert_coordinates($id, $coordinates);
      }

      if ($is_inserted) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'INSERTED';
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
    } else {
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
    $_SESSION['flash_message'] = 'QUERY PROBLEM';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect to previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
