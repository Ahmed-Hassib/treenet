<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $userid = $_SESSION['sys']['UserID'];
  $company_id = $_SESSION['sys']['company_id'];
  $type       = intval($_POST['type']);
  $comment    = $_POST['comment'];
  
  // validate the form
  $form_erorr = array();   // error array

  if (!isset($type) && $type < 0) {
    $form_erorr[] = 'type must be selected';
  }

  if (empty($form_erorr)) {
    // create an object of CompSUgg class
    $comp_sugg_obj = new CompSugg();
    $is_inserted = $comp_sugg_obj->insert_new(array($userid, $type, $comment, get_date_now(), get_time_now(), $company_id));
    // check if inserted
    if ($is_inserted) {
      // prepare flash session variables
      $_SESSION['flash_message'] = ($type == 0 ? "COMPLAINT" : "SUGGESTION") . ' WAS ADDED SUCCESSFULLY';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
    } else {    
      // prepare flash session variables
      $_SESSION['flash_message'] = 'A PROBLEM WAS HAPPENED WHILE DELETING THE ' . ($type == 0 ? "COMPLAINT" : "SUGGESTION");
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
    }
  } else {
    foreach ($formErorr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
    }
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
} 
?>
