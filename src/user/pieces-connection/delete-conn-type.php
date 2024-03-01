<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get deleted connection type id
    $conn_id = isset($_POST['deleted-conn-type-id']) && !empty($_POST['deleted-conn-type-id']) ? base64_decode($_POST['deleted-conn-type-id']) : '';
    // check if back is possible
    $is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
    // create an object of PiecesConn class
    $conn_obj = !isset($conn_obj) ? new PiecesConn() : $conn_obj;
    // check if id is exist
    $is_exist_id = $conn_obj->is_exist("`id`", "`connection_types`", $conn_id);
    // check if type is exist or not
    if (!empty($conn_id) && $is_exist_id == true) {
      // update all pieces with this deleted type to 0
      $updated_query = "UPDATE `pieces_info` SET `connection_type` = 0 WHERE `connection_type` = $conn_id";
      $stmt = $con->prepare($updated_query);
      $stmt->execute();

      // call delete function
      $is_deleted = $conn_obj->delete_conn_type($conn_id);

      // check if deleted
      if ($is_deleted) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'DELETED';
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
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO DATA';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect to home page
  redirect_home(null, $is_back, 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
} ?>