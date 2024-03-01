<?php 
// get user id
$user_id = base64_decode($_SESSION['sys']['UserID']);
// get company id
$company_id = base64_decode($_SESSION['sys']['company_id']);
// get rating
$rating = $_POST['rating'];
// create an object of User class
$user_obj = new User();
// count user rating in database
$is_rating = $user_obj->count_records("`id`", "`app_rating`", "WHERE `added_by` = $user_id") > 0 ? true : false;
// check if the user do rate before or not
if (!$is_rating) {
  // rate app
  $is_rating_now = $user_obj->do_rating_app(array($user_id, $company_id, $rating, null));
  // check if rated
  if ($is_rating_now) {
    $_SESSION['flash_message'] = "RATING SUCCESS";
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
  } else {
    $_SESSION['flash_message'] = "RATING FAILED";
    $_SESSION['flash_message_icon'] = 'exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
} else {
  $_SESSION['flash_message'] = "RATED BEFORE";
  $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
  $_SESSION['flash_message_class'] = 'info';
  $_SESSION['flash_message_status'] = true;
  $_SESSION['flash_message_lang_file'] = 'global_';
}
// redirect to the previous page
redirect_home('', 'back', 0);