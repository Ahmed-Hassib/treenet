<?php
// check if Get request userid is numeric and get the integer value
$user_id = isset($_GET['userid']) && !empty($_GET['userid']) ? base64_decode($_GET['userid']) : null;
// action
$action = isset($_GET['action']) && is_numeric($_GET['action']) ? intval($_GET['action']) : 0;
// check the current users
if ($user_id == base64_decode($_SESSION['sys']['UserID']) || $_SESSION['sys']['user_show'] == 1) {
  // create an object of Users class
  $user_obj = new User();
  // get user info from database
  $user_info = $user_obj->get_user_info($user_id, base64_decode($_SESSION['sys']['company_id']));
  // check the row count
  if (!is_null($user_info)) {
    // get user permissions
    $stmt = $con->prepare("SELECT *FROM `users_permissions` WHERE `UserID` = ? LIMIT 1");
    $stmt->execute(array($user_id)); // execute query
    $permissions = $stmt->fetch();   // fetch data
    
    // include_once profile card
    include_once 'profile-card.php';
  } else { 
    // include_once no data founded module
    include_once $globmod . 'no-data-founded.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
}
?>