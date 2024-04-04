<?php
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['sys']['isLicenseExpired'] == 0) {
  // create an object of User class
  $user_obj = new User();

  // get personal info from the form
  $userid = isset($_POST['userid']) && !empty($_POST['userid']) ? base64_decode($_POST['userid']) : '';
  $fullname = isset($_POST['fullname']) && !empty($_POST['fullname']) ? $_POST['fullname'] : '';
  $username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';
  $pass = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : '';
  $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;

  if (base64_decode($_SESSION['sys']['UserID']) == $userid) {
    $job_title_id = base64_decode($_SESSION['sys']['job_title_id']);
  } else {
    $job_title_id = isset($_POST['job_title_id']) ? base64_decode($_POST['job_title_id']) : '';
  }

  $is_tech = $job_title_id == 2 ? 1 : 0;
  $trust_status = $job_title_id == 1 ? 1 : 0;

  $gender = isset($_POST['gender']) && !empty($_POST['gender']) ? $_POST['gender'] : null;
  $address = isset($_POST['address']) && !empty($_POST['address']) ? $_POST['address'] : null;
  $phone = isset($_POST['phone']) && !empty($_POST['phone']) ? $_POST['phone'] : null;
  $dateOfBirth = isset($_POST['date-of-birth']) && !empty($_POST['date-of-birth']) ? $_POST['date-of-birth'] : null;
  $twitter = isset($_POST['twitter']) && !empty($_POST['twitter']) ? $_POST['twitter'] : null;
  $facebook = isset($_POST['facebook'])  && !empty($_POST['facebook']) ? $_POST['facebook'] : null;

  // password trick
  $pass = empty($pass) ? $_POST['old-password'] : sha1($pass);

  // validate the form
  $formErorr = array(); // error array 

  // validate username
  if (strlen($username) < 4) {
    $formErorr[] = 'username length';
  }
  if (empty($username)) {
    $formErorr[] = 'username empty';
  }

  // validate fullname
  if (empty($fullname)) {
    $formErorr[] = 'fullname empty';
  }

  // check if empty form error
  if (empty($formErorr)) {
    // get user that have the same username
    $checkStmt = $con->prepare("SELECT *FROM `users` WHERE `username` = ? AND `UserID` != ? AND `company_id` = ?");
    $checkStmt->execute(array($username, $userid, $_SESSION['sys']['company_id']));
    $count = $checkStmt->rowCount();
    // check if username is exist
    if ($count > 0) {
      $_SESSION['flash_message'] = 'USERNAME EXIST';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // call update user function
      $is_updated = $user_obj->update_user_info(array($username, $pass, $email, $fullname, $is_tech, $job_title_id, $gender, $address, $phone, $dateOfBirth, $trust_status, $twitter, $facebook, $userid));

      // check update permission
      if ($_SESSION['sys']['user_update'] == 1) {
        // user permissions
        $userAdd = isset($_POST['userAdd']) ? $_POST['userAdd'] : 0;
        $userUpdate = isset($_POST['userUpdate']) ? $_POST['userUpdate'] : 0;
        $userDelete = isset($_POST['userDelete']) ? $_POST['userDelete'] : 0;
        $userShow = isset($_POST['userShow']) ? $_POST['userShow'] : 0;
        $pcsAdd = isset($_POST['pcsAdd']) ? $_POST['pcsAdd'] : 0;
        $pcsUpdate = isset($_POST['pcsUpdate']) ? $_POST['pcsUpdate'] : 0;
        $pcsDelete = isset($_POST['pcsDelete']) ? $_POST['pcsDelete'] : 0;
        $pcsShow = isset($_POST['pcsShow']) ? $_POST['pcsShow'] : 0;
        $clientsAdd = isset($_POST['clientsAdd']) ? $_POST['clientsAdd'] : 0;
        $clientsUpdate = isset($_POST['clientsUpdate']) ? $_POST['clientsUpdate'] : 0;
        $clientsDelete = isset($_POST['clientsDelete']) ? $_POST['clientsDelete'] : 0;
        $clientsShow = isset($_POST['clientsShow']) ? $_POST['clientsShow'] : 0;
        $connectionAdd = isset($_POST['connectionAdd']) ? $_POST['connectionAdd'] : 0;
        $connectionUpdate = isset($_POST['connectionUpdate']) ? $_POST['connectionUpdate'] : 0;
        $connectionDelete = isset($_POST['connectionDelete']) ? $_POST['connectionDelete'] : 0;
        $connectionShow = isset($_POST['connectionShow']) ? $_POST['connectionShow'] : 0;
        $dirAdd = isset($_POST['dirAdd']) ? $_POST['dirAdd'] : 0;
        $dirUpdate = isset($_POST['dirUpdate']) ? $_POST['dirUpdate'] : 0;
        $dirDelete = isset($_POST['dirDelete']) ? $_POST['dirDelete'] : 0;
        $dirShow = isset($_POST['dirShow']) ? $_POST['dirShow'] : 0;
        $malAdd = isset($_POST['malAdd']) ? $_POST['malAdd'] : 0;
        $malUpdate = isset($_POST['malUpdate']) ? $_POST['malUpdate'] : 0;
        $malDelete = isset($_POST['malDelete']) ? $_POST['malDelete'] : 0;
        $malShow = isset($_POST['malShow']) ? $_POST['malShow'] : 0;
        $malReviw = isset($_POST['malReview']) ? $_POST['malReview'] : 0;
        $malMediaDelete = isset($_POST['malMediaDelete']) ? $_POST['malMediaDelete'] : 0;
        $malMediaDownload = isset($_POST['malMediaDownload']) ? $_POST['malMediaDownload'] : 0;
        $combAdd = isset($_POST['combAdd']) ? $_POST['combAdd'] : 0;
        $combUpdate = isset($_POST['combUpdate']) ? $_POST['combUpdate'] : 0;
        $combDelete = isset($_POST['combDelete']) ? $_POST['combDelete'] : 0;
        $combShow = isset($_POST['combShow']) ? $_POST['combShow'] : 0;
        $combReview = isset($_POST['combReview']) ? $_POST['combReview'] : 0;
        $combMediaDelete = isset($_POST['combMediaDelete']) ? $_POST['combMediaDelete'] : 0;
        $combMediaDownload = isset($_POST['combMediaDownload']) ? $_POST['combMediaDownload'] : 0;
        $changeMikrotikInfo = isset($_POST['changeMikrotikInfo']) ? $_POST['changeMikrotikInfo'] : 0;
        $permissionUpdate = isset($_POST['permissionUpdate']) ? $_POST['permissionUpdate'] : 0;
        $permissionShow = isset($_POST['permissionShow']) ? $_POST['permissionShow'] : 0;
        $changeCompanyImg = isset($_POST['changeCompanyImg']) ? $_POST['changeCompanyImg'] : 0;

        // array of permissions
        $permissions = array();
        // permisssions
        array_push($permissions, $userAdd, $userUpdate, $userDelete, $userShow, $malAdd, $malUpdate, $malDelete, $malShow, $malReviw, $malMediaDelete, $malMediaDownload, $combAdd, $combUpdate, $combDelete, $combShow, $combReview, $combMediaDelete, $combMediaDownload, $pcsAdd, $pcsUpdate, $pcsDelete, $pcsShow, $clientsAdd, $clientsUpdate, $clientsDelete, $clientsShow, $dirAdd, $dirUpdate, $dirDelete, $dirShow, $connectionAdd, $connectionUpdate, $connectionDelete, $connectionShow, $permissionUpdate, $permissionShow, $changeMikrotikInfo, $changeCompanyImg, $userid);
        // call permission update function
        $user_obj->update_user_permissions($permissions);
      }

      // get profile image info
      $file_name = $_FILES['profile-img-input']['name'];
      $file_type = $_FILES['profile-img-input']['type'];
      $file_error = $_FILES['profile-img-input']['error'];
      $file_size = $_FILES['profile-img-input']['size'];
      $files_tmp_name = $_FILES['profile-img-input']['tmp_name'];

      // check if profile image changed
      if ($file_error == 0 && $file_size > 0 && $file_size < $user_obj->max_file_size) {
        // profile image path
        $path = $uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/";
        // check path
        if (!file_exists($path)) {
          mkdir($path);
        }
        // media temp
        $media_temp = [];
        // check if not empty
        if (!empty($file_name)) {
          // get old pgoto
          $old_name = $user_obj->select_specific_column("`profile_img`", "`users`", "WHERE `UserID` = $userid")[0]['profile_img'];
          // check if not empty && exist
          if (!empty($old_name) && file_exists($path . $old_name)) {
            // delete old one
            unlink($path . $old_name);
          }
          $media_temp = explode('.', $file_name);
          $media_temp[0] = date('dmY') . '_' . $userid . '_' . rand(00000000, 99999999);
          $media_name = join('.', $media_temp);
          move_uploaded_file($files_tmp_name, $path . $media_name);

          // upload files info into database
          $user_obj->upload_profile_img(array($media_name, $userid));
        }
      }

      // update SESSION variables
      if (base64_decode($_SESSION['sys']['UserID']) == $userid) {
        // create an object of Session class
        $session_obj = new Session();
        // get user info
        $user_info = $session_obj->get_user_info($userid);

        // check if done
        if (!is_null($user_info)) {
          // set user session
          $session_obj->set_user_session($user_info);
        }
      }
      // log message
      $log_msg = "Update user info -> username: " . $username . ".";
      create_logs($_SESSION['sys']['username'], $log_msg);

      // check if updated
      if ($is_updated) {
        $_SESSION['flash_message'] = 'UPDATED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = $lang_file;
      } else {
        $_SESSION['flash_message'] = 'NO CHANGES';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'info';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
    }
  } else {
    // loop on form error array
    foreach ($formErorr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
  }
  // redirect to previous page
  redirect_home(null, 'back', 0);
} else {
  // include_once per
  include_once $globmod . 'permission-error.php';
}
