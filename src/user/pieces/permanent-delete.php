<?php
// create an object of PiecesDeletes Class
$pcs_obj = new Pieces();
// check if Get request piece-id is numeric and get the integer value
$piece_id = isset($_GET['piece-id']) && !empty($_GET['piece-id']) ? base64_decode($_GET['piece-id']) : null;
// check if Get request deleted is numeric and get the integer value
$is_deleted = isset($_GET['deleted']) && !empty($_GET['deleted']) && filter_var((bool) $_GET['deleted'], FILTER_VALIDATE_BOOLEAN) ? (bool) $_GET['deleted'] : false;
// check if deleted
if ($is_deleted) {
  // get user info from database
  $is_exist = $pcs_obj->is_exist("`id`", "`deleted_pieces_info`", $piece_id);
  // get piece name
  $piece_name = $is_exist ? $pcs_obj->select_specific_column("`full_name`", "`deleted_pieces_info`", "WHERE `id` = {$piece_id}")['full_name'] : null;
} else {
  // get user info from database
  $is_exist = $pcs_obj->is_exist("`id`", "`pieces_info`", $piece_id);
  // get piece name
  $piece_name = $is_exist ? $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = {$piece_id}")['full_name'] : null;
}
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// check if exist
// check license
if ($_SESSION['sys']['isLicenseExpired'] == 0) {
  if ($is_exist == true) {
    // check if the piece have a children or not
    $count_child = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `source_id` = {$piece_id} AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
    // check the counter
    if ($count_child == 0) {
      // call delete function
      $is_deleted = $pcs_obj->delete($piece_id);
      // log message
      $log_msg = "Delete piece with name `$piece_name`";
      create_logs($_SESSION['sys']['username'], $log_msg, 3);
      // prepare flash session variables
      $_SESSION['flash_message'] = 'PERMANENT DELETED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;

      // echo "<pre dir='ltr'>";
      // print_r($is_deleted);
      // // check if deleted
      // if ($is_deleted) {
      // } else {
      //   // prepare flash session variables
      //   $_SESSION['flash_message'] = 'QUERY PROBLEM';
      //   $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      //   $_SESSION['flash_message_class'] = 'danger';
      //   $_SESSION['flash_message_status'] = false;
      //   $_SESSION['flash_message_lang_file'] = 'global_';
      // }
    } else {
      // log message
      $log_msg = "You cannot delete the piece because it hase more than 1 child..";
      create_logs($_SESSION['sys']['username'], $log_msg, 2);
      // prepare flash session variables
      $_SESSION['flash_message'] = 'CANNOT DELETE';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'pieces';
    }
  } else {
    // include no data founded module
    include_once $globmod . 'no-data-founded.php';
  }
} else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'danger';
  $_SESSION['flash_message_status'] = true;
  $_SESSION['flash_message_lang_file'] = 'global_';
}
// redirect to the previous page
redirect_home(null, $is_back, 0);
