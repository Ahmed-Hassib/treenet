<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get device id
  $device_id = isset($_POST['deleted-device-id']) && !empty($_POST['deleted-device-id']) ? base64_decode($_POST['deleted-device-id']) : '';
  // get back flag value
  $is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
  // create an object of PiecesTypes class
  $device_obj = !isset($device_obj) ? new Devices() : $device_id;
  // create an object of Model class
  $model_obj = !isset($model_obj) ? new Models() : $model_obj;

  // check if name exist or not
  $is_exist = $device_obj->is_exist("`device_id`", "`devices_info`", $device_id);
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if company is exist or not
    if (!empty($device_id) && $is_exist == true) {
      // delete all device models
      $model_obj->delete_device_models($device_id);
      // call delete_device function
      $device_obj->delete_device($device_id);

      // prepare flash session variables
      $_SESSION['flash_message'] = 'DEV DELETED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
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
  // redirect to previous page
  redirect_home(null, $is_back, 0);
} else {
  include_once $globmod . 'permission-error.php';
} ?>