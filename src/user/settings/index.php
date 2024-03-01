<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "Settings";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_settings";

// language file
$lang_file = "settings";
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = false;
$preloader = false;

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
      $preloader = true;

    } elseif ($query == "change-lang") {
      // include change-language file
      $file_name = "change-language.php";

      
    } elseif ($query == "change-company-img" && $_SESSION['sys']['change_company_img']) {
      // include change company file
      $file_name = "change-company-img.php";

      
    } elseif ($query == "change-company-info" && base64_decode($_SESSION['sys']['job_title_id']) == 1) {
      // include change company file
      $file_name = "change-company-info.php";

      
    } elseif ($query == "change-mikrotik" && $_SESSION['sys']['change_mikrotik']) {
      // include change mikrotik settings file
      $file_name = "change-mikrotik.php";

      
    } elseif ($query == "change-mikrotik-status" && $_SESSION['sys']['change_mikrotik']) {
      // include change mikrotik settings file
      $file_name = "change-mikrotik-status.php";

      
    } elseif ($query == "others") {
      // include change other settings file
      $file_name = "change-others.php";

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

// include file name
include_once $file_name;

include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";
ob_end_flush();
