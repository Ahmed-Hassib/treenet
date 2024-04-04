<?php
// get user id
$user_id = isset($_POST['id']) ? base64_decode($_POST['id']) : 0;
// create an object of User class
$user_obj = !isset($user_obj) ? new User() : $user_obj;
// check user if exist or not
$check = $user_obj->is_exist("`UserID`", "`users`", $user_id);
// check
if ($check == true) {
  // get language
  $lang = isset($_POST['language']) && !empty($_POST['language']) ? base64_decode($_POST['language']) : 0;
  // call change_user_langugae
  $is_changed = $user_obj->change_user_language($lang, $user_id);
  // create an object of Session class
  $session_obj = new Session();
  // set user session
  $session_obj->update_session(base64_decode($_SESSION['sys']['UserID']));
  // prepare flash session variables
  $_SESSION['flash_message'] = 'SETTINGS UPDATED';
  $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
  $_SESSION['flash_message_class'] = 'success';
  $_SESSION['flash_message_status'] = true;
  $_SESSION['flash_message_lang_file'] = $lang_file;
  // redirect to home page
  redirect_home(null, 'back', 0);
}
