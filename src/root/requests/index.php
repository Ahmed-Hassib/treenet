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
// page category
$page_category = "treenet";
// page title
$page_title = "";
// lang file
$lang_file = "";
// level
$level = 3;
// nav level
$nav_level = 1;

$possible_back = false;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";
// pre configration of system
include_once str_repeat('../', $level) . 'etc/pre-conf.php';
// initial configration of system
include_once str_repeat('../', $level) . 'etc/init.php';

// check if Get request do is set or not
$query = isset($_GET['do']) ? $_GET['do'] : '';

switch ($query) {
  case 'get-source':
    $file_name = 'get-sources.php';
    break;

  case 'search':
    $file_name = 'search-clients.php';
    break;

  case 'get-device-models':
    $file_name = 'get-device-models.php';
    break;

  case 'get-user-info':
    $file_name = 'get-user-info.php';
    break;

  case 'update-session':
    $file_name = 'update-session.php';
    break;

  case 'upgrade-version':
    $file_name = 'upgrade-version.php';
    break;

  case 'check-piece-fullname':
    $file_name = 'check-piece-fullname.php';
    break;

  case 'check-combination-client-name':
    $file_name = 'check-combination-client-name.php';
    break;

  case 'check-piece-ip':
    $file_name = 'check-piece-ip.php';
    break;

  case 'check-piece-macadd':
    $file_name = 'check-piece-macadd.php';
    break;

  case 'check-username':
    $file_name = 'check-username.php';
    break;

  case 'check-direction':
    $file_name = 'check-direction-name.php';
    break;

  case 'delete-malfunction-media':
    $file_name = 'delete-malfunction-media.php';
    break;

  case 'delete-combination-media':
    $file_name = 'delete-combination-media.php';
    break;

  case 'delete-profile-img':
    $file_name = 'delete-profile-img.php';
    break;

  case 'delete-company-img':
    $file_name = 'delete-company-img.php';
    break;

  case 'activate-phone-number':
    $file_name = 'activate-phone-number.php';
    break;

  case 'rating-app':
    $file_name = 'rating-app.php';
    break;

  case 'ping':
    $file_name = 'ping.php';

  case 'check-mikrotik-info':
    $file_name = 'check-mikrotik-info.php';
}

include_once $file_name;