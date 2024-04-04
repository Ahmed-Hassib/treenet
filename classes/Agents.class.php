<?php


class Agents extends Database
{
  // properties
  public $con;
  // table name
  public $table_name = 'agents';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // get all agents
  public function get_all_agents($condition = "WHERE `deleted_at` IS NULL")
  {
    // query
    $query = "SELECT *FROM `$this->table_name` {$condition};";
    $stmt = $this->con->prepare($query);
    $stmt->execute();
    // get records
    $agents = $stmt->fetchAll();
    $count = $stmt->rowCount();
    // return null
    return $count > 0 ? $agents : null;
  }
  
  // get all agents counter
  public function get_all_agents_counter($condition = "WHERE `deleted_at` IS NULL")
  {
    // query
    $query = "SELECT COUNT(`id`) FROM `$this->table_name` {$condition};";
    $stmt = $this->con->prepare($query);
    $stmt->execute();
    // get records
    $agents_counter = $stmt->fetchColumn();
    // return counter
    return $agents_counter;
  }
}
