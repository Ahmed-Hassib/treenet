<?php
if (isset($_POST['dir_id']) && !empty($_POST['dir_id']) && isset($_POST['src_id']) && !empty($_POST['src_id'])) {
  // include Database and Direction class
  include str_repeat("../", 3) . "classes/Database.class.php";
  include str_repeat("../", 3) . "classes/Direction.class.php";
  include str_repeat("../", 3) . "includes/functions/functions.php";

  // get company id
  $company_id = base64_decode($_POST['company_id']);

  // check direction id
  if (is_numeric($_POST['dir_id'])) {
    $dir_id = $_POST['dir_id'];
  } else {
    // get direction id
    $dir_id = base64_decode($_POST['dir_id']);
  }
  // get source id
  $src_id = $_POST['src_id'];

  // create new direction object
  $dir_obj = new Direction();

  // get all point`s children
  $point_children = $dir_obj->get_all_source_pcs_coordinates($dir_id, $src_id, $company_id);

  // array of response
  $response = array();
  // check children count
  foreach ($point_children as $key => $child) {
    // extract children
    extract($child, EXTR_REFS);
    $child_arr = [
      'id' => $id,
      'ip' => $ip,
      'full_name' => $full_name,
      'is_client' => $is_client,
      'device_type' => $device_type,
      'source_id' => $source_id,
      'coordinates' => $coordinates
    ];

    array_push($response, $child_arr);
  }

  // return result
  echo json_encode($response);
}
