<?php

// check action
$action = isset($_GET['action']) && !empty($_GET['action']) ? trim($_GET['action'], ' ') : 'dashboard';

// choose file
switch ($action) {
  case 'dashboard':
    $subfile_name = 'dashboard.php';
    $page_subtitle = "deleted malfunctions";
    break;

  case 'restore':
    $subfile_name = 'restore.php';
    $page_subtitle = "restore malfunctions";
    break;

  default:
    $subfile_name = 'dashboard.php';
}

// return sub file name
return $subfile_name;
