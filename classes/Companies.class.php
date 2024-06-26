<?php

/**
 * Company class
 */
class Company extends Database
{
  // properties
  public $table_name = "companies";
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function to get all companies
  public function get_all_companies()
  {
    // get all companies data
    $select_all = "SELECT *FROM `$this->table_name` WHERE `company_id` != 1";
    $stmt = $this->con->prepare($select_all);
    $stmt->execute();
    $companies_data = $stmt->fetchAll();
    $count = $stmt->rowCount();    // all count of data
    // return null
    return $count > 0 ? $companies_data : null;
  }

  // function to get all companies
  public function get_all_companies_counter($condition = null)
  {
    // get all companies data
    $select_all = "SELECT COUNT(`company_id`) FROM `$this->table_name` WHERE `company_id` != 1 {$condition}";
    $stmt = $this->con->prepare($select_all);
    $stmt->execute();
    $companies_counter = $stmt->fetchColumn();
    // return counter
    return $companies_counter;
  }

  // function to get company info
  public function get_company_info($company_id)
  {
    // get company info data
    $select_all = "SELECT *FROM `$this->table_name` WHERE `company_id` = ? AND `company_id` != 1 LIMIT 1";
    $stmt = $this->con->prepare($select_all);
    $stmt->execute(array($company_id));
    $company_data = $stmt->fetch();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $company_data : null;
  }

  // function to get company employees
  public function get_company_employees($company_id)
  {
    // get company employees data
    $select_all = "SELECT *FROM `users` WHERE `company_id` = ? AND `company_id` != 1";
    $stmt = $this->con->prepare($select_all);
    $stmt->execute(array($company_id));
    $company_emps = $stmt->fetchAll();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $company_emps : null;
  }

  // function to upgrade company version
  public function upgrade_version($new_version_id, $company_id)
  {
    // update statement
    $update_query = "UPDATE `$this->table_name` SET `version` = ? WHERE `company_id` = ?";
    $stmt = $this->con->prepare($update_query);   // prepare query
    $stmt->execute(array($new_version_id, $company_id));    // execute query
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $count : null;
  }

  /**
   * get_licenses_info function v1
   */
  public function get_licenses_info($company_id, $add_condition = null)
  {
    $select_query = "SELECT *FROM `license` WHERE `company_id` = ? {$add_condition} ORDER BY `ID` DESC;";
    $stmt = $this->con->prepare($select_query);
    $stmt->execute(array($company_id));
    $licenses_info = $stmt->fetchAll();
    $licenses_count = $stmt->rowCount();
    // return resurt or null
    return $licenses_count > 0 ? $licenses_info : null;
  }

  // function to renew company license
  public function renew_license($license_type, $expire_date, $company_id, $plan_id, $order_id = 0, $transaction_id = 0, $is_trial = 1)
  {
    $inset_query = "INSERT INTO `license` (`company_id`, `type`, `start_date`, `expire_date`, `isTrial`, `plan_id`, `transaction_id`, `order_id`) VALUES (?, ?, now(), ?, ?, ?, ?, ?);";
    // update the database with this info
    $stmt = $this->con->prepare($inset_query);
    $stmt->execute(array($company_id, $license_type, $expire_date, $is_trial, $plan_id, $transaction_id, $order_id));
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? true : false;
  }


  // function to update the previous license
  public function end_licenses($company_id)
  {
    // update query
    $update_query = "UPDATE `license` SET `isEnded` = 1 WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($company_id));
    $count = $stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  // function to update the license
  public function update_licenses($company_id, $license_id, $new_values_conditions)
  {
    // update query
    $update_query = "UPDATE `license` SET {$new_values_conditions} WHERE `company_id` = ? AND `ID` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($company_id, $license_id));
    $count = $stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  public function upload_company_img($info)
  {
    // update query
    $upload_company_img_query = "UPDATE `$this->table_name` SET `company_img` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_company_img_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function delete_company_img($company_id)
  {
    // update query
    $upload_company_img_query = "UPDATE `$this->table_name` SET `company_img` = '' WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_company_img_query);
    $stmt->execute(array($company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function update_company_code($company_id, $company_code)
  {
    // update query
    $company_code_query = "UPDATE `$this->table_name` SET `company_code` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($company_code_query);
    $stmt->execute(array($company_code, $company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }


  public function update_opened_ports($company_id, $value)
  {
    // update query
    $opened_ports_query = "UPDATE `$this->table_name` SET `opened_ports` = ? WHERE `company_id` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($opened_ports_query);
    $stmt->execute(array($value, $company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function get_remote_ip($company_id)
  {
    $select_stmt = "SELECT `remote_ip` FROM `$this->table_name` WHERE `company_id` = ?";
    $stmt = $this->con->prepare($select_stmt);
    $stmt->execute(array($company_id));
    $result = $stmt->fetchAll();
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? $result[0]["remote_ip"] : false;
  }

  public function set_remote_ip($company_id, $remote_ip)
  {
    $select_stmt = "UPDATE `$this->table_name` SET `remote_ip` = ? WHERE `company_id` = ?";
    $stmt = $this->con->prepare($select_stmt);
    $stmt->execute(array($remote_ip, $company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function get_ip_list($company_id)
  {
    $select_stmt = "SELECT `ip_list` FROM `$this->table_name` WHERE `company_id` = ? LIMIT 1";
    $stmt = $this->con->prepare($select_stmt);
    $stmt->execute(array($company_id));
    $result = $stmt->fetchAll();
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? $result[0]["ip_list"] : false;
  }

  public function set_ip_list($company_id, $ip_list)
  {
    $select_stmt = "UPDATE `$this->table_name` SET `ip_list` = ? WHERE `company_id` = ?";
    $stmt = $this->con->prepare($select_stmt);
    $stmt->execute(array($ip_list, $company_id));
    $count = $stmt->rowCount();     // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function delete_company_info($company_id)
  {
    return false;
  }
}
