<?php

/**
 * Pieces class
 */
class Pieces extends Database
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

  /**
   * 
   */
  // public function get_all_pieces($company_id, $type)
  // {
  //   // query statement
  //   $all_pieces_query = "SELECT 
  //       `pieces_info`.*, 
  //       `pieces_ssid`.`ssid`,
  //       `pieces_waves`.`wave`,
  //       `pieces_phones`.`phone`,
  //       `pieces_addr`.`address`, 
  //       `pieces_mac_addr`.`mac_add`,
  //       `pieces_frequency`.`frequency`,
  //       `pieces_pass_connection`.`password_connection`,
  //       `pieces_Coordinates`.`coordinates`
  //   FROM 
  //       `pieces_info`
  //   LEFT JOIN `pieces_ssid` ON `pieces_ssid`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_waves` ON `pieces_waves`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_phones` ON `pieces_phones`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_addr` ON `pieces_addr`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_mac_addr` ON `pieces_mac_addr`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_frequency` ON `pieces_frequency`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_pass_connection` ON `pieces_pass_connection`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_Coordinates` ON `pieces_Coordinates`.`id` = `pieces_info`.`id`
  //   WHERE `pieces_info`.`company_id` = ? AND `pieces_info`.`is_client` = ?
  //   ORDER BY 
  //       `pieces_info`.`direction_id` ASC, 
  //       `pieces_info`.`device_type` ASC";

  //   // prepare the query
  //   $stmt = $this->con->prepare($all_pieces_query);
  //   $stmt->execute(array($company_id, $type)); // execute query
  //   $pieces_data = $stmt->fetchAll(); // fetch data
  //   $pieces_counter = $stmt->rowCount();       // count effected rows

  //   // check counter 

  //   // return result
  //   return $pieces_counter > 0 ? [true, $pieces_data] : [false, null];
  // }

  // // get specific piece
  // public function get_spec_piece($id)
  // {
  //   // get user info from database
  //   $select_query = "SELECT 
  //       `pieces_info`.*, 
  //       `pieces_ssid`.`ssid`,
  //       `pieces_waves`.`wave`,
  //       `pieces_phones`.`phone`,
  //       `pieces_addr`.`address`, 
  //       `pieces_mac_addr`.`mac_add`,
  //       `pieces_frequency`.`frequency`,
  //       `pieces_pass_connection`.`password_connection`,
  //       `pieces_Coordinates`.`coordinates`
  //   FROM 
  //       `pieces_info`
  //   LEFT JOIN `pieces_ssid` ON `pieces_ssid`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_waves` ON `pieces_waves`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_phones` ON `pieces_phones`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_addr` ON `pieces_addr`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_mac_addr` ON `pieces_mac_addr`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_frequency` ON `pieces_frequency`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_pass_connection` ON `pieces_pass_connection`.`id` = `pieces_info`.`id` 
  //   LEFT JOIN `pieces_Coordinates` ON `pieces_Coordinates`.`id` = `pieces_info`.`id` 
  //   WHERE `pieces_info`.`id` = ?
  //   ORDER BY 
  //       `pieces_info`.`direction_id` ASC, 
  //       `pieces_info`.`device_type` ASC";

  //   // prepare the query
  //   $stmt = $this->con->prepare($select_query);
  //   $stmt->execute(array($id)); // execute query
  //   $row = $stmt->fetch(); // fetch data
  //   $pcs_count = $stmt->rowCount();       // count effected rows
  //   // return result
  //   return $pcs_count > 0 ? [true, $row] : [false, null];
  // }

  public function get_pieces($condition, $type = 2)
  {
    // query statement
    $query = "SELECT 
        `pieces_info`.*, 
        `pieces_ssid`.`ssid`,
        `pieces_waves`.`wave`,
        `pieces_phones`.`phone`,
        `pieces_addr`.`address`, 
        `pieces_mac_addr`.`mac_add`,
        `pieces_frequency`.`frequency`,
        `pieces_pass_connection`.`password_connection`,
        `pieces_Coordinates`.`coordinates`
    FROM 
        `pieces_info`
    LEFT JOIN `pieces_ssid` ON `pieces_ssid`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_waves` ON `pieces_waves`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_phones` ON `pieces_phones`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_addr` ON `pieces_addr`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_mac_addr` ON `pieces_mac_addr`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_frequency` ON `pieces_frequency`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_pass_connection` ON `pieces_pass_connection`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_Coordinates` ON `pieces_Coordinates`.`id` = `pieces_info`.`id` 
    $condition
    ORDER BY 
        `pieces_info`.`direction_id` ASC, 
        `pieces_info`.`device_type` ASC";

    // prepare the query
    $stmt = $this->con->prepare($query);
    $stmt->execute(); // execute query
    $pieces_data = $stmt->fetchAll(); // fetch data
    $pieces_counter = $stmt->rowCount();       // count effected rows

    // check counter
    if ($type > 1) {
      // empty array for final result
      $res = [];
      // loop on data to prepare it
      foreach ($pieces_data as $key => $piece) {
        $res[] = $this->prepare_data($piece);
      }
      // return final result
      return $res;
    } elseif ($type == 1) {
      return $this->prepare_data($pieces_data[0]);
    }
    // return null result
    return null;
  }

  // insert a new Piece
  public function insert_new_piece($info)
  {
    $insert_query = "INSERT INTO `pieces_info` (`full_name`, `ip`, `port`, `username`, `password`, `connection_type`, `direction_id`, `source_id`, `alt_source_id`, `is_client`, `device_type`, `device_id`, `device_model`, `added_by`, `created_at`, `company_id`, `notes`, `visit_time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?, ?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update Piece info
  public function update_piece_info($info)
  {
    $update_query = "UPDATE `pieces_info` SET `full_name` = ?, `ip` = ?, `port` = ?, `username` = ?, `password` = ?, `connection_type` = ?, `direction_id` = ?, `source_id` = ?, `alt_source_id` = ?, `is_client` = ?, `device_type` = ?, `device_id` = ?, `device_model` = ?, `notes` = ?, `visit_time` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new Address
  public function insert_address($id, $address)
  {
    // insert address
    $insert_query = "INSERT INTO `pieces_addr` (`id`, `address`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $address));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update Address
  public function update_address($id, $address)
  {
    // update address
    $update_query = "UPDATE `pieces_addr` SET `address` = ? WHERE `id` = ?;";
    // update user info in database
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($address, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new frequency
  public function insert_frequency($id, $frequency)
  {
    $insert_query = "INSERT INTO `pieces_frequency` (`id`, `frequency`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $frequency));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update frequency
  public function update_frequency($id, $frequency)
  {
    $update_query = "UPDATE `pieces_frequency` SET `frequency` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($frequency, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new mac address
  public function insert_mac_add($id, $mac_add)
  {
    $insert_query = "INSERT INTO `pieces_mac_addr` (`id`, `mac_add`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $mac_add));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update mac address
  public function update_mac_add($id, $mac_add)
  {
    $update_query = "UPDATE `pieces_mac_addr` SET `mac_add` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($mac_add, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new pass_connection
  public function insert_pass_connection($id, $pass_connection)
  {
    $insert_query = "INSERT INTO `pieces_pass_connection` (`id`, `password_connection`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $pass_connection));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update pass_connection
  public function update_pass_connection($id, $pass_connection)
  {
    $update_query = "UPDATE `pieces_pass_connection` SET `password_connection` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($pass_connection, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new phones
  public function insert_phones($id, $phone)
  {
    $insert_query = "INSERT INTO `pieces_phones` (`id`, `phone`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $phone));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update phones
  public function update_phones($id, $phone)
  {
    $update_query = "UPDATE `pieces_phones` SET `phone` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($phone, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new ssid
  public function insert_ssid($id, $ssid)
  {
    $insert_query = "INSERT INTO `pieces_ssid` (`id`, `ssid`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $ssid));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update ssid
  public function update_ssid($id, $ssid)
  {
    $update_query = "UPDATE `pieces_ssid` SET `ssid` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($ssid, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new waves
  public function insert_wave($id, $wave)
  {
    $insert_query = "INSERT INTO `pieces_waves` (`id`, `wave`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $wave));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update waves
  public function update_wave($id, $wave)
  {
    $update_query = "UPDATE `pieces_waves` SET `wave` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($wave, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // insert a new internet source
  public function insert_coordinates($id, $coordinates)
  {
    $insert_query = "INSERT INTO `pieces_Coordinates` (`id`, `coordinates`) VALUES (?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $coordinates));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update internet source
  public function update_coordinates($id, $coordinates)
  {
    $update_query = "UPDATE `pieces_Coordinates` SET `coordinates` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($coordinates, $id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  /**
   * update_children_direction function v 1
   */
  function update_children_direction($source_id, $new_direction_id)
  {
    // final query
    $update_query = "";
    // check piece if exist or not
    $is_exist_piece = $this->is_exist("`id`", "`pieces_info`", $source_id);
    // if exist
    if ($is_exist_piece == true) {
      // count children of the current piece
      $children_count = $this->count_records("`id`", "`pieces_info`", "WHERE `source_id` = {$source_id}");
      // check if has children
      if ($children_count > 0) {
        $update_query .= "UPDATE `pieces_info` SET `direction_id` = '{$new_direction_id}' WHERE `id` = {$source_id};";
        // fetch all children
        $children = $this->select_specific_column("`id`", "`pieces_info`", "WHERE `source_id` = {$source_id}");
        // loop on it
        foreach ($children as $child) {
          // get the children of the current piece
          $update_query .= $this->update_children_direction($child['id'], $new_direction_id);
        }
      } else {
        $update_query .= "UPDATE `pieces_info` SET `direction_id` = '{$new_direction_id}' WHERE `id` = {$source_id};";
      }
      // 
      $stmt = $this->con->prepare($update_query);
      $stmt->execute();
      $pcs_count = $stmt->rowCount();       // count effected rows
      // return result
      return $pcs_count > 0 ? true : false;
    }
  }

  /**
   * update_children_direction_source function v 1
   */
  function update_children_direction_source($old_source_id, $new_source_id, $old_direction_id, $new_direction_id)
  {
    // final query
    $update_query = "UPDATE `pieces_info` SET `direction_id` = '{$new_direction_id}' WHERE `direction_id` = '{$old_direction_id}';";
    // count children of the current piece
    $children_count = $this->count_records("`id`", "`pieces_info`", "WHERE `source_id` = {$old_source_id}");
    // check if has children
    if ($children_count > 0) {
      $update_query .= "UPDATE `pieces_info` SET `source_id` = '{$new_source_id}' WHERE `id` = {$old_source_id};";
    }
    $stmt = $this->con->prepare($update_query);
    $stmt->execute();
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // search for employee
  public function search($search_stmt, $company_id, $type)
  {
    // activate phone query
    $search_query = "SELECT 
        `pieces_info`.*, 
        `pieces_ssid`.`ssid`,
        `pieces_waves`.`wave`,
        `pieces_phones`.`phone`,
        `pieces_addr`.`address`, 
        `pieces_mac_addr`.`mac_add`,
        `pieces_frequency`.`frequency`,
        `pieces_pass_connection`.`password_connection`,
        `pieces_Coordinates`.`coordinates`
    FROM 
        `pieces_info`
    LEFT JOIN `pieces_ssid` ON `pieces_ssid`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_waves` ON `pieces_waves`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_phones` ON `pieces_phones`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_addr` ON `pieces_addr`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_mac_addr` ON `pieces_mac_addr`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_frequency` ON `pieces_frequency`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_pass_connection` ON `pieces_pass_connection`.`id` = `pieces_info`.`id` 
    LEFT JOIN `pieces_Coordinates` ON `pieces_Coordinates`.`id` = `pieces_info`.`id`
    WHERE 
    (`pieces_info`.`full_name` LIKE '%{$search_stmt}%' OR `pieces_info`.`ip` LIKE '%{$search_stmt}%' OR `pieces_info`.`port` LIKE '%{$search_stmt}%' OR `pieces_mac_addr`.`mac_add` LIKE '%{$search_stmt}%' OR `pieces_phones`.`phone` LIKE '%{$search_stmt}%')
    AND `pieces_info`.`company_id` = ? AND `pieces_info`.`is_client` = ?
    ORDER BY 
        `pieces_info`.`direction_id` ASC, 
        `pieces_info`.`device_type` ASC";

    // prepare statement
    $stmt = $this->con->prepare($search_query);
    $stmt->execute(array($company_id, $type));
    $count = $stmt->rowCount(); // get number of effected rows
    $serach_res = $stmt->fetchAll(); // all count of data

    // empty response
    $response = [];
    // loop on data
    foreach ($serach_res as $key => $search) {
      $res[] = $this->prepare_data($search);
    }

    // return
    return $count > 0 ?  $response : null;
  }

  // soft delete piece
  public function temp_delete($id)
  {
    $update_query = "UPDATE `pieces_info` SET `deleted_at` = now() WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // hard delete piece
  public function delete($id)
  {
    if (!empty($id) && filter_var($id, FILTER_VALIDATE_INT)) {
      // delete query
      $delete_query = "DELETE FROM `pieces_addr` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_frequency`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_info` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_mac_addr`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_pass_connection`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_phones`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_ssid` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_waves`WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_Coordinates`WHERE `id`= ?;";
      // prepare query
      $stmt = $this->con->prepare($delete_query);
      $stmt->execute(array($id, $id, $id, $id, $id, $id, $id, $id, $id));
      $pcs_count = $stmt->rowCount();       // count effected rows
      // return result
      return $pcs_count > 0 ? true : false;
    }
    return false;
  }

  // soft restore piece
  public function restore($id)
  {
    $update_query = "UPDATE `pieces_info` SET `deleted_at` = NULL WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($id));
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  public function prepare_data($data)
  {
    // extract
    extract($data);
    // prepare response
    return [
      'id' => $id,
      'fullname' => $full_name,
      'ip' => $ip,
      'port' => $port,
      'username' => $username,
      'password' => $password,
      'connection_type' => $connection_type,
      'direction_id' => $direction_id,
      'source_id' => $source_id,
      'alt_source_id' => $alt_source_id,
      'is_client' => $is_client,
      'device_type' => $device_type,
      'device_id' => $device_id,
      'device_model' => $device_model,
      'added_by' => $added_by,
      'created_at' => $created_at,
      'notes' => $notes,
      'visit_time' => $visit_time,
      'updated_at' => $updated_at,
      'deleted_at' => $deleted_at,
      'ssid' => $ssid,
      'wave' => $wave,
      'phone' => $phone,
      'address' => $address,
      'mac_add' => $mac_add,
      'frequency' => $frequency,
      'password_connection' => $password_connection,
      'coordinates' => $coordinates,
    ];
  }
}
