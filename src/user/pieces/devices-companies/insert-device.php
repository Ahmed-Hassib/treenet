<?php
// chekc request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = isset($_POST['company-id']) && !empty($_POST['company-id']) ? base64_decode($_POST['company-id']) : '';
  // get device name
  $device_name = isset($_POST['device-name']) && !empty($_POST['device-name']) ? $_POST['device-name'] : '';
  // get device models
  $device_models = isset($_POST['model']) && !empty($_POST['model']) ? $_POST['model'] : '';
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if company id is not empty
    if (!empty($company_id) && !empty($device_name)) {
      // create an object of PiecesTypes class
      $dev_company_obj = !isset($dev_company_obj) ? new Devices() : $dev_company_obj;
      // count condition
      $count_condition = "LEFT JOIN `manufacture_companies` ON `manufacture_companies`.`man_company_id` = `devices_info`.`device_company_id` WHERE `manufacture_companies`.`company_id` = " . base64_decode($_SESSION['sys']['company_id']) . "AND `devices_info`.`device_name` = $device_name ";
      // check if name exist or not
      $is_exist = $dev_company_obj->count_records("`device_name`", "`devices_info`", $count_condition);
      // check if type is exist or not
      if ($is_exist > 0) {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'NAME EXIST';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      } else {
        // call insert_new_type function
        $dev_company_obj->insert_new_devices(array($device_name, get_date_now(), base64_decode($_SESSION['sys']['UserID']), $company_id));
        // get current device id 
        $curr_device_id = $dev_company_obj->get_latest_records("`device_id`", "`devices_info`", "", "`device_id`", "1")[0]['device_id'];
        // check model length
        if (!empty($device_models)) {
          // create an object of Models class
          $model_obj = !isset($model_obj) ? new Models() : $model_obj;
          // is inserted flag for models
          $is_inserted_models = false;
          // loop on models to insert it
          foreach ($device_models as $model) {
            // check model if empty
            if (!empty($model)) {
              // insert model
              $model_obj->insert_new_model(array($model, get_date_now(), base64_decode($_SESSION['sys']['UserID']), $curr_device_id));
              $is_inserted_models = true;
            }
          }
        }

        // messages
        $messages = array('DEV INSERTED');

        // check model flag
        if (!empty($device_models) && $is_inserted_models) {
          $messages[] = 'MODELS INSERTED';
        }

        // loop on message
        foreach ($messages as $key => $message) {
          // prepare flash session variables
          $_SESSION['flash_message'][$key] = $message;
          $_SESSION['flash_message_icon'][$key] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'][$key] = 'success';
          $_SESSION['flash_message_status'][$key] = true;
          $_SESSION['flash_message_lang_file'][$key] = $lang_file;
        }
      }

    } else {
      // include_once permission error module
      include_once $globmod . 'missing-data.php';
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // return to the previous page
  redirect_home(null, "back", 0);
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
}
