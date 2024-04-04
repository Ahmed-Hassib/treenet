<?php

// Versions class
class Versions extends Database {
  // properties
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  public function get_latest_version() {
    // insertion query for version data
    $version_query = "SELECT *FROM `versions` WHERE `is_working` = 1 AND `is_developing` = 0 AND `is_expired` = 0 ORDER BY `v_id` DESC LIMIT 1";
    $version_stmt = $this->con->prepare($version_query);
    $version_stmt->execute();
    $version_info = $version_stmt->fetch();
    $count = $version_stmt->rowCount();
    // return
    return $count > 0 ? $version_info : false;
  }
}