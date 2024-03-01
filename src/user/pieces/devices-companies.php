<?php

$preloader = false;
$is_stored = false;

$action_file = 'devices-companies/';

// chekc action
switch ($action) {
  case 'manage':
    // include pieces types dashboard
    $action_file .= 'dashboard.php';
    $page_subtitle = 'dashboard';
    $preloader = true;
    $is_stored = true;
    $is_contain_table = true;
    break;

  case 'insert-man-company':
    // include insert pieces types module
    $action_file .= 'insert-man-company.php';
    $page_subtitle = 'add company';
    break;

  case 'update-man-company':
    // include update pieces types module
    $action_file .= 'update-man-company.php';
    $page_subtitle = 'edit company info';
    break;

  case 'delete-man-company':
    // include delete pieces types module
    $action_file .= 'delete-man-company.php';
    $page_subtitle = 'delete company info';
    break;

  case 'insert-device':
    // include delete pieces types module
    $action_file .= 'insert-device.php';
    $page_subtitle = 'add device';
    break;

  case 'show-devices':
    // include sho pieces types module
    $action_file .= 'show-devices-companies.php';
    $page_subtitle = 'company`s devices';
    $is_contain_table = true;
    $is_stored = true;
    $preloader = true;
    break;

  case 'show-device':
    // include sho pieces types module
    $action_file .= 'show-device.php';
    $page_subtitle = 'edit device';
    $is_contain_table = true;
    $is_stored = true;
    $preloader = true;
    break;

  case 'update-device':
    // include sho pieces types module
    $action_file .= 'update-device.php';
    $page_subtitle = 'edit';
    break;

  case 'delete-device':
    // include sho pieces types module
    $action_file .= 'delete-device.php';
    $page_subtitle = 'delete device';
    break;

  case 'insert-model':
    // include sho pieces types module
    $action_file .= 'insert-model.php';
    $page_subtitle = 'add model';
    break;

  case 'update-model':
    // include sho pieces types module
    $action_file .= 'update-model.php';
    $page_subtitle = 'edit model info';
    break;

  case 'delete-model':
    // include sho pieces types module
    $action_file .= 'delete-model.php';
    $page_subtitle = 'delete model info';
    break;

  default:
    // include page not founded module
    $action_file = $globmod . 'page-error.php';
}

// include action file 
return $action_file;
