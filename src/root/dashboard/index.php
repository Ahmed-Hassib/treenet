<?php

// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "Dashboard";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_root_dash";

// language file
$lang_file = "dashboard_root";
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check username in SESSION variable
if (isset($_SESSION['sys']['username'])) {
  // check the request
  $query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'manage';
  $possible_back = true;
  $preloader = true;
  // check
  if ($query == 'manage') {
    // check the version
    $file_name = 'dashboard.php';
  } elseif ($query == 'system-status') {
    $file_name = 'change-system-status.php';
  } else {
    $file_name = $globmod . 'page-error.php';
    $no_navbar = 'all';
    $no_footer = 'all';
  }
} else {
  header("Location: ../../logout.php?rt=" . base64_encode('root-login'));
  exit();
}
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include file name
include_once $file_name;
// footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
