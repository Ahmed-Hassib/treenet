<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get direction id
  $direction_id = isset($_POST['updated-dir-id']) && !empty($_POST['updated-dir-id']) ? base64_decode($_POST['updated-dir-id']) : '';
  // get direction new name
  $new_direction_name = isset($_POST['new-direction-name']) && !empty($_POST['new-direction-name']) ? $_POST['new-direction-name'] : '';

  // create an object of Direction class
  $dir_obj = new Direction();
  // check if direction is exist
  $is_exist = $dir_obj->is_exist("`direction_id`", "`direction`", $direction_id);

  // direction name validation
  if (!empty($new_direction_name) && $is_exist == true) {
    // check license
    if ($_SESSION['sys']['isLicenseExpired'] == 0) {
      // directions counter that have the same name in the same company
      $directions_counter = $dir_obj->count_records("`direction_id`", "`direction`", "WHERE `direction_id` != $direction_id AND `direction_name` = '$new_direction_name' AND `company_id` = " . $_SESSION['sys']['company_id']);
      // check if direction name is exist or not
      if ($directions_counter > 0) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'NAME EXIST';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = $lang_file;
      } else {
        // call update direction function
        $dir_obj->update_direction($new_direction_name, $direction_id);
        // prepare flash session variables
        $_SESSION['flash_message'] = 'UPDATED';
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
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = $lang_file;
  }
  // redirect to previous page
  redirect_home(null, "back", 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}