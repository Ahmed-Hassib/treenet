<?php

class SystemSettings extends Database
{
  public $table_name = "settings";
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }

  public function update_system_status($status) {
    // insert query
    $updateQuery = "UPDATE `$this->table_name` SET `is_developing` = ? WHERE `id` = 1";
    $stmt = $this->con->prepare($updateQuery);
    $stmt->execute(array($status));
    $count =  $stmt->rowCount();       // count effected rows
    // return result
    return $count > 0 ? true : false;
  }
}