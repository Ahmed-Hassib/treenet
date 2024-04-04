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
  public $mikrotik_info_columns;   // for mikrotik info
  public $whatsapp_info_columns;   // for whatsapp info
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

      $this->emp_comp_info = "`companies`.`company_name`, `companies`.`company_code`, `companies`.`company_img`, `companies`.`remote_ip`, `companies`.`ip_list`, `companies`.`company_port`";
      $this->mikrotik_info_columns = "`mikrotik_settings`.`mikrotik_ip`, `mikrotik_settings`.`mikrotik_port`, `mikrotik_settings`.`mikrotik_username`, `mikrotik_settings`.`mikrotik_password`, `mikrotik_settings`.`status`";
      $this->whatsapp_info_columns = "`whatsapp_settings`.`whatsapp_number`, `whatsapp_settings`.`whatsapp_status`";
    }
  }

  // function for login
  public function emp_login()
  {
    // select employee with specific username and password 
    $select_emp =
      "SELECT 
            `users`.*,
            $this->emp_comp_info,
            $this->mikrotik_info_columns,
            $this->whatsapp_info_columns
        FROM `users` 
        LEFT JOIN `companies` ON `companies`.`company_id` = `users`.`company_id`
        LEFT JOIN `mikrotik_settings` ON `mikrotik_settings`.`company_id` = `users`.`company_id`
        LEFT JOIN `whatsapp_settings` ON `whatsapp_settings`.`company_id` = `users`.`company_id`
        WHERE `users`.`username` = ? AND `companies`.`company_code` = ? LIMIT 1";
    // check if employee exist in database
    $stmt = $this->con->prepare($select_emp);
    $stmt->execute(array($this->emp_username, $this->comp_code));
    $emp_info = $stmt->fetch();
    $count = $stmt->rowCount();
    // check the count
    return $count > 0 ? $emp_info : null;
  }
}
