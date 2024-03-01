<?php
// chekc request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get device id
  $model_id = isset($_POST['model-id']) && !empty($_POST['model-id']) ? $_POST['model-id'] : '';
  // get device name
  $model_name = isset($_POST['new-model-name']) && !empty($_POST['new-model-name']) ? $_POST['new-model-name'] : '';
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if company id is not empty
    if (!empty($model_id) && !empty($model_name)) {
      // create an object of Model class
      $model_obj = !isset($model_obj) ? new Models() : $model_obj;
      // check if name exist or not
      $is_exist_model_id = $model_obj->is_exist("`model_id`", "`devices_model`", $model_id);
      $is_exist_model_name = $model_obj->count_records("`model_id`", "`devices_model`", "WHERE `model_id` <> $model_id AND `model_name` = $model_name");

      // check if type is exist or not
      if ($is_exist_model_id) {
        if ($is_exist_model_name) {
          // prepare flash session variables
          $_SESSION['flash_message'] = 'THIS NAME IS ALREADY EXIST';
          $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
          $_SESSION['flash_message_class'] = 'danger';
          $_SESSION['flash_message_status'] = false;
          $_SESSION['flash_message_lang_file'] = $lang_file;
        } else {
          // call insert_new_type function
          $model_obj->update_model($model_name, $model_id);
          // prepare flash session variables
          $_SESSION['flash_message'] = 'MODEL WAS UPDATED SUCCESSFULLY';
          $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'] = 'success';
          $_SESSION['flash_message_status'] = true;
          $_SESSION['flash_message_lang_file'] = $lang_file;
        }
        // redirect to home page
        redirect_home(null, "back", 0);
      } else {
        // include not data founded module
        include_once $globmod . "no-data-founded.php";
      }
    } else {
      // include_once permission error module
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
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>