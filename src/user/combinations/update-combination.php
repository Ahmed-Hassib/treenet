<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check license
  if ($_SESSION['sys']['isLicenseExpired'] == 0) {
    // create an object of Combination
    $comb_obj = !isset($comb_obj) ? new Combination() : $comb_obj;
    // get update owner id
    $update_owner_id = base64_decode($_SESSION['sys']['UserID']);
    // get update owner type
    $update_owner_type = $_SESSION['sys']['is_tech'];
    // get update owner job_id
    $update_owner_job_id = base64_decode($_SESSION['sys']['job_title_id']);
    // get combination id
    $comb_id = isset($_POST['comb-id']) && !empty($_POST['comb-id']) ? base64_decode($_POST['comb-id']) : 0;
    // check if combination is exist or not
    if ($comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id)) {
      // get combination basics info
      $comb_info = $comb_obj->get_combinations("`comb_id` = {$comb_id} AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL");
      // check if exist again
      if (!is_null($comb_info)) {
        // get new malfunction info
        $manager_id = base64_decode($_POST['admin-id']);
        $tech_id = base64_decode($_POST['technical-id']);

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
            if ($comb_info['isFinished'] != 1) {
              $is_updated = do_manager_updates($_POST);
            } else {
              $is_updated = do_after_sales_updates($_POST);
            }

            // check status updates
            if ($is_updated['status']) {
              // add combination updates info
              add_updates_details($comb_id, $update_owner_id, $is_updated['updates'], base64_decode($_SESSION['sys']['company_id']));
            }
            break;
            /**
             * updates for:
             * [1] Technical Man
             */
          case 2:
            $path = $uploads . "combinations/";
            // check who is doing the updates
            if ($update_owner_id == $tech_id && $comb_info['isFinished'] != 1) {
              $is_updated = do_technical_updates($_POST, count($_FILES) && $_FILES['cost-receipt']['size'] != 0 ? $_FILES['cost-receipt'] : null, $path);
              // check status updates
              if ($is_updated['status']) {
                // get updates
                $updates = $is_updated['updates'];
                // loop on updates
                foreach ($updates as $key => $update) {
                  // add combination updates info
                  add_updates_details($comb_id, $update_owner_id, $update, base64_decode($_SESSION['sys']['company_id']));
                }
              }
            }
            // check if upload media
            if (count($_FILES) > 0 && key_exists('comb-media', $_FILES)) {
              upload_combination_media($_FILES, $comb_id, $path);
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
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }
  // return to the previous page
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

  // create an object of Combination
  $comb_obj = !isset($comb_obj) ? new Combination() : $comb_obj;
  // get combination id
  $comb_id = base64_decode($info['comb-id']);
  // get combination technical id
  $tech_id = base64_decode($info['technical-id']);
  // get client name
  $client_name = $info['client-name'];
  // get client phone
  $client_phone = $info['client-phone'];
  // get client address
  $client_address = $info['client-address'];
  // get combination description
  $comment = $_POST['client-notes'];
  // get combination coordinates
  $coordinates = $_POST['coordinates'];
  // get previous combination tecnical id
  $prev_tech_id = $comb_obj->select_specific_column("`UserID`", "`combinations`", "WHERE `comb_id` = $comb_id")['UserID'];
  // compare new tech with the old
  if ($tech_id == $prev_tech_id) {
    // update all compination info
    $is_updated = $comb_obj->update_compination_mng(array($client_name, $client_phone, $client_address, $coordinates, $comment, $tech_id, $comb_id));
    $updates = 'update combination';
  } else {
    // reset compination info
    $is_updated = $comb_obj->reset_combination_info(array($client_name, $client_phone, $client_address, $coordinates, $comment, $tech_id, $comb_id));
    $updates = 'reset combination';
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
  // create an object of Combination
  $comb_obj = new Combination();
  // get combination id
  $comb_id = base64_decode($info['comb-id']);
  // get combination status
  $is_finished = base64_decode($info['comb-status']);
  // get technical status
  $tech_status = base64_decode($info['comb-status']);
  // get technical man comment
  $tech_comment = isset($info['comment']) ? $info['comment'] : '';
  // get combination cost
  $cost = $_POST['cost'];
  // get combination coordinates
  $coordinates = $_POST['coordinates'];
  // check if combination has a receipt 
  $comb_info = $comb_obj->select_specific_column("`cost_receipt`", "`combinations`", "WHERE `comb_id` = $comb_id");
  $cost_receipt_name = !is_null($comb_info) ? $comb_info['cost_receipt'] : null;

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
    if ($file_size <= $comb_obj->max_file_size) {
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
        // check img name
        if ($cost_receipt_name != null) {
          unlink($media_path . $cost_receipt_name);
        }
        // process ne receipt
        $media_temp = explode('.', $file_name);
        $media_temp[0] = 'receipt_' . date('dmY') . '_' . $comb_id . '_' . rand(00000000, 99999999);
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
  $is_updated = $comb_obj->update_combination_tech(array($coordinates, $is_finished, $tech_status, $cost, $cost_receipt_name, $tech_comment, $comb_id));
  // updates detail
  $updates[] = 'update combination';
  // return status
  return [
    'status' => $is_updated,
    'updates' => $updates
  ];
}

/**
 * upload_combination_media function
 * used to upload media to database
 */
function upload_combination_media($media_files, $comb_id, $path)
{
  // create an object of Combination class
  $comb_obj = new Combination();
  // files names
  $files_names = $media_files['comb-media']['name'];
  // files tmp name
  $files_tmp_name = $media_files['comb-media']['tmp_name'];
  // files types
  $files_types = $media_files['comb-media']['type'];
  // files error
  $files_error = $media_files['comb-media']['error'];
  // files size
  $files_size = $media_files['comb-media']['size'];

  if (!file_exists($path) && !is_dir($path)) {
    mkdir($path);
  }

  $path .= base64_decode($_SESSION['sys']['company_id']) . "/";

  if (!file_exists($path) && !is_dir($path)) {
    mkdir($path);
  }

  // loop on it
  for ($i = 0; $i < count($files_names); $i++) {
    // media temp
    $media_temp = [];
    // check if not empty
    if (!empty($files_names[$i]) && $files_error[$i] == 0) {
      $media_temp = explode('.', $files_names[$i]);
      $media_temp[0] = date('dmY') . '_' . $comb_id . '_' . rand(00000000, 99999999) . '_' . ($i + 1);
      $media_name = join('.', $media_temp);
      move_uploaded_file($files_tmp_name[$i], $path . $media_name);

      // upload files info into database
      $comb_obj->upload_media($comb_id, $media_name, strpos($files_types[$i], 'image') !== false ? 'img' : 'video');
    }
  }
}



/**
 * do_after_sales_updates function
 * used to do only after_sales updates
 */
function do_after_sales_updates($info)
{
  // get combination id
  $comb_id = base64_decode($info['comb-id']);
  // get technical quality
  $tech_qty = isset($info['technical-qty']) ? base64_decode($info['technical-qty']) : 0;
  // get services quality
  $service_qty = isset($info['service-qty']) ? base64_decode($info['service-qty']) : 0;
  // get money review
  $money_review = isset($info['money-review']) ? base64_decode($info['money-review']) : 0;
  // get review comment
  $review_comment = isset($info['review-comment']) ? $info['review-comment'] : '';
  // check if will review
  if ($tech_qty != 0 && $service_qty != 0 && $money_review != 0 && !empty($review_comment)) {
    // create an object of Combination
    $comb_obj = new Combination();
    // get updated status
    $is_updated = $comb_obj->update_combination_review(array($money_review, $service_qty, $tech_qty, $review_comment, $comb_id));
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
 * - combination id
 * - updated by
 * - updated at
 * - update
 * - company id
 */
function add_updates_details($comb_id, $updated_by, $updates, $company_id)
{
  // create an object of Combination
  $comb_obj = new Combination();
  // add an new detail record
  $comb_obj->add_combination_updates(array($comb_id, $updated_by, $updates, $company_id));
}
