<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get id
  $id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
  $type = isset($_POST['type']) && !empty($_POST['type']) ? base64_decode($_POST['type']) : null;
  $comment = isset($_POST['comment']) && !empty($_POST['comment']) ? trim($_POST['comment']) : null;

  // available types
  $available_types = ['comp', 'sugg'];

  // validate the form
  $form_erorr = array();   // error array

  // check type
  if (is_null($type)) {
    $form_erorr[] = 'type null';
  } elseif (!in_array($type, $available_types)) {
    $form_erorr[] = 'type not right';
  }

  // check comment
  if (is_null($comment)) {
    $err_arr[] = 'comment null';
  }

  if (empty($form_erorr)) {
    // create an object of CompSugg class
    $comp_sugg_obj = new CompSugg();
    $is_updated = $comp_sugg_obj->update(array($comment, $type, $id));
    // check if updated
    if ($is_updated) {
      // prepare flash session variables
      $_SESSION['flash_message'] = "{$type} updated";
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'no changes';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'info';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    foreach ($form_erorr as $key => $error) {
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
