<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = base64_decode($_SESSION['sys']['UserID']);
  // get id
  $id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
  $replay = isset($_POST['replay']) && !empty($_POST['replay']) ? trim($_POST['replay']) : null;

  // validate the form
  $err_arr = array();   // error array

  // check type
  if (is_null($id)) {
    $err_arr[] = 'id null';
  }

  // check comment
  if (is_null($replay)) {
    $err_arr[] = 'replay null';
  }

  if (empty($err_arr)) {
    // create an object of CompSuggReplays class
    $comp_sugg_obj = new CompSuggReplays();
    $is_inserted = $comp_sugg_obj->insert_comment(array($id, $replay, $user_id));
    // check if updated
    if ($is_inserted) {
      // prepare flash session variables
      $_SESSION['flash_message'] = "comment inserted";
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'query problem';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    foreach ($err_arr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
