<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // create an object of Malfunction class
    $mal_obj = new Malfunction();
    // get update owner id
    $update_owner_id = base64_decode($_SESSION['sys']['UserID']);
    // get update owner type
    $update_owner_type = $_SESSION['sys']['is_tech'];
    // get update owner job_id
    $update_owner_job_id = base64_decode($_SESSION['sys']['job_title_id']);
    // get malfunction id
    $mal_id = isset($_POST['mal-id']) && !empty($_POST['mal-id']) ? base64_decode($_POST['mal-id']) : 0;
    // check if malfunction is exist or not
    if ($mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id)) {
      // get malfunction basics info
      $mal_info = $mal_obj->get_malfunctions("WHERE `mal_id` = " . $mal_id . " AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
      // check if exist again
      if (!is_null($mal_info)) {
        // get new malfunction info
        $manager_id = base64_decode($_POST['admin-id']);
        $tech_id = base64_decode($_POST['technical-id-value']);

        // check who is doing the update
        switch ($update_owner_job_id) {
          /**
           * updates for:
           * [1] The Manager
           * [2] Customer Services
           */
          case 1:
          case 3:
          case 4:
            if ($mal_info['mal_status'] != 1) {
              $is_updated = do_manager_updates($_POST);
            } else {
              $is_updated = do_after_sales_updates($_POST);
            }

            // check status updates
            if ($is_updated['status']) {
              // add malfunction updates info
              add_updates_details($mal_id, $update_owner_id, $is_updated['updates'], base64_decode($_SESSION['sys']['company_id']));
            }
            break;
          /**
           * updates for:
           * [1] Technical Man
           */
          case 2:
            $path = $uploads . "malfunctions/";
            // check who is doing the updates
            if ($update_owner_id == $tech_id && $mal_info['mal_status'] != 1) {
              $is_updated = do_technical_updates($_POST, count($_FILES) && $_FILES['cost-receipt']['size'] > 0 && $_FILES['cost-receipt']['error'] == 0 ? $_FILES['cost-receipt'] : null, $path);
              // check status updates
              if ($is_updated['status']) {
                // get updates
                $updates = $is_updated['updates'];
                // loop on it
                foreach ($updates as $key => $update) {
                  // add alfunction updates info
                  add_updates_details($mal_id, $update_owner_id, $update, base64_decode($_SESSION['sys']['company_id']));
                }
              }
            }

            // check if upload media
            if (count($_FILES) > 0 && key_exists('mal-media', $_FILES)) {
              upload_malfunction_media($_FILES, $mal_id, $path);
            }
            break;
        }
        // prepare flash session variables
        $_SESSION['flash_message'] = 'UPDATED';
        $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
        $_SESSION['flash_message_class'] = 'success';
        $_SESSION['flash_message_status'] = true;
        $_SESSION['flash_message_lang_file'] = $lang_file;
      } else {
        // prepare flash session variables
        $_SESSION['flash_message'] = 'NO DATA';
        $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
        $_SESSION['flash_message_class'] = 'danger';
        $_SESSION['flash_message_status'] = false;
        $_SESSION['flash_message_lang_file'] = 'global_';
      }
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO DATA';
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
  redirect_home(null, 'back', 0);
} else {
  // include no data founded
  include_once $globmod . 'permission-error.php';
}

/**
 * do_manager_updates function
 * used to do only manager updates
 */
function do_manager_updates($info)
{
  // create an object of Malfunction class
  $mal_obj = !isset($mal_obj) ? new Malfunction() : $mal_obj;
  // get malfunction id
  $mal_id = base64_decode($info['mal-id']);
  // get malfunction technical id
  $tech_id = base64_decode($info['technical-id-value']);
  // get malfunction description
  $descreption = $info['descreption'];
  // get previous malfunction tecnical id
  $prev_tech_id = $mal_obj->select_specific_column("`tech_id`", "`malfunctions`", "WHERE `mal_id` = $mal_id")[0]['tech_id'];
  // compare new tech with the old
  if ($tech_id == $prev_tech_id) {
    // update all malfunction info
    $is_updated = $mal_obj->update_malfunction_mng(array($descreption, $mal_id));
    $updates = 'update malfunction';
  } else {
    // reset malfunction info
    $is_updated = $mal_obj->reset_malfunction_info(array($tech_id, $descreption, get_date_now(), get_time_now(), $mal_id));
    $updates = 'reset malfunction';
  }
  // return status
  return [
    'status' => $is_updated,
    'updates' => $updates
  ];
}

/**
 * do_technical_updates function
 * used to do only technical updates
 */
function do_technical_updates($info, $cost_media, $media_path)
{
  $updates = [];
  // create an object of Malfunction class
  $mal_obj = new Malfunction();
  // get malfunction id
  $mal_id = base64_decode($info['mal-id']);
  // get malfunction status
  $mal_status = base64_decode($info['mal-status']);
  // get technical status
  $tech_status = base64_decode($info['mal-status']);
  // get technical man comment
  $tech_comment = isset($info['comment']) ? $info['comment'] : '';
  // get technical man status comment
  $tech_comment_status = isset($info['tech-status-comment']) ? $info['tech-status-comment'] : '';
  // get malfunction cost
  $cost = $_POST['cost'];
  // get malfunctions cost receipt 
  $mal_info = $mal_obj->select_specific_column("`cost_receipt`", "`malfunctions`", "WHERE `mal_id` = $mal_id");
  $cost_receipt_name = count($mal_info) > 0 ? $mal_info[0]['cost_receipt'] : null;

  if ($cost_media !== null) {
    // file names
    $file_name = $cost_media['name'];
    // file tmp name
    $file_tmp_name = $cost_media['tmp_name'];
    // file types
    $file_types = $cost_media['type'];
    // file error
    $file_error = $cost_media['error'];
    // file size
    $file_size = $cost_media['size'];

    // check file size
    if ($file_size > 0 && $file_error == 0 && $file_size <= $mal_obj->max_file_size) {
      if (!file_exists($media_path) && !is_dir($media_path)) {
        mkdir($media_path);
      }

      $media_path .= base64_decode($_SESSION['sys']['company_id']) . "/";

      if (!file_exists($media_path) && !is_dir($media_path)) {
        mkdir($media_path);
      }

      // media temp
      $media_temp = [];

      // check if not empty
      if (!empty($file_name) && $file_error == 0) {
        // check if malfunctions has a receipt 
        if ($cost_receipt_name != null) {
          unlink($media_path . $cost_receipt_name);
        }
        // process new receipt
        $media_temp = explode('.', $file_name);
        $media_temp[0] = 'receipt_' . date('dmY') . '_' . $mal_id . '_' . rand(00000000, 99999999);
        $media_name = join('.', $media_temp);
        move_uploaded_file($file_tmp_name, $media_path . $media_name);
        $cost_receipt_name = $media_name;
      }

      $updates[] = 'add receipt';
    } else {
      $updates[] = 'media out range';
    }
  }

  // get updated status
  $is_updated = $mal_obj->update_malfunction_tech(array($mal_status, $cost, $cost_receipt_name, get_date_now(), get_time_now(), $tech_comment, $tech_comment_status, $tech_status, $mal_id));
  // updates details
  $updates[] = 'update malfunction';
  // return status
  return [
    'status' => $is_updated,
    'updates' => $updates
  ];
}

/**
 * upload_malfunction_media function
 * used to upload media to database
 */
function upload_malfunction_media($media_files, $mal_id, $path)
{
  if (!isset($mal_obj)) {
    // create an object of Malfunction class
    $mal_obj = new Malfunction();
  }
  // files names
  $files_names = $media_files['mal-media']['name'];
  // files tmp name
  $files_tmp_name = $media_files['mal-media']['tmp_name'];
  // files types
  $files_types = $media_files['mal-media']['type'];
  // files error
  $files_error = $media_files['mal-media']['error'];
  // files size
  $files_size = $media_files['mal-media']['size'];

  if (!file_exists($path)) {
    mkdir($path);
  }

  $path .= base64_decode($_SESSION['sys']['company_id']) . "/";

  if (!file_exists($path)) {
    mkdir($path);
  }
  // loop on it
  for ($i = 0; $i < count($files_names); $i++) {
    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($files_names[$i]) && $files_error[$i] == 0) {
      $media_temp = explode('.', $files_names[$i]);
      $media_temp[0] = date('dmY') . '_' . $mal_id . '_' . rand(00000000, 99999999) . '_' . ($i + 1);
      $media_name = join('.', $media_temp);
      move_uploaded_file($files_tmp_name[$i], $path . $media_name);

      // // upload files info into database
      $mal_obj->upload_media($mal_id, $media_name, strpos($files_types[$i], 'image') !== false ? 'img' : 'video');
    }
  }
}


/**
 * do_after_sales_updates function
 * used to do only after_sales updates
 */
function do_after_sales_updates($info)
{
  // get malfunction id
  $mal_id = base64_decode($info['mal-id']);
  // get technical quality
  $tech_qty = isset($info['technical-qty']) ? base64_decode($info['technical-qty']) : 0;
  // get services quality
  $service_qty = isset($info['service-qty']) ? base64_decode($info['service-qty']) : 0;
  // get money review
  $money_review = isset($info['money-review']) ? base64_decode($info['money-review']) : 0;
  // get review comment
  $review_comment = isset($info['review-comment']) ? $info['review-comment'] : '';
  // check if will review
  if ($tech_qty != 0 && $service_qty != 0 && $money_review != 0) {
    // create an object of Malfunction class
    $mal_obj = new Malfunction();
    // get updated status
    $is_updated = $mal_obj->update_malfunction_review(array(get_date_now(), get_time_now(), $money_review, $service_qty, $tech_qty, $review_comment, $mal_id));
    $updates = 'update review';
  } else {
    $is_updated = null;
    $updates = null;
  }
  // return status
  return [
    'status' => $is_updated,
    'updates' => $updates
  ];
}

/**
 * add_updates_details function
 * used to store updates details like::
 * - malfunction id
 * - updated by
 * - updated at
 * - update
 * - company id
 */
function add_updates_details($mal_id, $updated_by, $updates, $company_id)
{
  // create an object of Malfunction
  $comb_obj = new Malfunction();
  // add an new detail record
  $comb_obj->add_malfunction_updates(array($mal_id, $updated_by, get_date_now('Y-m-d H:i:s'), $updates, $company_id));
}