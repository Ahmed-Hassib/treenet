<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get connection type name
    $conn_type_name = isset($_POST['conn-type-name']) && !empty($_POST['conn-type-name']) ? $_POST['conn-type-name'] : '';
    // get connection type notes
    $conn_type_note = isset($_POST['conn-type-note']) && !empty($_POST['conn-type-note']) ? $_POST['conn-type-note'] : '';
    // check connection object
    $conn_obj = !isset($conn_obj) ? new PiecesConn() : $conn_obj;
    // type name validation
    if (!empty($conn_type_name)) {
      // check if connection name is exist
      $is_exist = $conn_obj->count_records("`connection_name`", "`connection_types`", "WHERE `connection_name` = $conn_type_name AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
      // if true show an error message
      if ($is_exist == true) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'NAME EXIST';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      } else {
        // call insert new connection function
        $is_inserted = $conn_obj->insert_new_conn_type($conn_type_name, $conn_type_note, base64_decode($_SESSION['sys']['company_id']));

        // check if inserted
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
      }
    } else {
      // include missing data file
      include_once $globmod . 'missing-data.php';
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
