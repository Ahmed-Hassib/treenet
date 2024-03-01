<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "trash";
// page subtitle
// $page_subtitle = "dashboard";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_deletes";

// language file
$lang_file = "deletes";
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = true;
$preloader = true;
$is_contain_table = true;

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username'])) {
    // start dashboard page
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($query == 'manage') {
      // include dashboard
      $file_name = "dashboard.php";
      $possible_back = true;
      $is_stored = true;
    } elseif ($query == "clients") {
      // include clients deletes
      $file_name = "clients/" . include_once "clients/index.php";
    } elseif ($query == "pieces") {
      // include pieces deletes
      $file_name = "pieces/" . include_once "pieces/index.php";
    } elseif ($query == "employees") {
      // include employees deletes
      $file_name = "employees/" . include_once "employees/index.php";
    } elseif ($query == "combinations") {
      // include combinations deletes
      $file_name = "combinations/" . include_once "combinations/index.php";
    } elseif ($query == "malfunctions") {
      // include malfunctions deletes
      $file_name = "malfunctions/" . include_once "malfunctions/index.php";
    } else {
      // include page not founded module
      $file_name = $globmod . 'page-error.php';
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    // include permission error module
    $file_name = $globmod . 'permission-error.php';
    $no_navbar = 'all';
    $no_footer = 'all';
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

// check if license was ended
if (isset($_SESSION['sys']['isLicenseExpired']) && $_SESSION['sys']['isLicenseExpired'] == 1 && !isset($no_navbar)) {
  // license file
  include_once $globmod . 'treenet-license-ended.php';
}
// include file name
include_once $file_name;

include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";
ob_end_flush();
