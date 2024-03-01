
<?php
// start output buffering
ob_start();
// start session
session_start();
// regenerate session id
session_regenerate_id();
// no navbar
$no_navbar = "all";
$no_footer = "all";
// title page
$page_title = "signup";
// page category
$page_category = "treenet";
// page role
$page_role = "treenet_signup";

// language file
$lang_file = "login";
// level
$level = 0;
// nav level
$nav_level = 0;
// app status and global includes
include_once str_repeat("../", $level) . "etc/app-status.php";

// check if app is developing now or not
if ($is_developing == false) {
  // check username in SESSION variable
  if (isset($_SESSION['sys']['username'])) {
    if ($_SESSION['sys']['is_root'] == 1) {
      // redirect to admin page
      header("Location: {$treenet_root}dashboard/index.php");
      exit();
    } else {
      // redirect to user page
      header("Location: {$treenet_user}dashboard/index.php");
      exit();
    }
  } else {
    $_SESSION['sys']['lang'] = 'ar';
  }
  // check if GET variable isset
  if (isset($_POST) && !empty($_POST)) {
    // include process file
    $file_name = 'signup-process.php';
  } else {
    // include signup form
    $file_name = 'signup-form.php';
  }
  $file_name = "{$src}signup/$file_name";
} else {
  $file_name = $globmod . "under-developing.php";
}
// pre configration of system
include_once str_repeat("../", $level) . "etc/pre-conf.php";
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";
// include file
include_once $file_name;
// include js files
include_once $tpl . "js-includes.php";
