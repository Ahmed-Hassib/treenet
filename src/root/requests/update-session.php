<?php
// get user id 
$user_id = isset($_GET['user-id']) && !empty($_GET['user-id']) ? base64_decode($_GET['user-id']) : 0;
// create an object of Session class
$session_obj = !isset($session_obj) ? new Session() : $session_obj;
// get user info
$user_info = $session_obj->get_user_info($user_id);
// check if done
if ($user_info[0] == true) {
  // set user session
  $session_obj->set_user_session($user_info[1]);

  // prepare flash session variables
  $_SESSION['flash_message'] = 'SESSION UPDATED';
  $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
  $_SESSION['flash_message_class'] = 'success';
  $_SESSION['flash_message_status'] = true;
  $_SESSION['flash_message_lang_file'] = 'global_';
} else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'SESSION FAILED';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'danger';
  $_SESSION['flash_message_status'] = false;
  $_SESSION['flash_message_lang_file'] = 'global_';
}

// redirect to the home
redirect_home(null, "back", 0);
