<pre dir="ltr">
<?php
// check method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get ids
  $ids = $_POST['id'];
  // get coordinates
  $coordinates = $_POST['coordinates'];

  // empty array of errors
  $err_arr = array();

  // check ids and coordinates
  if (empty($ids) || empty($coordinates)) {
    $err_arr[] = 'missing data';
  }

  // check array of errors
  if (empty($err_arr)) {
    // create an object of pieces
    $pcs_obj = new Pieces();

    // updates
    $updates = 0;

    // loop on ids
    foreach ($ids as $key => $id) {
      // check id and coordinate
      if (!empty($id) && !empty($coordinates[$key])) {
        // update coordinate of current id
        $is_updated = $pcs_obj->update_coordinates($id, $coordinates[$key]);
        // check if updated
        if ($is_updated) {
          $updates++;
        }
      }
    }

    // check updates
    if ($updates == count($ids)) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'coordinates updated';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'some coordinates updated';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    }

  } else {
    foreach ($err_arr as $key => $error) {
      // prepare flash session variables
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = 'global_';
    }
  }
  // redirect back
  redirect_home(null, 'back', 0);
} else {
  // permission error
  include_once $globmod . "permission-error.php";
}
