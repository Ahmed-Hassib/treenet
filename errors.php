<?php

/**
 * ERRORS PAGE HANDLE
 * 403 => permission denied
 * 404 => page not found
 * 500 => server error
 */
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = "page not found";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_err";

// language file
$lang_file = "not_found";
// level
$level = 0;
// nav level
$nav_level = 1;
// flag to determine if current page is sys tree page or not
$is_treenet_page = true;
// flag if page has a map
$having_map = false;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// target url
$target_url = "./index.php";
// get error type
$err = isset($_GET['err']) && !empty($_GET['err']) ? $_GET['err'] : '404';

if (isset($_SESSION['sys']['username'])) {
  $target_url = "{$src}user/";
}
// check error type
switch ($err) {
  case '403':
    $file_name = '403.php';
    $page_title = "access denied";
    break;

  default:
    $file_name = '404.php';
    break;
}

// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// alerts of system
include_once str_repeat("../", $level) . "etc/system-alerts.php";

// default path
$default_path = "errors/404.php";
// file path
$file_path = "errors/{$file_name}";

// check file path 
if (file_exists($file_path)) {
  // include file name
  include_once $file_path;
} else {
  // include default path
  include_once $default_path;
}

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
