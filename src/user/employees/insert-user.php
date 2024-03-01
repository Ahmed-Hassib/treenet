<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // GET EMPLOYEE GENERAL INFO
  // get full name
  $fullname = isset($_POST['fullname']) && !empty($_POST['fullname']) ? $_POST['fullname'] : '';
  // get username
  $username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';
  // get company id 
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  // get employee password
  $pass = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : '';
  // get employee email
  $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;
  // get employee job id
  $job_title_id = isset($_POST['job_title_id']) && !empty($_POST['job_title_id']) ? $_POST['job_title_id'] : '';
  // check if job title id == 2 then this is technical man
  $is_tech = $job_title_id == 2 ? 1 : 0;
  // trust statu
  $trust_status = $job_title_id == 1 ? 1 : 0;
  // get employee gender
  $gender = isset($_POST['gender']) && !empty($_POST['gender']) ? $_POST['gender'] : 0;
  // get employee address
  $address = isset($_POST['address']) && !empty($_POST['address']) ? $_POST['address'] : null;
  // get employee phone
  $phone = isset($_POST['phone']) && !empty($_POST['phone']) ? $_POST['phone'] : null;
  // get employee date of birth
  $date_of_birth = isset($_POST['date-of-birth']) && !empty($_POST['date-of-birth']) ? date_format(date_create($_POST['date-of-birth']), 'Y-m-d') : null;
  // get employee twitter account link
  $twitter = isset($_POST['twitter']) && !empty($_POST['twitter']) ? $_POST['twitter'] : null;
  // get employee facebook account link
  $facebook = isset($_POST['facebook']) && !empty($_POST['facebook']) ? $_POST['facebook'] : null;

  // get permissions
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
  $malReview = isset($_POST['malReview']) ? $_POST['malReview'] : 0;
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
  // validate the form
  $formErorr = array();   // error array 

  // validate username
  if (strlen($username) < 0) {
    $formErorr[] = 'username length';
  }

  if (empty($username)) {
    $formErorr[] = 'username empty';
  }

  // validate fullname
  if (empty($fullname)) {
    $formErorr[] = 'fullname empty';
  }

  // validate password
  if (empty($pass)) {
    $formErorr[] = 'password empty';
  } else {
    // encrypt password
    $hashedPass = sha1($pass);
  }
  // check if empty form error
  if (empty($formErorr)) {
    // create an object of User class
    $user_obj = new User();
    // check if user is exist in database or not
    $is_exist_user = $user_obj->count_records("`UserID`", "`users`", "WHERE `username` = '{$username}' AND `company_id` = '{$company_id}'");
    // check the counter
    if ($is_exist_user > 0) {
      $_SESSION['flash_message'] = 'USERNAME EXIST';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'warning';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // check license
      if ($_SESSION['sys']['isLicenseExpired'] == 0) {
        // array of user info
        $user_info = array();
        // push user info into array
        array_push($user_info, $company_id, $username, $hashedPass, $email, $fullname, $is_tech, $job_title_id, $gender, $address, $phone, $date_of_birth, $trust_status, base64_decode($_SESSION['sys']['UserID']), $twitter, $facebook, $userAdd, $userUpdate, $userDelete, $userShow, $malAdd, $malUpdate, $malDelete, $malShow, $malReview, $malMediaDelete, $malMediaDownload, $combAdd, $combUpdate, $combDelete, $combShow, $combReview, $combMediaDelete, $combMediaDownload, $pcsAdd, $pcsUpdate, $pcsDelete, $pcsShow, $clientsAdd, $clientsUpdate, $clientsDelete, $clientsShow, $dirAdd, $dirUpdate, $dirDelete, $dirShow, $connectionAdd, $connectionUpdate, $connectionDelete, $connectionShow, $permissionUpdate, $permissionShow, $changeMikrotikInfo, $changeCompanyImg);
        // call insert user_obj->insert_user_info($user_info);
        $is_inserted = $user_obj->insert_user_info($user_info);

        // check if inserted
        if ($is_inserted) {
          // log message
          $log_msg = "Users dept:: A new user was added succefully!";
          create_logs($_SESSION['sys']['username'], $log_msg);

          $_SESSION['flash_message'] = 'INSERTED';
          $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
          $_SESSION['flash_message_class'] = 'success';
          $_SESSION['flash_message_status'] = true;
          $_SESSION['flash_message_lang_file'] = $lang_file;
        } else {
          $_SESSION['flash_message'] = 'QUERY PROBLEM';
          $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
          $_SESSION['flash_message_class'] = 'danger';
          $_SESSION['flash_message_status'] = false;
          $_SESSION['flash_message_lang_file'] = 'global_';
        }
      } else {
        $_SESSION['flash_message'] = 'LICENSE ENDED NOTE';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
    }
  } else {
    foreach ($formErorr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
  }
  // redirect to previous page
  redirect_home(null, 'back', 15);
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
}
