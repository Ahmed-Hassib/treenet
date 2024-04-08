<?php
// get documnet root
$document_root = $_SERVER['DOCUMENT_ROOT'];
// get device id
$device_id = isset($_GET['device-id']) && !empty($_GET['device-id']) ? base64_decode($_GET['device-id']) : 0;
// company_id
$company_id = $_SESSION['sys']['company_id'];
// check if arr parameters are entered or not
if ($device_id == 0) {
  // if device id not set return false
  echo json_encode(false);
} else {
  // create an object of Model
  $devices_obj = new Devices();
  // get specific columns from pieces table
  $device_name = $devices_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = $device_id")['device_name'];
  // get specific columns from pieces table
  $data = $devices_obj->get_all_device_models($device_id);
  // company name
  $company_name = $devices_obj->select_specific_column("`company_name`", "`companies`", "WHERE `company_id` = '" . base64_decode($company_id) . "'")['company_name'];
  // convert data into json file
  $json_data = json_encode($data);
  // json location
  $json_location = $document_root . "/data/json/";
  // check if the directory is exist or not
  if (!file_exists($json_location)) {
    // create a directory for the company
    mkdir($json_location);
  }
  // json location
  $json_location = $json_location . "devices-models/$company_id/";
  // check if the directory is exist or not
  if (!file_exists($json_location)) {
    // create a directory for the company
    mkdir($json_location);
  }
  // json file name
  $json_file_name = "models-of-" . $device_id . ".json";
  // json file location
  $json_file_location = $json_location . $json_file_name;
  // create an json file of direction
  $json_file = fopen($json_file_location, "wr") or die("Cannot open file");
  // put pieces of this dir in it
  fwrite($json_file, $json_data);
  // close file
  fclose($json_file);
  // return json file name
  echo json_encode($json_file_name);
}