<?php
// create an object of Malfunction class
$mal_obj = new Malfunction();
// get media id
$media_id = isset($_GET['media-id']) && !empty($_GET['media-id']) ? $_GET['media-id'] : 0;
// check media id
if ($mal_obj->is_exist("`id`", "`malfunctions_media`", $media_id)) {
  // get media name
  $media_name = isset($_GET['media-name']) && !empty($_GET['media-name']) ? $_GET['media-name'] : '';
  // delete media from database
  $is_deleted = $mal_obj->delete_media($media_id);
  // check media name
  if (!empty($_GET['media-name'])) {
    // file full path
    $file_full_path = $uploads . "malfunctions/" . base64_decode($_SESSION['sys']['company_id']) ."/". $media_name;
    // delete media from server files
    unlink($file_full_path);
  }
  echo json_encode($is_deleted);
} else {
  echo json_encode(false);
}