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
$page_title = "the comps & suggs";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_comp";
// laguage file
$lang_file = 'comp_sugg';
// level
$level = 3;
// nav level
$nav_level = 1;
// some page flages
$possible_back = true;
$preloader = true;
$is_contain_table = false;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // start manage page
    if ($query == "manage") {       // manage page
      // include comp & sugg dashboard page
      $file_name = 'dashboard.php';
    } elseif ($query == 'list') {
      // include list comp & sugg page
      $file_name = 'list.php';
      $is_contain_table = true;
    } elseif ($query == 'edit') {
      // include edit comp & sugg page
      $file_name = 'edit.php';
    } elseif ($query == 'update-status') {
      // include update-status comp & sugg page
      $file_name = 'update-status.php';
    } elseif ($query == 'add-comment') {
      // include insert comment comp & sugg page
      $file_name = 'insert-comment.php';
    } else {
      // include page error module
      $file_name = $globmod . 'page-error.php';
      $possible_back = false;
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    // include permission error module
    $file_name = $globmod . 'permission-error.php';
    $possible_back = false;
    $preloader = false;
    $no_navbar = 'all';
    $no_footer = 'all';
  }
} else {
  $file_name = $globmod . "under-developing.php";
}
// initial configration of system
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
