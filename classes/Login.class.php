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
    return $count > 0 ? $this->prepare_login_data($emp_info) : null;
  }

  public function prepare_login_data($info)
  {
    extract($info);
    return [
      "UserID" => $UserID,
      "company_id" => $company_id,
      "username" => $username,
      "password" => $password,
      "email" => $email,
      "email_verified_at" => $email_verified_at,
      "fullname" => $fullname,
      "is_tech" => $is_tech,
      "job_title_id" => $job_title_id,
      "gender" => $gender,
      "address" => $address,
      "phone" => $phone,
      "is_activated_phone" => $is_activated_phone,
      "date_of_birth" => $date_of_birth,
      "remember_token" => $remember_token,
      "trust_status" => $trust_status,
      "reg_status" => $reg_status,
      "added_by" => $added_by,
      "is_root" => $is_root,
      "joined_at" => $joined_at,
      "updated_at" => $updated_at,
      "deleted_at" => $deleted_at,
      "is_online" => $is_online,
      "system_lang" => $system_lang,
      "system_theme" => $system_theme,
      "twitter" => $twitter,
      "facebook" => $facebook,
      "profile_img" => $profile_img,
      "ping_counter" => $ping_counter,
      "user_add" => $user_add,
      "user_update" => $user_update,
      "user_delete" => $user_delete,
      "user_show" => $user_show,
      "mal_add" => $mal_add,
      "mal_update" => $mal_update,
      "mal_delete" => $mal_delete,
      "mal_show" => $mal_show,
      "mal_review" => $mal_review,
      "mal_media_delete" => $mal_media_delete,
      "mal_media_download" => $mal_media_download,
      "comb_add" => $comb_add,
      "comb_update" => $comb_update,
      "comb_delete" => $comb_delete,
      "comb_show" => $comb_show,
      "comb_review" => $comb_review,
      "comb_media_delete" => $comb_media_delete,
      "comb_media_download" => $comb_media_download,
      "pcs_add" => $pcs_add,
      "pcs_update" => $pcs_update,
      "pcs_delete" => $pcs_delete,
      "pcs_show" => $pcs_show,
      "clients_add" => $clients_add,
      "clients_update" => $clients_update,
      "clients_delete" => $clients_delete,
      "clients_show" => $clients_show,
      "dir_add" => $dir_add,
      "dir_update" => $dir_update,
      "dir_delete" => $dir_delete,
      "dir_show" => $dir_show,
      "connection_add" => $connection_add,
      "connection_update" => $connection_update,
      "connection_delete" => $connection_delete,
      "connection_show" => $connection_show,
      "permission_update" => $permission_update,
      "permission_show" => $permission_show,
      "change_mikrotik" => $change_mikrotik,
      "change_company_img" => $change_company_img,
      "company_name" => $company_name,
      "company_code" => $company_code,
      "company_img" => $company_img,
      "remote_ip" => $remote_ip,
      "ip_list" => $ip_list,
      "company_port" => $company_port,
      "mikrotik_ip" => $mikrotik_ip,
      "mikrotik_port" => $mikrotik_port,
      "mikrotik_username" => $mikrotik_username,
      "mikrotik_password" => $mikrotik_password,
      "status" => $status,
    ];
  }
}
