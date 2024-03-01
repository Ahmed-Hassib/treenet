<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get connection type id
    $conn_id = isset($_POST['updated-conn-type-id']) && !empty($_POST['updated-conn-type-id']) ? base64_decode($_POST['updated-conn-type-id']) : '';
    // get connection type name
    $new_conn_name = isset($_POST['new-conn-type-name']) && !empty($_POST['new-conn-type-name']) ? $_POST['new-conn-type-name'] : '';
    // get connection type notes
    $new_conn_note = isset($_POST['new-conn-type-note']) && !empty($_POST['new-conn-type-note']) ? $_POST['new-conn-type-note'] : '';
    // create an object of PiecesConn class
    $conn_obj = !isset($conn_obj) ? new PiecesConn() : $conn_obj;
    // check the type exist to update 
    $is_exist = $conn_obj->is_exist("`id`", "`connection_types`", $conn_id);
    // array of error
    $err_arr = array();
    // check new name
    if (empty($new_conn_name)) {
      $err_arr[] = 'CONN NULL';
    }

    // type name validation
    if (empty($err_arr) && $is_exist == true) {
      // check the new name
      $is_exist_name = $conn_obj->count_records("`connection_name`", "`connection_types`", "WHERE `id` != $conn_id AND `connection_name` = '$new_conn_name' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
      // check if new type name is exist or not
      if ($is_exist_name > 0) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'NAME EXIST';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      } else {
        // call update function
        $conn_obj->update_conn_type($new_conn_name, $new_conn_note, $conn_id);
        // prepare flash session variables
        $_SESSION['flash_message'] = 'UPDATED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = $lang_file;
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
    $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect home
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
