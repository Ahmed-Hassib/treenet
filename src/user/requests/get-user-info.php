<?php
// get documnet root
$document_root  = $_SERVER['DOCUMENT_ROOT'];
// get user id 
$user_id = isset($_GET['user-id']) ? $_GET['user-id'] : $_SESSION['sys']['UserID'];

// check if arr parameters are entered or not
if (empty($user_id)) {
  echo json_encode(false);
} else {
  if (!isset($session_obj)) {
    // create an object of Session class
    $session_obj = new Session();
  }
  // get user info
  $user_info = $session_obj->get_user_info(base64_decode($user_id));

  // check if done
  if ($user_info[0] == true) {
    // company name
    $company_name = $session_obj->select_specific_column("`company_name`", "`companies`", "WHERE `company_id` = " . $user_info['company_id'])[0]['company_name'];
    // // set user session
    // $session_obj->set_user_session($user_info[1]);
    // convert data into json file
    $json_data = json_encode($user_info[1]);
    // check server name
    if ($_SERVER['SERVER_NAME'] == 'leadergroupegypt.com') {
      // json location
      $json_location = $document_root . "/app/data/json/";
    } else {
      // json location
      $json_location = $document_root . "data/json/";
    }
    // check if the directory is exist or not
    if (!file_exists($json_location)) {
      // create a directory for the company
      mkdir($json_location);
    }
    // json location
    $json_location = $json_location . "employees/$user_id/";
    // check if the directory is exist or not
    if (!file_exists($json_location)) {
      // create a directory for the company
      mkdir($json_location);
    }
    // json file name
    $temp_json_file_name = "temp_user_" . $user_id . "_info.json";
    $prim_json_file_name = "user_" . $user_id . "_info.json";

    // json file location
    $temp_json_file_location = $json_location . $temp_json_file_name;
    $prim_json_file_location = $json_location . $prim_json_file_name;

    // create an json file of direction
    $temp_json_file = fopen($temp_json_file_location, "wr") or die("Cannot open the temp file");

    // put pieces of this dir in it
    fwrite($temp_json_file, $json_data);

    // close file
    fclose($temp_json_file);

    // check if json file of user is exist or not 
    if (file_exists($prim_json_file_location)) {
      // compare the file sizes
      if (file_get_contents($prim_json_file_location) !== file_get_contents($temp_json_file_location)) {
        // put new content
        file_put_contents($prim_json_file_location, file_get_contents($temp_json_file_location));
      }
    } else {
      // create an json file of direction
      $prim_json_file = fopen($prim_json_file_location, "wr") or die("Cannot open the primary file");
      // put new content
      file_put_contents($prim_json_file_location, file_get_contents($temp_json_file_location));
      // close file
      fclose($prim_json_file);
    }
    // remove the temporary file
    unlink($temp_json_file_location);

    // return json file name
    echo json_encode($prim_json_file_name);
  } else {
    die('THERE IS NO USER WITH THIS ID');
  }
}
