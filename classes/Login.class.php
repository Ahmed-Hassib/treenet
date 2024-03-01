<?php

/**
 * Login class
 */
class Login extends Database
{
  // properties
  public $id;
  public $emp_username;
  public $emp_password;
  public $comp_code;
  public $emp_permissions;
  public $emp_comp_info;
  public $con;

  // constructor
  public function __construct($username, $password, $code)
  {
    // check if the parameters is empty or not
    if (!empty($username) && !empty($password) && !empty($code)) {
      // create an object of Database class
      $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

      $this->con = $db_obj->con;
      // set username and password
      $this->emp_username = $username;
      $this->emp_password = sha1($password);
      $this->comp_code = $code;
      // columns to select
      $this->emp_permissions = "`users_permissions`.`user_add`,`users_permissions`.`user_update`,`users_permissions`.`user_delete`,`users_permissions`.`user_show`,`users_permissions`.`mal_add`,`users_permissions`.`mal_update`,`users_permissions`.`mal_delete`,`users_permissions`.`mal_show`,`users_permissions`.`mal_review`,`users_permissions`.`mal_media_delete`,`users_permissions`.`mal_media_download`,`users_permissions`.`comb_add`,`users_permissions`.`comb_update`,`users_permissions`.`comb_delete`,`users_permissions`.`comb_show`,`users_permissions`.`comb_review`,`users_permissions`.`comb_media_delete`,`users_permissions`.`comb_media_download`,`users_permissions`.`pcs_add`,`users_permissions`.`pcs_update`,`users_permissions`.`pcs_delete`,`users_permissions`.`pcs_show`,`users_permissions`.`clients_add`,`users_permissions`.`clients_update`,`users_permissions`.`clients_delete`,`users_permissions`.`clients_show`,`users_permissions`.`dir_add`,`users_permissions`.`dir_update`,`users_permissions`.`dir_delete`,`users_permissions`.`dir_show`,`users_permissions`.`sugg_replay`,`users_permissions`.`sugg_delete`,`users_permissions`.`sugg_show`,`users_permissions`.`points_add`,`users_permissions`.`points_delete`,`users_permissions`.`points_show`,`users_permissions`.`reports_show`,`users_permissions`.`archive_show`,`users_permissions`.`take_backup`,`users_permissions`.`restore_backup`,`users_permissions`.`connection_add`,`users_permissions`.`connection_update`,`users_permissions`.`connection_delete`,`users_permissions`.`connection_show`,`users_permissions`.`permission_update`,`users_permissions`.`permission_show`,`users_permissions`.`change_mikrotik`,`users_permissions`.`change_company_img`";
      // get company info
      $this->emp_comp_info = "`companies`.`company_name`,`companies`.`company_code`,`companies`.`company_img`, `companies`.`remote_ip`, `companies`.`ip_list`, `companies`.`company_port`, `mikrotik_settings`.`mikrotik_ip`, `mikrotik_settings`.`mikrotik_port`, `mikrotik_settings`.`mikrotik_username`, `mikrotik_settings`.`mikrotik_password`,`mikrotik_settings`.`status`,`whatsapp_settings`.`whatsapp_number`, `whatsapp_settings`.`whatsapp_status`";
    }
  }

  // function for login
  public function emp_login()
  {
    // select employee with specific username and password 
    $select_emp =
      "SELECT 
            `users`.*,
            $this->emp_permissions,
            $this->emp_comp_info
        FROM `users` 
        LEFT JOIN `users_permissions` ON `users`.`UserID` = `users_permissions`.`UserID`
        LEFT JOIN `companies` ON `companies`.`company_id` = `users`.`company_id`
        LEFT JOIN `mikrotik_settings` ON `mikrotik_settings`.`company_id` = `users`.`company_id`
        LEFT JOIN `whatsapp_settings` ON `whatsapp_settings`.`company_id` = `users`.`company_id`
        WHERE `users`.`username` = ? AND `users`.`password` = ? AND `companies`.`company_code` = ? LIMIT 1";
    // check if employee exist in database
    $stmt = $this->con->prepare($select_emp);
    $stmt->execute(array($this->emp_username, $this->emp_password, $this->comp_code));
    $emp_info = $stmt->fetch();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ?  $emp_info : null;
  }
}
