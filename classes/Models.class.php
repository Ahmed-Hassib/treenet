<?php
/**
 * Models class
 */
class Models extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
        $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }
  
  // get all models
  public function get_all_models($device_id) {
    // get all pieces devices_model
    $model_query = "SELECT *FROM `devices_model` WHERE `device_id` = ?";
    $stmt = $this->con->prepare($model_query);
    $stmt->execute(array($device_id));
    $model_count = $stmt->rowCount();
    $models_row =  $stmt->fetchAll();
    // return result
    return $model_count > 0 ? [$model_count, $models_row] : [0, null];
  }

  // insert a new model
  public function insert_new_model($info) {
    // insert query
    $model_insert_query = "INSERT INTO `devices_model` (`model_name`, `added_date`, `added_by`, `device_id`) VALUES (?, ?, ?, ?);";
    $stmt = $this->con->prepare($model_insert_query);
    $stmt->execute($info);
    $model_count =  $stmt->rowCount();       // count effected rows
    // return result
    return $model_count > 0 ? true : false;
  }

  // update type
  public function update_model($model_name, $model_id) {
  // update query
  $updateQuery = "UPDATE `devices_model` SET `model_name` = ? WHERE `model_id` = ?";
  $stmt = $this->con->prepare($updateQuery);
  $stmt->execute(array($model_name, $model_id));
  $model_count =  $stmt->rowCount();       // count effected rows
  // return result
  return $model_count > 0 ? true : false;
  }

  // delete specific model
  public function delete_model($model_id) {
    // // delete query
    // $model_delete_query = "DELETE FROM `devices_model` WHERE `model_id` = ?";
    // $stmt = $this->con->prepare($model_delete_query);
    // $stmt->execute(array($model_id));
    // $model_count =  $stmt->rowCount();       // count effected rows
    // // return result
    // return $model_count > 0 ? true : false;
    return false;
  }

  // delete specific model
  public function delete_device_models($device_id) {
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
