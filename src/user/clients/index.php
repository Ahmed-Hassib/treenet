<?php

/**
 * clientS PAGE
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = 'clts';
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_clients";

// language file
$lang_file = 'clients';
// level
$level = 3;
// nav level
$nav_level = 1;
// flag to determine if current page is sys tree page or not
$is_treenet_page = true;
$possible_back = true;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check system if under developing or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username'])) {
    // check if Get request do is set or not
    $query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'manage';
    $preloader = true;

    // start manage page
    if ($query == 'manage' && $_SESSION['sys']['clients_show'] == 1) {
      $file_name = 'dashboard.php';
      $page_subtitle = "dashboard";
      $is_contain_table = true;
    } elseif ($query == 'show-all-clients' && $_SESSION['sys']['clients_show'] == 1) {
      $file_name = 'show-all-clients.php';
      $page_subtitle = "list";
      $is_contain_table = true;
    } elseif ($query == 'add-new-client' && $_SESSION['sys']['clients_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'add-new-client.php';
      $page_subtitle = "add new";
    } elseif ($query == 'insert-client-info' && $_SESSION['sys']['clients_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = 'insert-client-info.php';
      $page_subtitle = "add new";
      $possible_back = false;
    } elseif ($query == 'edit-client' && ($_SESSION['sys']['clients_update'] == 1 || $_SESSION['sys']['clients_show'] == 1)) {
      $file_name = 'edit-client.php';
      $page_subtitle = "edit";
      $is_contain_map = true;
    } elseif ($query == 'update-client-info' && $_SESSION['sys']['clients_update'] == 1) {
      $file_name = 'update-client-info.php';
      $page_subtitle = "edit";
      $possible_back = false;
    } elseif ($query == 'temp-delete' && $_SESSION['sys']['clients_delete'] == 1) {
      $file_name = 'temp-delete.php';
      $page_subtitle = "delete clt";
      $possible_back = false;
    } elseif ($query == 'delete' && $_SESSION['sys']['clients_delete'] == 1) {
      $file_name = 'delete.php';
      $page_subtitle = "delete clt";
      $possible_back = false;
    } elseif ($query == 'restore' && $_SESSION['sys']['clients_delete'] == 1) {
      $file_name = 'restore.php';
      $page_subtitle = "restore clts";
      $possible_back = false;
    } elseif ($query == 'deletes' && $_SESSION['sys']['clients_delete'] == 1) {
      $file_name = 'deletes.php';
      $page_subtitle = "deletes";
      $is_contain_table = true;
      $possible_back = false;
    } elseif ($query == 'show-dir-clients' && $_SESSION['sys']['clients_show'] == 1) {
      $file_name = 'show-dir-clients.php';
      $page_subtitle = "dir clts";
      $is_contain_table = true;
    } elseif ($query == 'prepare-ip' && $_SESSION['sys']['clients_show'] == 1) {
      $file_name = 'prepare-ip.php';
      $page_subtitle = "";
    } elseif ($query == 'upload' && $_SESSION['sys']['clients_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      $file_name = "upload.php";
      $page_subtitle = "upload data";
    } else {
      $file_name = $globmod . 'page-permission-error.php';
      $possible_back = false;
      $no_navbar = 'all';
      $no_footer = 'all';
    }
  } else {
    $file_name = $globmod . 'permission-error.php';
    $possible_back = false;
    $no_navbar = 'all';
    $no_footer = 'all';
  }
  // check delete permission
  if ($_SESSION['sys']['clients_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
    // include confirmation delete modal
    include_once 'delete-client-modal.php';
  }
  // include ping modal
  include_once $globmod . 'ping-modal.php';
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
