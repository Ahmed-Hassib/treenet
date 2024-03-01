<?php
// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get info to update it
  $company_id = isset($_POST['company-id']) && !empty($_POST['company-id']) && filter_var(base64_decode($_POST['company-id']), FILTER_VALIDATE_INT) !== false ? base64_decode($_POST['company-id']) : null;
  $license_id = isset($_POST['license-id']) && !empty($_POST['license-id']) && filter_var(base64_decode($_POST['license-id']), FILTER_VALIDATE_INT) !== false ? base64_decode($_POST['license-id']) : null;
  $is_trial = isset($_POST['is-trial']) && !empty($_POST['is-trial']) && filter_var($_POST['is-trial'], FILTER_VALIDATE_INT) !== false ? ($_POST['is-trial'] == 0 ? '0' : $_POST['is-trial']) : null;
  $is_ended = isset($_POST['is-ended']) && !empty($_POST['is-ended']) && filter_var($_POST['is-ended'], FILTER_VALIDATE_INT) !== false ? ($_POST['is-ended'] == 0 ? '0' : $_POST['is-ended']) : null;
  $expire_date = isset($_POST['expire-date']) && !empty($_POST['expire-date']) ? $_POST['expire-date'] : null;

  // array of error
  $err_arr = [];

  // validate company id
  if (is_null($company_id)) {
    $err_arr[] = 'company id null';
  }

  // validate license id
  if (is_null($license_id)) {
    $err_arr[] = 'license id null';
  }

  // validate is trial
  if (is_null($is_trial) && $is_trial != 0) {
    $err_arr[] = 'is trial null';
  }

  // validate is ended
  if (is_null($is_ended) && $is_ended != 0) {
    $err_arr[] = 'is ended null';
  }

  // check if any errors
  if (empty($err_arr)) {
    // create an object of Company class
    $company_obj = new Company();
    // update condition
    $update_condiition = "`isEnded` = " . ($is_ended == 0 ? '0' : $is_ended) . ", `isTrial` = " . ($is_trial == 0 ? '0' : $is_trial) . ", `expire_date` = '{$expire_date}'";
    // update trial license
    $is_updated = $company_obj->update_licenses($company_id, $license_id, $update_condiition);

    // check if updated
    if ($is_updated) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO CHANGES';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'info';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    foreach ($err_arr as $key => $error) {
      // prepare flash session variables
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
  }
  // redirect home
  redirect_home(null, 'back', 0);
} else {
  include_once $globmod . "permission-error.php";
}
?>