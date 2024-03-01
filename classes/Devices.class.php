<?php

/**
 * Devices class
 */
class Devices extends Database
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

  // get all info about specific device
  public function get_device_info($device_id)
  {
    // get all info about given devices id
    $dev_query = "SELECT *FROM `devices_info` WHERE `device_id` = ? LIMIT 1";
    $stmt = $this->con->prepare($dev_query);
    $stmt->execute(array($device_id));
    $dev_count = $stmt->rowCount();
    $dev_row =  $stmt->fetch();
    // return result
    return $dev_count > 0 ? [$dev_count, $dev_row] : [0, null];
  }

  // get all devices info
  public function get_all_devices($company_id)
  {
    // get all devices info
    $dev_query = "SELECT 
        `devices_info`.*, 
        `manufacture_companies`.`company_id` 
    FROM 
        `devices_info` 
        LEFT JOIN `manufacture_companies` ON `manufacture_companies`.`man_company_id` = `devices_info`.`device_company_id` 
        WHERE `manufacture_companies`.`company_id` = ?;";
    $stmt = $this->con->prepare($dev_query);
    $stmt->execute(array($company_id));
    $dev_count = $stmt->rowCount();
    $dev_rows =  $stmt->fetchAll();
    // return result
    return $dev_count > 0 ? [$dev_count, $dev_rows] : [0, null];
  }

  // get all models
  public function get_all_device_models($device_id)
  {
    // get all pieces devices_model
    $model_query = "SELECT *FROM `devices_model` WHERE `device_id` = ?";
    $stmt = $this->con->prepare($model_query);
    $stmt->execute(array($device_id));
    $model_count = $stmt->rowCount();
    $models_row =  $stmt->fetchAll();
    // return result
    return $model_count > 0 ? [$model_count, $models_row] : [0, null];
  }

  // get all devices info
  public function get_all_company_devices($company_id)
  {
    // get all devices info
    $dev_query = "SELECT *FROM `devices_info` WHERE `device_company_id` = ?";
    $stmt = $this->con->prepare($dev_query);
    $stmt->execute(array($company_id));
    $dev_count = $stmt->rowCount();
    $dev_rows =  $stmt->fetchAll();
    // return result
    return $dev_count > 0 ? [$dev_count, $dev_rows] : [0, null];
  }

  // insert a new device
  public function insert_new_devices($info)
  {
    // insert query
    $dev_insert_query = "INSERT INTO `devices_info` (`device_name`, `added_date`, `added_by`, `device_company_id`) VALUES (?, ?, ?, ?);";
    $stmt = $this->con->prepare($dev_insert_query);
    $stmt->execute($info);
    $dev_comp_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $dev_comp_count > 0 ? true : false;
  }

  // update device
  public function update_device_info($device_name, $man_company_id, $device_id)
  {
    // update query
    $dev_update_query = "UPDATE `devices_info` SET `device_name` = ?, `device_company_id` = ? WHERE `device_id` = ?";
    $stmt = $this->con->prepare($dev_update_query);
    $stmt->execute(array($device_name, $man_company_id, $device_id));
    $dev_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $dev_count > 0 ? true : false;
  }

  // delete device
  public function delete_device($device_id)
  {
    // // delete query
    // $dev_delete_query = "DELETE FROM `devices_info` WHERE `device_id` = ?";
    // $stmt = $this->con->prepare($dev_delete_query);
    // $stmt->execute(array($device_id));
    // $dev_count =  $stmt->rowCount();       // count effected rows
    // // return result
    // return $dev_count > 0 ? true : false;
    return false;
  }

  // delete specific model
  public function delete_device_models($device_id)
  {
    // // delete query
    // $model_delete_query = "DELETE FROM `devices_model` WHERE `device_id` = ?";
    // $stmt = $this->con->prepare($model_delete_query);
    // $stmt->execute(array($device_id));
    // $model_count =  $stmt->rowCount();       // count effected rows
    // // return result
    // return $model_count > 0 ? true : false;
    return false;
  }
}
