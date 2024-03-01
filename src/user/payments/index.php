<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "payments";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_payment";

// language file
$lang_file = "payment";
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
    $query = isset($_GET['do']) ? $_GET['do'] : 'pricing';

    // start pricing page
    if ($query == 'pricing') {
      $page_title = "pricing plans";
      // include dashboard
      $file_name = "pricing.php";
      $possible_back = true;
      $is_stored = true;
      $preloader = true;
      // start pricing page
    } elseif ($query == 'transactions') {
      $page_title = "transactions";
      // include dashboard
      $file_name = "transactions.php";
      $possible_back = true;
      $is_stored = true;
      $is_contain_table = true;
      $preloader = true;
    } elseif ($query == 'details') {
      $file_name = "details.php";
      $preloader = true;
    } elseif ($query == 'pay') {
      $file_name = "pay.php";
      $preloader = true;
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
