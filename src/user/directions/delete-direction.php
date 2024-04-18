<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get direction id
  $direction_id = isset($_POST['deleted-dir-id']) && !empty($_POST['deleted-dir-id']) ? base64_decode($_POST['deleted-dir-id']) : '';
  // check if dir object was created or not
  if (!isset($dir_obj)) {
    // create an object of Direction class
    $dir_obj = new Direction();
  }
  // check if direction is exist
  $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $direction_id);
  // direction name validation
  if (!empty($direction_id) && $is_exist == true) {
    // check license
    if ($_SESSION['sys']['isLicenseExpired'] == 0) {
      // count pieces on this direction
      $pieces_counter = $dir_obj->count_records("`id`", "`pieces_info`", "WHERE `direction_id` = $direction_id AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
      // check if direction name is exist or not
      if ($pieces_counter > 0) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'CANNOT DELETE';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = $lang_file;
      } else {
        // call delete direction function
        $dir_obj->delete_direction($direction_id);
        // prepare flash session variables
        $_SESSION['flash_message'] = 'DELETED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = $lang_file;
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'DIRECTION ERROR';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'warning';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = $lang_file;
  }
  // redirect to previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
