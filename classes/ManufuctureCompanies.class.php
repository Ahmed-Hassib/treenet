<?php
/**
 * ManufuctureCompanies class
 * this class is used to manage all companies of physical devices used in the network
 */
class ManufuctureCompanies extends Database {
  // properties
  public $con;

  // constructor
  public function __construct() {
    // create an object of Database class
        $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }
    
  // get all manufacture_companies
  public function get_all_man_companies($company_id) {
    // get all pieces manufacture_companies
    $dev_comp_query = "SELECT *FROM `manufacture_companies` WHERE `company_id` = ?;";
    $query_stmt = $this->con->prepare($dev_comp_query);
    $query_stmt->execute(array($company_id));
    $companies_data = $query_stmt->fetchAll();
    $dev_company_count =  $query_stmt->rowCount();
    // return result
    return $dev_company_count > 0 ? $companies_data : null;
  }

  // insert a new piece type
  public function insert_new_man_company($info) {
    // insert query
    $dev_comp_insert_query = "INSERT INTO `manufacture_companies` (`man_company_name`, `added_date`, `added_by`, `company_id`) VALUES (?, ?, ?, ?);";
    $query_stmt = $this->con->prepare($dev_comp_insert_query);
    $query_stmt->execute($info);
    $dev_comp_count =  $query_stmt->rowCount();       // count effected rows
    // return result
    return $dev_comp_count > 0 ? true : false;
  }

  // update type
  public function update_man_company($new_name, $company_id) {
    // update query
    $dev_company_update_query = "UPDATE `manufacture_companies` SET `man_company_name` = ? WHERE `man_company_id` = ?";
    $query_stmt = $this->con->prepare($dev_company_update_query);
    $query_stmt->execute(array($new_name, $company_id));
    $dev_company_count =  $query_stmt->rowCount();       // count effected rows
    // return result
    return $dev_company_count > 0 ? true : false;
  }
  
  // update type
  public function delete_man_company($company_id) {
    // // update query
    // $dev_company_delete_query = "DELETE FROM `manufacture_companies` WHERE `man_company_id` = ?";
    // $query_stmt = $this->con->prepare($dev_company_delete_query);
    // $query_stmt->execute(array($company_id));
    // $dev_company_count = $query_stmt->rowCount();       // count effected rows
    // // return result
    // return $dev_company_count > 0 ? true : false;
    return false;
  }
}
