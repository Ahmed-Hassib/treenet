<?php

// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "dashboard";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_dash";

// language file
$lang_file = "dashboard";
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username'])) {
    // check the request
    if (isset($_GET['do'])) {
      $query = !empty($_GET['do']) ? trim($_GET['do']) : 'manage';
    } elseif (isset($_GET['search'])) {
      $query = 'search';
    } else {
      $query = 'manage';
    }

    $possible_back = true;
    $preloader = true;
    // check
    if ($query == 'manage') {
      // check the version
      $file_name = 'dashboard.php';
    } elseif ($query == 'version-info') {
      // check the version
      $file_name = 'version-info.php';
    } elseif ($query == 'search') {
      $file_name = 'search.php';
      $is_contain_table = true;
    } elseif ($query == 'contact-us') {
      $file_name = 'contact-us.php';
      $page_subtitle = 'contact us';
    } else {
      $file_name = $globmod . 'page-error.php';
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    header("Location: ../../logout.php");
    exit();
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
// footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
