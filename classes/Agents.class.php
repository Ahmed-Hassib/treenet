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
    // check cout
    if ($count > 0) {
      // result
      $res = [];
      // loop on aagents$agents
      foreach ($agents as $key => $agent) {
        $res[] = $this->prepare_agent_data($agent);
      }

      // return final result
      return $res;
    }

    // return null
    return null;
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

  public function prepare_agent_data($agent_data) {
    extract($agent_data);
    return [
      'id' => $id,
      'country_id' => $country_id,
      'agent_name' => $agent_name,
      'company_name' => $company_name,
      'phone' => $phone,
      'logo' => $logo,
      'is_active' => $is_active,
      'created_at' => $created_at,
      'updated_at' => $updated_at,
      'deleted_at' => $deleted_at,
    ];
  }
}
