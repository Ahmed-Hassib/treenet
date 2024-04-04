<?php

/**
 * Registration class
 */
class Registration extends Database
{
  // properties
  public $con;

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  public function add_new_company($info)
  {
    // insertion query for company data
    $company_query = "INSERT INTO `companies` (`company_name`, `company_code`, `company_manager`, `company_phone`,`country_id`, `agent`, `version`, `joined_date`) VALUES (?, ?, ?, ?, ?, ?, 3, ?)";
    $company_stmt = $this->con->prepare($company_query);
    $company_stmt->execute($info);
    $count = $company_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  public function delete_company($id)
  {
    // insertion query for company data
    $company_query = "DELETE FROM `companies` WHERE `company_id` = ?";
    $company_stmt = $this->con->prepare($company_query);
    $company_stmt->execute(array($id));
    $count = $company_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  public function add_company_license($info)
  {
    // activate license with month trial
    $license_info_query = "INSERT INTO `license` (`company_id`, `type`, `start_date`, `expire_date`, `isTrial`) VALUES (?, 1, ?, ?, 1)";
    $license_info_stmt = $this->con->prepare($license_info_query);
    $license_info_stmt->execute($info);
    $count = $license_info_stmt->rowCount();
    // return statement
    return $count > 0 ? true : false;
  }

  public function delete_company_license($id)
  {
    // activate license with month trial
    $license_info_query = "DELETE FROM `license` WHERE `ID` = ? ";
    $license_info_stmt = $this->con->prepare($license_info_query);
    $license_info_stmt->execute(array($id));
    $count = $license_info_stmt->rowCount();
    // return statement
    return $count > 0 ? true : false;
  }

  public function add_company_admin($info)
  {
    // insert admin info
    $admin_info_query = "INSERT INTO `users` (`company_id`, `username`, `password`, `email`, `fullname`, `is_tech`, `job_title_id`, `phone`, `gender`, `trust_status`, `added_by`,  `joined_at`, `system_lang`) VALUES (?, ?, ?, ?, ?, 0, 1, ?, ?, 1, 1, now(), 0)";
    $admin_info_stmt = $this->con->prepare($admin_info_query);
    $admin_info_stmt->execute($info);
    $count = $admin_info_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  public function delete_company_admin($id)
  {
    // insert admin info
    $admin_info_query = "DELETE FROM `users` WHERE `UserID` = ?";
    $admin_info_stmt = $this->con->prepare($admin_info_query);
    $admin_info_stmt->execute(array($id));
    $count = $admin_info_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }

  public function add_admin_permission($user_id)
  {
    // insert admin info
    $admin_permissions_query = "UPDATE `users` SET `user_add` = 1, `user_update` = 1, `user_delete` = 1, `user_show` = 1, `mal_add` = 1, `mal_update` = 1, `mal_delete` = 1, `mal_show` = 1, `mal_review` = 1, `mal_media_delete` = 1, `mal_media_download` = 1, `comb_add` = 1, `comb_update` = 1, `comb_delete` = 1, `comb_show` = 1, `comb_review` = 1, `comb_media_delete` = 1, `comb_media_download` = 1, `pcs_add` = 1, `pcs_update` = 1, `pcs_delete` = 1, `pcs_show` = 1, `clients_add` = 1, `clients_update` = 1, `clients_delete` = 1, `clients_show` = 1, `dir_add` = 1, `dir_update` = 1, `dir_delete` = 1, `dir_show` = 1, `reports_show` = 1, `archive_show` = 1, `connection_add` = 1, `connection_update` = 1, `connection_delete` = 1, `connection_show` = 1, `permission_update` = 1, `permission_show` = 1, `change_mikrotik` = 1, `change_company_img` = 1 WHERE `UserID` = ?;";
    $admin_permissions_stmt = $this->con->prepare($admin_permissions_query);
    $admin_permissions_stmt->execute(array($user_id));
    $count = $admin_permissions_stmt->rowCount();
    // return
    return $count > 0 ? true : false;
  }
}
