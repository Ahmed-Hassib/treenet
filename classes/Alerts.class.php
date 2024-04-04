<?php


class Alerts extends Database
{
  // properties
  public $con;
  // table name
  public $table_name = 'system_alerts';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // get all alerts
  public function get_all_alerts($company_id, $condition = null)
  {
    // query
    $query = "SELECT *FROM `$this->table_name` WHERE `company_id` = ? {$condition};";
    $stmt = $this->con->prepare($query);
    $stmt->execute(array($company_id));
    // get records
    $alerts = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // return null
    return $count > 0 ? $alerts : null;
  }
}
