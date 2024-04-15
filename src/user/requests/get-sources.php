<?php
// get documnet root
$document_root = $_SERVER['DOCUMENT_ROOT'];
// get dir id
$dir_id = isset($_GET['dir-id']) ? base64_decode($_GET['dir-id']) : 0;
// company id
$company_id = isset($_GET['company']) ? $_SESSION['sys']['company_id'] : 0;

// check if arr parameters are entered or not
if (empty($dir_id) || empty($company_id)) {
  echo json_encode(false);
} else {
  // create an object of pieces
  $pcs_obj = new Pieces();
  // condition
  $pcs_condition = "WHERE `is_client` = 0 AND `direction_id` = $dir_id AND `company_id` = " . base64_decode($company_id) . " ORDER BY `direction_id` ASC, `id` ASC";
  // get specific columns from pieces table
  $data = $pcs_obj->select_specific_column("`id`, `ip`, `full_name`", "`pieces_info`",$pcs_condition, 'multiple');
  // company name
  $company_name = $pcs_obj->select_specific_column("`company_name`", "`companies`", "WHERE `company_id` = " . base64_decode($company_id))['company_name'];
  // convert data into json file
  $json_data = json_encode($data);
  // json location
  $json_location = $document_root . "/data/json/dirs/";
  // check if the directory is exist or not
  if (!file_exists($json_location)) {
    // create a directory for the company
    mkdir($json_location);
  }
  // json location
  $json_location .= "$company_id/";
  // echo $json_location;
  // check if the directory is exist or not
  if (!file_exists($json_location)) {
    // create a directory for the company
    mkdir($json_location);
  }
  // json file name
  $json_file_name = "source-of-dir" . $dir_id . ".json";
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
