<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = isset($_POST['company-id']) && !empty($_POST['company-id']) ? base64_decode($_POST['company-id']) : '';
  // get back flag value
  $is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
  // check if object of PiecesTypes class is created or not
  $dev_company_obj = !isset($dev_company_obj) ? new ManufuctureCompanies() : $dev_company_obj;
  // check if name exist or not
  $is_exist = $dev_company_obj->is_exist("`man_company_id`", "`manufacture_companies`", $company_id);
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if company is exist or not
    if (!empty($company_id) && $is_exist == true) {
      // create an object of Devices clas
      $dev_obj = !isset($dev_obj) ? new Devices() : $dev_obj;
      // get all devices of this company
      $devices_data = $dev_obj->get_all_company_devices($company_id);

      // check if it not empty
      if (!is_null($devices_data)) {
        // create an object of Model class
        $model_obj = new Models();
        // loop on it to delete all devices` models
        foreach ($devices_data as $key => $device) {
          // delete all models of this device
          $model_obj->delete_device_models($device['device_id']);
          // delete all devices of this company
          $dev_obj->delete_device($device['device_id']);
        }
      }
      // call delete_man_company function
      $dev_company_obj->delete_man_company($company_id);
      // messages
      $messages = array('COMPANY DELETED', 'DEVS DELETED', 'MODELS DELETED');
      // loop on message
      foreach ($messages as $key => $message) {
        // prepare flash session variables
        $_SESSION['flash_message'][$key] = $message;
        $_SESSION['flash_message_icon'][$key] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'][$key] = 'success';
        $_SESSION['flash_message_status'][$key] = true;
        $_SESSION['flash_message_lang_file'][$key] = $lang_file;
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO DATA';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // include_once permission error module
    include_once $globmod . 'permission-error.php';
  }
} else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'success';
  $_SESSION['flash_message_status'] = true;
  $_SESSION['flash_message_lang_file'] = 'global_';
}
// redirect to the previous page
redirect_home(null, $is_back, 0);