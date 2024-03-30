<?php

/**
 * Malfunction class
 */
class Malfunction extends Database
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

  // get specific malfunction
  public function get_malfunctions($condition, $type = 2)
  {
    // select query
    $select_query = "SELECT *FROM `malfunctions` WHERE {$condition};";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute();
    $mal_info = $stmt->fetchAll();
    $mal_count = $stmt->rowCount(); // count effected rows

    if ($mal_count > 0) {
      // check malfunction counter
      if ($type == 1) {
        return $this->prepare_data($mal_info[0]);
      } elseif ($type > 1) {
        // an empty array for final result
        $res = [];
        // loop on data to prepare it
        foreach ($mal_info as $key => $mal) {
          $res[] = $this->prepare_data($mal);
        }
        // return final result
        return $res;
      }
    }
    // return result
    return null;
  }

  // get all Malfunctions
  public function get_all_malfunctions($company_id)
  {
  }

  // get malfunction media
  public function get_malfunction_media($mal_id)
  {
    // select query
    $select_query = "SELECT *FROM `malfunctions_media` WHERE `mal_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($mal_id));
    $mal_media = $stmt->fetchAll();
    $media_count = $stmt->rowCount(); // count effected rows
    // return result
    return $media_count > 0 ? $mal_media : null;
  }

  // insert a new Malfunction
  public function insert_new_malfunction($info)
  {
    // INSERT INTO malfunctions
    $insert_query = "INSERT INTO `malfunctions` (`mng_id`, `tech_id`, `client_id`, `descreption`, `created_at`, `company_id`) VALUES (?, ?, ?, ?, now(), ?);";
    // prepare the query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // update Malfunction info
  public function update_malfunction_tech($info)
  {
    // check malfunction status to update it
    if ($info[0] == 1) {
      $update_query = "UPDATE `malfunctions` SET `mal_status` = ?, `cost` = ?, `cost_receipt` = ?, `repaired_at` = now(), `tech_comment` = ?, `tech_status_comment` = ?, `isAccepted`= ? WHERE `mal_id` = ?";
    } else {
      $update_query = "UPDATE `malfunctions` SET `mal_status` = ?, `cost` = ?, `cost_receipt` = ?, `tech_comment` = ?, `tech_status_comment` = ?, `isAccepted`= ? WHERE `mal_id` = ?";
    }
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // update Malfunction info
  public function update_malfunction_mng($info)
  {
    $update_query = "UPDATE `malfunctions` SET `descreption`= ? WHERE `mal_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // update Malfunction info
  public function update_malfunction_review($info)
  {
    $update_query = "UPDATE `malfunctions` SET `isReviewed` = 1, `reviewed_at` = ?, `money_review` = ?, `qty_service` = ?, `qty_emp` = ?, `qty_comment` = ? WHERE `mal_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // update Malfunction info
  public function reset_malfunction_info($info)
  {
    $update_query = "UPDATE `malfunctions` SET `tech_id` = ?, `descreption` = ?, `created_at` = now(), `mal_status` =  0,`cost` =  0, `repaired_at` = NULL, `tech_comment` = NULL, `isShowed` = 0, `showed_at` = NULL, `isAccepted` = -1, `isReviewed` = 0, `reviewed_at` = NULL, `money_review` = 0, `qty_service` = 0, `qty_emp` = 0, `qty_comment` = NULL, `deleted_at` = NULL WHERE `mal_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // soft delete Malfunction info
  public function temp_delete($id)
  {
    // delete query
    $delete_query = "UPDATE `malfunctions` SET `deleted_at` = now() WHERE `mal_id` = ?;";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }
  
  // soft restore Malfunction info
  public function restore_malfunction($id)
  {
    // delete query
    $delete_query = "UPDATE `malfunctions` SET `deleted_at` = NULL WHERE `mal_id` = ?;";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id));
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }
  
  // delete Malfunction info
  public function delete_malfunction($id)
  {
    // delete query
    $delete_query = "DELETE FROM `malfunctions` WHERE `mal_id` = ?;";
    $delete_query .= "DELETE FROM `malfunctions_media` WHERE `mal_id` = ?;";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($id, $id));
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  public function upload_media($mal_id, $media_name, $type)
  {
    // delete query
    $insert_query = "INSERT INTO `malfunctions_media`(`mal_id`, `media`, `type`) VALUES (?, ?, ?)";
    // prepare query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($mal_id, $media_name, $type));
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  public function delete_media($media_id)
  {
    // delete query
    $delete_query = "DELETE FROM `malfunctions_media` WHERE `id` = ?";
    // prepare query
    $stmt = $this->con->prepare($delete_query);
    $stmt->execute(array($media_id));
    $mal_count = $stmt->rowCount(); // count effected rows
    // return result
    return $mal_count > 0 ? true : false;
  }

  // function to get all malfunction updates details
  public function get_malfunction_updates($mal_id)
  {
    // select query
    $select_query = "SELECT *FROM `malfunctions_updates` WHERE `mal_id` = ?";
    // prepare query
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($mal_id));
    $updates_info = $stmt->fetchAll();
    $updates_count = $stmt->rowCount();
    // return updates
    return $updates_count > 0 ? $updates_info : null;
  }

  // function to store malfunction updates info
  public function add_malfunction_updates($info)
  {
    // insert info query
    $insert_query = "INSERT INTO `malfunctions_updates`(`mal_id`, `updated_by`, `updated_at`, `updates`, `company_id`) VALUES (?, ?, now(), ?, ?)";
    // prepare query
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $insert_count = $stmt->rowCount();
    // return status
    return $insert_count > 0 ? true : false;
  }

  // prepare malfunction data
  public function prepare_data($data)
  {
    extract($data);
    return [
      'mal_id' => $mal_id, 
      'mng_id' => $mng_id, 
      'tech_id' => $tech_id, 
      'client_id' => $client_id, 
      'descreption' => $descreption, 
      'created_at' => $created_at, 
      'mal_status' => $mal_status, 
      'cost' => $cost, 
      'cost_receipt' => $cost_receipt, 
      'tech_comment' => $tech_comment, 
      'tech_status_comment' => $tech_status_comment, 
      'isShowed' => $isShowed, 
      'showed_at' => $showed_at, 
      'isAccepted' => $isAccepted, 
      'repaired_at' => $repaired_at, 
      'isReviewed' => $isReviewed, 
      'reviewed_at' => $reviewed_at, 
      'money_review' => $money_review, 
      'qty_service' => $qty_service, 
      'qty_emp' => $qty_emp, 
      'qty_comment' => $qty_comment, 
      'company_id' => $company_id, 
      'deleted_at' => $deleted_at, 
    ];
  }

  /**
   * send_notification function
   * used to send a combination notification to technical man
   */
  function send_notification($admin_name, $tech = [], $client = [], $descreption, $lang_file)
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
      // send separate message
      $mal_info = $whatsapp_obj->sendChatMessage($to, str_repeat("=", 30));
      // prepare message
      $msg = ($time_period == 'am' ? lang('GOOD MORNING') : lang('GOOD AFTERNOON')) . " " . $tech['username'] . "\n";
      $msg .= " " . lang('ASSIGNED', $lang_file) . " " . $admin_name;
      $msg .= " " . lang('ASSIGN MALFUNCTION TO YOU', $lang_file) . "\n";
      $msg .= "\t*" . lang('NAME', $lang_file) . ": " . $client['fullname'] . "\n";
      $msg .= "\t*" . lang('ADDR', $lang_file) . ": " . $client['address'] . "\n";
      $msg .= "\t*" . lang('PHONE', $lang_file) . ": " . $client['phone'] . "\n";
      $msg .= "\t*" . lang('MAL DESC', $lang_file) . ": " . $descreption . "\n";
      // send message
      $mal_info = $whatsapp_obj->sendChatMessage($to, $msg);

      $location_info = null;
      // get location info
      $location = !empty($client['coordinates']) ? explode(",", $client['coordinates']) : null;
      // check location status
      if ($location != null && count($location) == 2) {
        // get latitude 
        $latitude = $location[0];
        // get longitude 
        $longitude = $location[0];
        // send location
        $location_info = $whatsapp_obj->sendLocationMessage($to, $client['address'], $latitude, $longitude);
      }
      // send separate message
      $mal_info = $whatsapp_obj->sendChatMessage($to, str_repeat("=", 30));
      // return result
      return [
        'mal_info' => $mal_info,
        'location_info' => $location_info
      ];
    }
    // return null
    return [
      'mal_info' => null,
      'location_info' => null
    ];
  }
}
