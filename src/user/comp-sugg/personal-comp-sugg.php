<?php
// get the type
$type = isset($_GET['type']) ? intval($_GET['type']) : -1;
// // get status
// $status = isset($_GET['status']) ? $_GET['status'] : -1;
// get userid
$userid = $_SESSION['sys']['UserID'];
// check if CompSugg class object is created
if (!isset($comp_sugg_obj)) {
  $comp_sugg_obj = new CompSugg();
}

if ($type == 0) {
  // include complaints file
  include_once 'complaints-dashboard.php';
} elseif ($type == 1) {
  // include suggestions file
  include_once 'suggestions-dashboard.php';
} else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'YOU MUST CHOOSE THE SECTION FOR EITHER SUGGESTIONS OR COMPLAINTS';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'warning';
  $_SESSION['flash_message_status'] = false;
  // redirect to previous page
  redirect_home(null, 'back', 0);
}
?>