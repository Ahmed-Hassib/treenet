<?php
// chekc request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get device id
    $device_id = isset($_POST['device-id']) && !empty($_POST['device-id']) ? base64_decode($_POST['device-id']) : '';
    // get device name
    $device_name = isset($_POST['device-name']) && !empty($_POST['device-name']) ? $_POST['device-name'] : '';
    // get company id
    $company_id = isset($_POST['manufacture-company-id']) && !empty($_POST['manufacture-company-id']) ? base64_decode($_POST['manufacture-company-id']) : '';
    // check if company id is not empty
    if (!empty($device_id) && !empty($device_name) && !empty($company_id)) {
      // create an object of PiecesTypes class
      $dev_obj = !isset($dev_obj) ? new Devices() : $dev_obj;
      // check if name exist or not
      $is_exist_device_id = $dev_obj->is_exist("`device_id`", "`devices_info`", $device_id);
      $is_exist_device_name = $dev_obj->is_exist("`device_id`", "`devices_info`", $device_name);
      $is_exist_company_id = $dev_obj->is_exist("`man_company_id`", "`manufacture_companies`", $company_id);

      // check if type is exist or not
      if ($is_exist_device_id == true && $is_exist_company_id == true) {
        if ($is_exist_device_name) {
          // prepare flash session variables
          $_SESSION['flash_message'] = 'NAME EXIST';
          $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
          $_SESSION['flash_message_class'] = 'danger';
          $_SESSION['flash_message_status'] = false;
          $_SESSION['flash_message_lang_file'] = 'global_';
        } else {
          // call insert_new_type function
          $is_updated = $dev_obj->update_device_info($device_name, $company_id, $device_id);
          // check if updated
          if ($is_updated) {
            // prepare flash session variables
            $_SESSION['flash_message'] = 'DEV UPDATED';
            $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
            $_SESSION['flash_message_class'] = 'success';
            $_SESSION['flash_message_status'] = true;
            $_SESSION['flash_message_lang_file'] = $lang_file;
          } else {
            // prepare flash session variables
            $_SESSION['flash_message'] = 'NAME EXIST';
            $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
            $_SESSION['flash_message_class'] = 'danger';
            $_SESSION['flash_message_status'] = false;
            $_SESSION['flash_message_lang_file'] = 'global_';
          }

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