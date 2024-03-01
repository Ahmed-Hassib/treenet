<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// title page
$page_title = "treenet";
// page category
$page_category = "website";
// page role
$page_role = "website_desc";
// folder name of dependendies
$dependencies_folder = "website/";
// language file
$lang_file = "description";
// level
$level = 3;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// get query value
$query = isset($_GET['d']) && !empty($_GET['d']) ? base64_decode($_GET['d']) : null;

// check query
if ($query == 'treenet') {
  $file_name = 'abstract.php';
  $page_subtitle = "abstract";
} else {
  // include permission error module
  $file_name = $globmod . 'no-data-founded-no-redirect.php';
}

// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// include file name
include_once $file_name;

// include js files
include_once $tpl . "js-includes.php";

ob_end_flush();
?>