<?php

/**
 * DIRECTIONS PAGE
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// flag to determine if current page is sys tree page or not
$is_treenet_page = true;
// page title
$page_title = "the directions";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_dir";

// language file
$lang_file = "directions";
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

$possible_back = false;
$preloader = true;

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username'])) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($query == 'manage' && $_SESSION['sys']['dir_show'] == 1) {
      $file_name = 'dashboard.php';
      $page_subtitle = "list";
      $possible_back = true;
    } elseif ($query == 'insert-new-direction' && $_SESSION['sys']['dir_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'insert-direction.php';
      $page_subtitle = "add new";
    } elseif ($query == 'show-direction-tree' && $_SESSION['sys']['dir_show'] == 1) {
      $file_name = 'show-direction.php';
      $page_subtitle = "show tree";
      $no_footer = true;
      $possible_back = true;
    } elseif ($query == 'direction-map' && $_SESSION['sys']['dir_show'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'direction-map.php';
      $page_subtitle = "directions map";
      $possible_back = true;
      $is_contain_map = true;
    } elseif ($query == 'update-direction-info' && $_SESSION['sys']['dir_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'update-direction.php';
      $page_subtitle = "edit";
    } elseif ($query == 'delete-direction' && $_SESSION['sys']['dir_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'delete-direction.php';
      $page_subtitle = "delete";
    } elseif ($query == 'update-coordinates') {
      $file_name = "update-coordinates.php";
      $page_subtitle = "update coordinates";
    } elseif ($query == 'upload') {
      $file_name = "upload.php";
      $page_subtitle = "upload data";
    } else {
      $file_name = $globmod . 'page-permission-error.php';
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    // include permission error page
    $file_name = $globmod . 'permission-error.php';
    $no_navbar = 'all';
    $no_footer = 'all';
  }
} else {
  $file_name = $globmod . "under-developing.php";
}
// pre configration of system
include_once str_repeat('../', $level) . 'etc/pre-conf.php';
// initial configration of system
include_once str_repeat('../', $level) . 'etc/init.php';
// alerts of system
include_once str_repeat("../", $level) . "etc/system-alerts.php";

// include file name
include_once $file_name;
// check if contains no footer variables or not
if (!isset($no_footer)) {
  // include footer
  include_once $tpl . 'footer.php';
}

include_once $tpl . 'js-includes.php';
// 
ob_end_flush();
