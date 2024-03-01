<?php
// get combination id
$comb_id = isset($_GET['combid']) && !empty($_GET['combid']) ? base64_decode($_GET['combid']) : 0;
// create an object of Combination
$comb_obj = new Combination();
// check if the current combination id is exist or not
$is_exist = $comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id);
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;

if ($is_exist == true) {
  // check if license was expired
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // // call delete function
    $is_deleted = $comb_obj->delete($comb_id);

    // check if deleted
    if ($is_deleted == true) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'DELETED';
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
} else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'NO DATA';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'danger';
  $_SESSION['flash_message_status'] = false;
  $_SESSION['flash_message_lang_file'] = 'global_';
}
// redirect to the previous page
redirect_home(null, $is_back, 0);
