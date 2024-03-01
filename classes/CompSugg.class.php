<?php
/**
 * Company class
 */
class CompSugg extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
        $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }

  // function to complaints of specific company
  public function get_all_complaints($user_id, $company_id) {
    // complaints data
    $complaints_query = "SELECT *FROM `comp_sugg` WHERE `type` = 0 AND `added_by` = ? AND `company_id` = ?";
    $stmt = $this->con->prepare($complaints_query);
    $stmt->execute(array($user_id, $company_id));
    $complaints_data = $stmt->fetchAll();
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? $complaints_data : null;
  }
  
  // function to suggestions of specific company
  public function get_all_suggestions($user_id, $company_id) {
    // suggestions data
    $suggestions_query = "SELECT *FROM `comp_sugg` WHERE `type` = 1 AND `added_by` = ? AND `company_id` = ?";
    $stmt = $this->con->prepare($suggestions_query);
    $stmt->execute(array($user_id, $company_id));
    $suggestions_data = $stmt->fetchAll();
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? $suggestions_data : null;
  }
  
  // function to get specific data inspecific period
  public function get_all_data($type, $user_id, $company_id, $condition = null) {
    // data query
    $data_query = "SELECT *FROM `comp_sugg` WHERE " . ($condition != null ? $condition.' AND' : '') . " `type` = ? AND `added_by` = ? AND `company_id` = ?";
    $stmt = $this->con->prepare($data_query);
    $stmt->execute(array($type, $user_id, $company_id));
    $data = $stmt->fetchAll();
    $count = $stmt->rowCount() ;    // all count of data
    // return
    return $count > 0 ? $data : null;
  }

  // function for insert a new complaint or suggestion
  public function insert_new($info) {
    // prepare the query
    $insert_query = "INSERT INTO `comp_sugg` (`added_by`, `type`, `message`, `added_date`, `added_time`, `company_id`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount() ;    // count afected rows
    // return
    return $count > 0 ? true : false;
  }
}