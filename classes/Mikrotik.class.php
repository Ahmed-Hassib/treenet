<?php

class Mikrotik extends Database
{
  public $table_name = "mikrotik_settings";
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }

  public function get_mikrotik_info($company_id)
  {
    // select query
    $mikrotik_query = "SELECT *FROM `$this->table_name` WHERE `company_id` = ?";
    // select from the database
    $stmt = $this->con->prepare($mikrotik_query);
    $stmt->execute($company_id);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function insert_mikrotik_info($info)
  {
    // insert query
    $mikrotik_query = "INSERT INTO `$this->table_name` (`company_id`, `mikrotik_ip`, `mikrotik_port`, `mikrotik_username`, `mikrotik_password`, `status`) VALUES (?,?,?,?,?,?)";
    // update the database with this info
    $stmt = $this->con->prepare($mikrotik_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function update_mikrotik_info($info)
  {
    // update query
    $mikrotik_query = "UPDATE `$this->table_name` SET `mikrotik_ip` = ?, `mikrotik_port` = ?, `mikrotik_username` = ?, `mikrotik_password` = ?, `status` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($mikrotik_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function update_mikrotik_status($status, $company_id)
  {
    // update query
    $mikrotik_query = "UPDATE `$this->table_name` SET `status` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($mikrotik_query);
    $stmt->execute(array($status, $company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

}