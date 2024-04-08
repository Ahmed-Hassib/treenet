<?php

/**
 * Combination class
 */
class Combination extends Database
{
  // properties
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // get specific combination
  public function get_combinations($condition, $type = 2)
  {
    // select query
    $select_query = "SELECT *FROM `combinations` WHERE {$condition};";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute();
    $comb_count = $stmt->rowCount(); // count effected rows
    $comb_info = $comb_count == 1 ? $stmt->fetch() : $stmt->fetchAll();

    // return null result
    return $comb_count > 0 ? $comb_info : null;
  }

  // function to get all combinations of specific company
  public function get_all_combinations()
  {
    // $count = $stmt->rowCount() ;    // all count of data
    // // return
    // return $count > 0 ? [true, $companies_data] : [false, null];
  }

  // get combination media
  public function get_combination_media($comb_id)
  {
    // select query
    $select_query = "SELECT *FROM `combinations_media` WHERE `comb_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($comb_id));
    $comb_media = $stmt->fetchAll();
    $media_count = $stmt->rowCount(); // count effected rows
    // return result
    return $media_count > 0 ? $comb_media : null;
  }

  // function to insert a new combination
  public function insert_new_combination($comb_info)
  {
    // INSERT INTO combinations
    $insert_query = "INSERT INTO `combinations` (`client_name`, `phone`, `address`, `coordinates`, `created_at`, `isFinished`, `comment`, `UserID`, `addedBy`, `company_id`) VALUES (?, ?, ?, ?, now(), 0, ?, ?, ?, ?);";
    // insert user info in database
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($comb_info);
    $count = $stmt->rowCount(); // count effected rows
    // return
    return $count > 0 ? true : false;
  }

  // function to update combination by manager man
  public function update_compination_mng($comb_info)
  {
    // review query
    $review_query = "UPDATE `combinations` SET `client_name` = ?, `phone` = ?, `address` = ?, `coordinates` = ?, `comment` = ?, `UserID` = ? WHERE `comb_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($review_query);
    $stmt->execute($comb_info);
    $comb_count = $stmt->rowCount(); // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  // function to update combination by technical man
  public function update_combination_tech($comb_info)
  {
    // check combination status
    if ($comb_info[1] == true) {
      // review query
      $review_query = "UPDATE `combinations` SET `coordinates` = ?, `isFinished` = ?, `isAccepted` = ?, `finished_at` = now(), `cost` = ?, `cost_receipt` = ?, `tech_comment` = ? WHERE `comb_id` = ?";
    } else {
      $review_query = "UPDATE `combinations` SET `coordinates` = ?, `isFinished` = ?, `isAccepted` = ?, `cost` = ?, `cost_receipt` = ?, `tech_comment` = ? WHERE `comb_id` = ?";
    }
    // prepare the query
    $stmt = $this->con->prepare($review_query);
    $stmt->execute($comb_info);
    $comb_count = $stmt->rowCount(); // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  // function to update combination review
  public function update_combination_review($review_info)
  {
    // review query
    $review_query = "UPDATE `combinations` SET `isReviewed` = 1, `reviewed_at` = now(), `money_review` = ?, `qty_service` = ?, `qty_emp` = ?, `qty_comment` = ?  WHERE `comb_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($review_query);
    $stmt->execute($review_info);
    $comb_count = $stmt->rowCount(); // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  // function to reset combination info
  public function reset_combination_info($info)
  {
    // reset query
    $reset_query = "UPDATE `combinations` SET `client_name` = ?, `phone` = ?, `address` = ?, `coordinates` = ?, `comment` = ?, `UserID` = ?, `created_at` = now(), `isFinished` = 0, `cost` = 0, `finished_at` = NULL, `isShowed` = 0, `showed_at` = NULL, `isAccepted` = -1,  `isReviewed` = 0, `reviewed_at` = NULL, `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = NULL  WHERE `comb_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($reset_query);
    $stmt->execute($info);
    $comb_count = $stmt->rowCount(); // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  // function to soft delete combination 
  public function temp_delete($comb_id)
  {
    // reset query
    $reset_query = "UPDATE `combinations` SET `deleted_at` = now() WHERE `comb_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($reset_query);
    $stmt->execute(array($comb_id));
    $comb_count = $stmt->rowCount(); // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  // function to soft restore combination 
  public function restore_comb($comb_id)
  {
    // reset query
    $reset_query = "UPDATE `combinations` SET `deleted_at` = NULL WHERE `comb_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($reset_query);
    $stmt->execute(array($comb_id));
    $comb_count = $stmt->rowCount(); // count effected rows
    // return result
    return $comb_count > 0 ? true : false;
  }

  // function to delete combination
  public function delete($comb_id)
  {
    $update_query = "DELETE FROM `combinations` WHERE `comb_id` = ?;";
    $update_query .= "DELETE FROM `combinations_media` WHERE `comb_id` = ?;";
    // insert user info in database
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($comb_id, $comb_id));
    // get count
    $count = $stmt->rowCount(); // all count of data
    // return
    return $count > 0 ? true : false;
  }

  // function to upload combination media
  public function upload_media($comb_id, $media_name, $type)
  {
    // delete query
    $insert_query = "INSERT INTO `combinations_media` (`comb_id`, `media`, `type`) VALUES (?, ?, ?)";
    // prepare query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($comb_id, $media_name, $type));
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // function to delete combination media
  public function delete_media($media_id)
  {
    // delete query
    $delete_query = "DELETE FROM `combinations_media` WHERE `id` = ?";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($media_id));
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // function to get all combination updates details
  public function get_combination_updates($comb_id)
  {
    // select query
    $select_query = "SELECT *FROM `combinations_updates` WHERE `comb_id` = ?";
    // prepare query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($comb_id));
    $updates_info = $stmt->fetchAll();
    $updates_count = $stmt->rowCount();
    // return updates
    return $updates_count > 0 ? $updates_info : null;
  }

  // function to store combination updates info
  public function add_combination_updates($info)
  {
    // insert info query
    $insert_query = "INSERT INTO `combinations_updates`(`comb_id`, `updated_by`, `updated_at`, `updates`, `company_id`) VALUES (?, ?, now(), ?, ?)";
    // prepare query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $insert_count = $stmt->rowCount();
    // return status
    return $insert_count > 0 ? true : false;
  }

  /**
   * send_notification function
   * used to send a combination notification to technical man
   */
  function send_notification($admin_name, $tech = [], $client = [], $lang_file)
  {
    $ultramsg_token = "xgkn9ejfc8b9ti1a"; // Ultramsg.com token
    $instance_id = "instance46427"; // Ultramsg.com instance id
    $whatsapp_obj = new WhatsAppApi($ultramsg_token, $instance_id);
    // get current time
    $time_period = date('a');
    // get destination phone number
    $to = (!starts_with(trim($tech['phone'], " \n\r\t\v"), "+2") ? "+2" : "") . trim($tech['phone'], " \n\r\t\v");
    // check employee phone if valid whatsapp account
    $is_whatsapp_account = $whatsapp_obj->checkContact($to);

    if ($tech['is_activated_phone'] && key_exists('status', $is_whatsapp_account) && $is_whatsapp_account['status'] == 'valid') {
      // prepare message
      $msg = ($time_period == 'am' ? lang('GOOD MORNING') : lang('GOOD AFTERNOON')) . " " . $tech['username'] . "\n";
      $msg .= " " . lang('ASSIGNED', $lang_file) . " " . $admin_name;
      $msg .= " " . lang('ASSIGN COMBINATION TO YOU', $lang_file) . "\n";
      $msg .= "\t*" . lang('NAME', $lang_file) . ": " . $client['name'] . "\n";
      $msg .= "\t*" . lang('ADDR', $lang_file) . ": " . $client['addr'] . "\n";
      $msg .= "\t*" . lang('PHONE', $lang_file) . ": " . $client['phone'] . "\n";
      $msg .= "\t*" . lang('NOTE') . ": " . $client['notes'] . "\n";
      // send message
      $api = $whatsapp_obj->sendChatMessage($to, $msg);
    }
  }
}
