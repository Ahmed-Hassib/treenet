<?php
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get user id
  $user_id = base64_decode($_SESSION['sys']['UserID']);
  // get ping counter value
  $ping_counter = isset($_POST['ping-counter']) && $_POST['ping-counter'] > 0 ? intval($_POST['ping-counter']) : $_SESSION['sys']['ping_counter'];

  // create an object of Company class
  $user_obj = !isset($user_obj) ? new User() : $user_obj;

  // check if any changes was happened
  if ($_SESSION['sys']['ping_counter'] != $ping_counter) {
    // change other settings
    $is_changed = $user_obj->change_other_settings(array($ping_counter, $user_id));

    if ($is_changed) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'SETTINGS UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;

      // create an object of Session class
      $session_obj = new Session();
      // set user session
      $session_obj->update_session(base64_decode($_SESSION['sys']['UserID']));
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
    $_SESSION['flash_message'] = 'NO CHANGES';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'info';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect home
  redirect_home(null, 'back', 0);
} else {
  // include_once per
  include_once $globmod . 'permission-error.php';
}
