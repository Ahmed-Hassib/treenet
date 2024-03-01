<?php
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  // create an object of Company class
  $company_obj = !isset($company_obj) ? new Company() : $company_obj;
  // get company image info
  $file_name = $_FILES['company-img-input']['name'];
  $file_type = $_FILES['company-img-input']['type'];
  $file_error = $_FILES['company-img-input']['error'];
  $file_size = $_FILES['company-img-input']['size'];
  $files_tmp_name = $_FILES['company-img-input']['tmp_name'];

  // check if company image changed
  if ($file_error == 0 && $file_size > 0) {
    // company image path
    $path = $uploads . "//companies-img/$company_id/";
    // check path
    if (!file_exists($path)) {
      mkdir($path);
    }
    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($file_name)) {
      $media_temp = explode('.', $file_name);
      $media_temp[0] = date('dmY') . '_' . $company_id . '_' . rand(00000000, 99999999);
      $media_name = join('.', $media_temp);
      move_uploaded_file($files_tmp_name, $path . $media_name);

      // upload files info into database
      $is_changed = $company_obj->upload_company_img(array($media_name, $company_id));
    }

    if ($is_changed) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'IMG UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;

      // log message
      $log_msg = "company image was updated successfully by " . $_SESSION['sys']['username'] . " at " . date('D d/m/Y h:i a');
      if (!isset($session_obj)) {
        // create an object of Session class
        $session_obj = new Session();
      }
      // get user info
      $user_info = $session_obj->get_user_info(base64_decode($_SESSION['sys']['UserID']));
      // check if done
      if ($user_info[0] == true) {
        // set user session
        $session_obj->set_user_session($user_info[1]);
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'QUERY PROBLEM';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
      // log message
      $log_msg = "company image was not updated because there is a problem while updating it";
    }
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = 'NO CHANGES';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'info';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
    // log message
    $log_msg = "there is no images was added to update company image";
  }
  // create a log
  create_logs($_SESSION['sys']['username'], $log_msg);
  // redirect home
  redirect_home(null, 'back', 0);
} else {
  // include_once per
  include_once $globmod . 'permission-error.php';
}
