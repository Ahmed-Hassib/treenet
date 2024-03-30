<?php

// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// page title
$page_title = "tree net";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_landing";

// language file
$lang_file = "landing";
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

// get query
$query = isset($_GET['do']) && !empty($_GET['do']) ? $_GET['do'] : 'main';

// check query
if ($query == 'main') {
  // file name
  $file_name = "landing.php";
  // page subtitle
  $page_subtitle = "home desc";
}

// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// alerts of system
include_once str_repeat("../", $level) . "etc/system-alerts.php";

// include landing page
include_once "{$src}landing/{$file_name}";

// include footer
include_once $tpl . "footer.php";
include_once $tpl . "js-includes.php";

ob_end_flush();
