<?php

// connect to database from configration file
require_once 'local-conf.php';
// is app suspended
$is_developing = $db_obj->select_specific_column("`is_developing`", "`settings`", "LIMIT 1")[0]['is_developing'] ?? 0;

// check session
if ($page_category == 'treenet' && isset($_SESSION['sys'])) {
  // get user version of system
  $curr_version = isset($_SESSION['sys']['curr_version_name']) ? $_SESSION['sys']['curr_version_name'] : "v1.0.3";
  // check system language
  $page_dir = $_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr';
} else {
  // default
  $page_dir = 'rtl';
}

// include routes file
require_once "check-version.php";
require_once "app-routes.php";
require_once "system-architecture.php";

// include_once the important files
include_once $func . "func-conf.php";
include_once $lan . "lang.php";

// require vendor autoload
require_once $vendor . "autoload.php";