<?php
// developer name
$developerName = "ahmed hassib";
// sponsor company
$sponsorCompany = "leader group";
// company name
$appName = $conf['app_name'];

// check if sys tree pages
if ($is_developing == false && isset($_SESSION['sys']) && $page_category != 'website') {
  // include mikrotic api
  include_once $func . "api.php";
  // check mikrotik info
  if (isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['ip']) && !empty($_SESSION['sys']['mikrotik']['username']) && !empty($_SESSION['sys']['mikrotik']['password'])) {
    // get mikrotek data
    $mikrotik_ip = $_SESSION['sys']['mikrotik']['ip'];
    $mikrotik_port = $_SESSION['sys']['mikrotik']['port'];
    $mikrotik_username = $_SESSION['sys']['mikrotik']['username'];
    $mikrotik_password = $_SESSION['sys']['mikrotik']['password'];
    // create an object of mikrotek api
    $api_obj = new RouterosAPI();
  }
}

// include_once header in all pages expect pages include_once no_header
if (!isset($no_header)) {
  include_once $tpl . "header.php";
}
