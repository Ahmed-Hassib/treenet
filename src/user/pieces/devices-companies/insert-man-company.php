<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get type name
  $company_name = isset($_POST['company-name']) && !empty($_POST['company-name']) ? $_POST['company-name'] : '';
  // create an object of PiecesTypes class
  $dev_company_obj = !isset($dev_company_obj) ? new ManufuctureCompanies() : $dev_company_obj;
  // check if name exist or not
  $is_exist = $dev_company_obj->count_records("`man_company_id`", "`manufacture_companies`", "WHERE `man_company_name` = $company_name AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
  // type name validation
  if (!empty($company_name)) {
    // check if type is exist or not
    if ($is_exist > 0) {
      $_SESSION['flash_message'] = 'NAME EXIST';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    } else {
      // check license
      if ($_SESSION['sys']['isLicenseExpired'] == 0) {
        // call insert_new_type function
        $is_inserted = $dev_company_obj->insert_new_man_company(array($company_name, get_date_now(), base64_decode($_SESSION['sys']['UserID']), base64_decode($_SESSION['sys']['company_id'])));
        // check if inserted
        if ($is_inserted) {
          // prepare flash session variables
          $_SESSION['flash_message'] = 'COMPANY INSERTED';
          $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'] = 'success';
          $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = $lang_file;
        } else {
          // prepare flash session variables
          $_SESSION['flash_message'] = 'QUERY PROBLEM';
          $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
          $_SESSION['flash_message_class'] = 'danger';
          $_SESSION['flash_message_status'] = true;
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
    }
  } else {
    $_SESSION['flash_message'] = 'TYPE NULL';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = $lang_file;
  }

  // return to the previous page
  redirect_home(null, "back", 0);
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
} ?>