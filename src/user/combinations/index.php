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
$page_title = "the combs";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_combination";

// language file
$lang_file = "combinations";
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// some page flages
$possible_back = true;
$preloader = true;
// refere to that this page have tables
$is_contain_table = false;

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable

  if (isset($_SESSION['sys']['username'])) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // start manage page

    if ($query == "manage" && $_SESSION['sys']['comb_show'] == 1) { // manage page
      // include combination dashboard
      $file_name = 'dashboard.php';
      $page_subtitle = "dashboard";
      $is_contain_table = true;
    } elseif ($query == "show-combination-details" && $_SESSION['sys']['comb_show'] == 1) {
      // include combination details page
      $file_name = 'combinations-details.php';
      $page_subtitle = "combs details";
      $is_contain_table = true;
    } elseif ($query == "add-new-combination" && $_SESSION['sys']['comb_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      // include add combination page
      $file_name = 'add-combination.php';
      $page_subtitle = "add new";
      $is_contain_table = true;
      $is_contain_map = true;
    } elseif ($query == "insert-combination-info" && $_SESSION['sys']['comb_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { // edit piece page
      // include isert combination page
      $file_name = 'insert-combination.php';
      $page_subtitle = "add new";
      $possible_back = false;
    } elseif ($query == 'edit-combination' && $_SESSION['sys']['comb_show'] == 1) {
      // include edit combination page
      $file_name = 'edit-combination.php';
      $page_subtitle = "edit";
      $is_contain_map = true;
    } elseif ($query == 'update-combination-info' && $_SESSION['sys']['isLicenseExpired'] == 0) {
      // include update combination page
      $file_name = 'update-combination.php';
      $page_subtitle = "edit";
      $possible_back = false;
    } elseif ($query == 'temp-delete' && $_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      // include delete combination page
      $file_name = 'temp-delete.php';
      $page_subtitle = "delete comb";
      $possible_back = false;
    } elseif ($query == 'delete' && $_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      // include delete combination page
      $file_name = 'delete.php';
      $page_subtitle = "delete comb";
      $possible_back = false;
    } else {
      // include page error module
      $file_name = $globmod . 'page-permission-error.php';
      $possible_back = false;
      $preloader = false;
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
// pre-configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat('../', $level) . 'etc/init.php';
// alerts of system
include_once str_repeat("../", $level) . "etc/system-alerts.php";

// include file name
include_once $file_name;

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
