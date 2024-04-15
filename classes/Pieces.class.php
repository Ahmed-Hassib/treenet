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

  public function get_pieces($condition, $type = 2)
  {
    // query statement
    $query = "SELECT 
        `pieces_info`.*, 
        `pieces_phones`.`phone`
    FROM 
        `pieces_info`
    LEFT JOIN `pieces_phones` ON `pieces_phones`.`id` = `pieces_info`.`id` 
    $condition
    ORDER BY 
        `pieces_info`.`direction_id` ASC, 
        `pieces_info`.`device_type` ASC";

    // prepare the query
    $stmt = $this->con->prepare($query);
    $stmt->execute(); // execute query
    $pieces_counter = $stmt->rowCount();       // count effected rows
    $pieces_data = $type == 1 ? $stmt->fetch() : $stmt->fetchAll(); // fetch data

    // return null result
    return $pieces_counter > 0 ? $pieces_data : null;
  }

  // insert a new Piece
  public function insert_new_piece($info)
  {
    $insert_query = "INSERT INTO `pieces_info` (`full_name`, `ip`, `port`, `username`, `password`, `connection_type`, `direction_id`, `source_id`, `alt_source_id`, `is_client`, `device_type`, `device_id`, `device_model`, `address`, `coordinates`, `frequency`, `mac_add`, `password_connection`, `ssid`, `wave`, `added_by`, `created_at`, `company_id`, `notes`, `visit_time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?, ?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $pcs_count = $stmt->rowCount();       // count effected rows
    // return result
    return $pcs_count > 0 ? true : false;
  }

  // update Piece info
  public function update_piece_info($info)
  {
    $update_query = "UPDATE `pieces_info` SET `full_name` = ?, `ip` = ?, `port` = ?, `username` = ?, `password` = ?, `connection_type` = ?, `direction_id` = ?, `source_id` = ?, `alt_source_id` = ?, `is_client` = ?, `device_type` = ?, `device_id` = ?, `device_model` = ?, `address` = ?, `coordinates` = ?, `frequency` = ?, `mac_add` = ?, `password_connection` = ?, `ssid` = ?, `wave` = ?, `notes` = ?, `visit_time` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
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

  // update coordinates
  public function update_coordinates($id, $coordinates)
  {
    $update_query = "UPDATE `pieces_info` SET `coordinates` = ? WHERE `id` = ?;";
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
        $children = $this->select_specific_column("`id`", "`pieces_info`", "WHERE `source_id` = {$source_id}", 'multiple');
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
        `pieces_phones`.`phone`,
    FROM 
        `pieces_info`
    LEFT JOIN `pieces_phones` ON `pieces_phones`.`id` = `pieces_info`.`id` 
    WHERE 
    (`pieces_info`.`full_name` LIKE '%{$search_stmt}%' OR `pieces_info`.`ip` LIKE '%{$search_stmt}%' OR `pieces_info`.`port` LIKE '%{$search_stmt}%' OR `pieces_info`.`mac_add` LIKE '%{$search_stmt}%' OR `pieces_info`.`phone` LIKE '%{$search_stmt}%')
    AND `pieces_info`.`company_id` = ? AND `pieces_info`.`is_client` = ?
    ORDER BY 
        `pieces_info`.`direction_id` ASC, 
        `pieces_info`.`device_type` ASC";

    // prepare statement
    $stmt = $this->con->prepare($search_query);
    $stmt->execute(array($company_id, $type));
    $count = $stmt->rowCount(); // get number of effected rows
    $serach_res = $stmt->fetchAll(); // all count of data
    // return
    return $count > 0 ?  $serach_res : null;
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
      $delete_query = "DELETE FROM `pieces_info` WHERE `id`= ?;";
      $delete_query .= "DELETE FROM `pieces_phones`WHERE `id`= ?;";
      // prepare query
      $stmt = $this->con->prepare($delete_query);
      $stmt->execute(array($id, $id));
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
}
