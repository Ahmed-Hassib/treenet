<?php
// include mikrotic api
include_once "{$func}api.php";
// create an object of RouterosAPI (Mikrotik API)
$mikrotik_api = new RouterosAPI();
// all data
$get_req_data = json_decode($_GET['data'][0]);
// check parameter data in GET request
if (isset($get_req_data) && !empty($get_req_data) && count($get_req_data) == 4) {
  // create an object of Company class
  $company_obj = new Company();

  // get mikrotik info
  // get company remote ip
  $host = $company_obj->get_remote_ip(base64_decode($_SESSION['sys']['company_id']));
  // // get host
  // $host = $get_req_data[0];
  // get port
  $port = $get_req_data[1];
  // get username
  $username = $get_req_data[2];
  // get password
  $password = $get_req_data[3];

  echo json_encode($mikrotik_api->connect($host, $username, $password));
} else {
  echo json_encode(false);
}