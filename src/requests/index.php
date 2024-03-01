<?php
// set the default timezone to use.
date_default_timezone_set('Africa/Cairo');
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();

// no header
$no_header = true;
// no navbar
$no_navbar = true;
// page title
$page_title = "";
// lang file
$lang_file = "";
// page category
$page_category = "treenet";

// level
$level = 2;
// nav level
$nav_level = 1;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

// check if Get request do is set or not
$query = isset($_GET['do']) ? $_GET['do'] : '';

// global connection to database
global $con;

// if search for company name
if ($query == "search-company") {
  include_once "search-company.php";
} elseif ($query == "search-username") {
  include_once "search-username.php";
} elseif ($query == 'check-username') {
  include_once "check-username.php";
} elseif ($query == 'check-company-name') {
  include_once "check-company-name.php";
}
