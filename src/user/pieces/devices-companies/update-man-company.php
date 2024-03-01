<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = isset($_POST['updated-company-id']) && !empty($_POST['updated-company-id']) ? base64_decode($_POST['updated-company-id']) : '';
  // get new name
  $new_company_name = isset($_POST['new-company-name']) && !empty($_POST['new-company-name']) ? $_POST['new-company-name'] : '';
  // create an object of PiecesTypes class
  $dev_company_obj = !isset($dev_company_obj) ? new ManufuctureCompanies() : $dev_company_obj;
  // check if name exist or not
  $is_exist = $dev_company_obj->is_exist("`man_company_id`", "`manufacture_companies`", $company_id);
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if type is exist or not
    if ($is_exist == true) {
      // type name validation
      if (!empty($new_company_name)) {
        // check if type is exist or not
        if ($dev_company_obj->count_records("`man_company_id`", "`manufacture_companies`", "WHERE `man_company_id` <> $company_id AND `man_company_name` = '$new_company_name' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])) > 0) {
          // prepare flash session variables
          $_SESSION['flash_message'] = 'NAME EXIST';
          $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
          $_SESSION['flash_message_class'] = 'danger';
          $_SESSION['flash_message_status'] = false;
          $_SESSION['flash_message_lang_file'] = 'global_';
        } else {
          // call update_man_company function
          $dev_company_obj->update_man_company($new_company_name, $company_id);
          // prepare flash session variables
          $_SESSION['flash_message'] = 'COMPANY UPDATED';
          $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'] = 'success';
          $_SESSION['flash_message_status'] = true;
          $_SESSION['flash_message_lang_file'] = $lang_file;
        }
      } else {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'COMPANY NULL';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = $lang_file;
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
  // redirect to the previous page
  redirect_home(null, "back", 0);
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>