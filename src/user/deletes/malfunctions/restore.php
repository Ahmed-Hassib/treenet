<?php
// get mal id
$mal_id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode(trim($_GET['id'], " ")) : null;
// array of error
$err_arr = array();

// check mal id
if (!filter_var($mal_id, FILTER_VALIDATE_INT)) {
  $err_arr[] = 'THERE IS AN ERROR OR MISSING DATA';
}

// check error array
if (empty($err_arr)) {
  // create an object of Pieces class
  $mal_obj = new Malfunction();

  // check if mal id was exists
  if ($mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id)) {
    // restore previous data
    $is_restored = $mal_obj->restore_malfunction($mal_id);

    // check if restored
    if ($is_restored) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'MALFUNCTION RESTORED';
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
    $_SESSION['flash_message'] = 'NO DATA';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
} else {
  foreach ($err_arr as $key => $error) {
    // prepare flash session variables
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'global_';
  }
}

// redirect back
redirect_home(null, 'back', 0);
