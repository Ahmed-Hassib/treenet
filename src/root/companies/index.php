<?php

/**
 * USERS PAGE
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = "the companies";
// is admin == true
$is_admin = true;
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_root_companies";

// language file
$lang_file = "companies_root";
// level
$level = 3;
// nav level
$nav_level = 1;
// flag for table dependancies
$is_contain_table = false;
$preloader = true;

// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check username in SESSION variable
if (isset($_SESSION['sys']['username']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
  // check if Get request do is set or not
  $query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'manage';

  // start manage page
  if ($query == "manage") {       // manage page
    $file_name = 'dashboard.php';
  } elseif ($query == "list") {
    $file_name = 'list.php';
    $page_subtitle = 'list';
    $is_contain_table = true;
  } elseif ($query == "details") {
    $file_name = 'details.php';
    $page_subtitle = 'company details';
    $is_contain_table = true;
  } elseif ($query == "update") {
    $file_name = 'update.php';
    $page_subtitle = 'edit company';
  } elseif ($query == "delete") {
    $file_name = 'delete.php';
  } else {
    // include page error module
    $file_name = $globmod . "page-error.php";
  }
} else {
  // include permission error module
  $file_name = $globmod . "permission-error.php";
}
// pre-configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
