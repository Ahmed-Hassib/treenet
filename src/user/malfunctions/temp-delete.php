<?php
// create an object of Malfunction class
$mal_obj = new Malfunction();
// get malfunction id
$mal_id = isset($_GET['mal-id']) && !empty($_GET['mal-id']) ? base64_decode($_GET['mal-id']) : null;
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// check if the current malfunction id is exist or not
$is_exist = $mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id);
// check if exists
if ($mal_id != null && $is_exist == true) {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // call delete function
    $is_deleted = $mal_obj->temp_delete($mal_id);
    // check if deleted
    if ($is_deleted) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'TEMP DELETED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'QUERY PROBLEM';
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
  redirect_home(null, $is_back, 0);
} else {
  // include no data founded
  include_once $globmod . 'no-data-founded-no-redirect.php';
}
