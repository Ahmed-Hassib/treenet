<?php
// create an object of Malfunction class
$mal_obj = new Malfunction();
// get malfunction id
$mal_id = isset($_GET['malid']) && !empty($_GET['malid']) ? base64_decode($_GET['malid']) : null;
// get back flag if return back is possible
$is_back = isset($_GET['back']) && !empty($_GET['back']) ? 'back' : null;
// check if the current malfunction id is exist or not
$is_exist = $mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id);
// check if exists
if ($mal_id != null && $is_exist == true) {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // get all malfunctions media to delete it
    $all_media = $mal_obj->get_malfunction_media($mal_id);
    // call delete function
    $is_deleted = $mal_obj->delete_malfunction($mal_id);
    // check if deleted
    if ($is_deleted) {
      // check if current malfunction have media to delete it from local
      if (!is_null($all_media)) {
        // loop on malfunction id to delete it
        foreach ($all_media as $key => $media) {
          // file name
          $media_file_name = $malfunction_media . base64_decode($_SESSION['sys']['company_id']) . "/" . $media['media'];
          // check if media exists
          if (file_exists($media_file_name)) {
            // delete media
            unlink($media_file_name);
          }
        }
      }
      // prepare flash session variables
      $_SESSION['flash_message'] = 'DELETED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'QUERY PROBLEM';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'FEATURE NOT AVAILABLE';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // redirect to the previous page
  redirect_home(null, $is_back, 0);
} else {
  // include no data founded
  include_once $globmod . 'no-data-founded-no-redirect.php';
}
