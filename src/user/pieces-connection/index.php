<?php
/**
 * PIECES PAGE
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = 'conn types';
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_pieces";

// language file
$lang_file = 'pcs_conn';
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = true;
$preloader = false;
$is_sorted = false;
$is_contain_table = false;

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username'])) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($query == 'manage' && $_SESSION['sys']['connection_show'] == 1) {
      $file_name = 'dashboard.php';
      $page_subtitle = 'dashboard';
      $preloader = true;
      $is_sorted = true;

    } elseif ($query == 'show-pieces-conn' && $_SESSION['sys']['connection_show'] == 1) {
      // get type of piece
      $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 0;
      // get type of piece
      $connid = isset($_GET['connid']) && !empty($_GET['connid']) ? $_GET['connid'] : 0;
      $file_name = 'show-pieces-conn.php';
      $is_contain_table = true;
      $preloader = true;
      $is_stored = true;

    } elseif ($query == 'insert-piece-conn-type' && $_SESSION['sys']['connection_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'insert-conn-type.php';
      $page_subtitle = "add new";
      $possible_back = false;
      
    } elseif ($query == 'update-piece-conn-type' && $_SESSION['sys']['connection_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'update-conn-type.php';
      $page_subtitle = "edit conn";
      $possible_back = false;
      
    } elseif ($query == 'delete-piece-conn-type' && $_SESSION['sys']['connection_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'delete-conn-type.php';
      $page_subtitle = "delete conn";
      $possible_back = false;

    } else {
      $file_name = $globmod . 'page-error.php';
      $possible_back = false;
      $preloader = false;
      $no_navbar = 'all';
      $no_footer = 'all';
    }

  } else {
    $file_name = $globmod . 'permission-error.php';
    $possible_back = false;
    $preloader = false;
    $no_navbar = 'all';
    $no_footer = 'all';
  }

  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // include ping modal
    include_once $globmod . 'ping-modal.php';
    // include confirmation delete modal
    include_once 'delete-conn-type-modal.php';
  }
} else {
  $file_name = $globmod . "under-developing.php";
}
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// alerts of system
include_once str_repeat("../", $level) . "etc/system-alerts.php";

// include file name
include_once $file_name;
// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();