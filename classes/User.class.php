<?php

/**
 * User class
 */
class User extends Database
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

  // function to get user id by his username
  public function get_user_id($username)
  {
    // get user id by user name
    $user_id = $this->select_specific_column("`UserID`", "`users`", "WHERE `username` = '{$username}'")[0]['UserID'];
    // return
    return $user_id;
  }

  // function to get all users of specific company
  public function get_all_users($company_id, $condition = "AND `deleted_at` IS NULL")
  {
    // select user info query
    $users_info_query = "SELECT *FROM `users` WHERE `UserID` != 1 AND `company_id` = ? {$condition} ORDER BY `trust_status` DESC, `is_tech` ASC";
    // prepare the query
    $stmt = $this->con->prepare($users_info_query); // select all users
    $stmt->execute(array($company_id)); // execute data
    $rows = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // all count of data

    // check count
    if ($count > 0) {
      // empty array for final result
      $res = [];
      // loop on users_info
      foreach ($rows as $key => $user) {
        $res[] = $this->prepare_data($user);
      }
      // return final result
      return $res;
    }

    // return
    return null;
  }

  public function prepare_data($user_info)
  {
    // extract user
    extract($user_info);
    // push current user info to final result
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
      "change_company_img" => $change_company_img
    ];
  }

  // function to get all users of specific company
  public function get_all_users_counter($condition = null)
  {
    // select user info query
    $users_info_query = "SELECT COUNT(`UserID`) FROM `users` WHERE `UserID` != 1 {$condition}";
    // prepare the query
    $stmt = $this->con->prepare($users_info_query); // select all users
    $stmt->execute(); // execute data
    $count = $stmt->fetchColumn(); // assign all data to variable
    // return
    return $count;
  }

  // function to get all users of specific company
  public function get_user_info($user_id, $company_id)
  {
    // select user info query
    $user_info_query = "SELECT *FROM `users` WHERE `UserID` != 1 AND `UserID` = ? AND `company_id` = ? ORDER BY `trust_status` DESC, `is_tech` ASC LIMIT 1";
    // prepare the query
    $stmt = $this->con->prepare($user_info_query); // select all users
    $stmt->execute(array($user_id, $company_id)); // execute data
    $rows = $stmt->fetch(); // assign all data to variable
    $count = $stmt->rowCount(); // all count of data

    // check count
    if ($count > 0) {
      // return final result of user info
      return $this->prepare_data($rows);
    }

    // return
    return null;
  }

  /**
   * get_user_info_reset_password function
   * function to get user depending on 2 param
   * [1] his phone number
   * [2] his company code
   */
  public function get_user_info_reset_password($phone, $company_code)
  {
    // select user info query
    $user_info_query = "SELECT `users`.`UserID`, `users`.`username`, `users`.`phone`, `companies`.`company_name`, `companies`.`company_code` FROM `users` LEFT JOIN `companies` ON `companies`.`company_id` = `users`.`company_id` WHERE `users`.`phone` = ? AND `companies`.`company_code` = ? LIMIT 1";
    // prepare the query
    $stmt = $this->con->prepare($user_info_query); // select specific users
    $stmt->execute(array($phone, $company_code)); // execute data
    $user_info = $stmt->fetch(); // assign specific data to variable
    $count = $stmt->rowCount(); // specific count of data
    // return
    return $count > 0 ? $user_info : null;
  }

  /**
   * get_reset_password_info function
   * function to get reset password info depending on 2 param
   * [1] his phone number
   * [2] his company code
   */
  public function get_reset_password_info($phone, $company_code)
  {
    // select user info query
    $user_info_query = "SELECT *FROM `password_resets` WHERE `password_resets`.`phone` = ? AND `password_resets`.`company_code` = ? LIMIT 1";
    // prepare the query
    $stmt = $this->con->prepare($user_info_query); // select specific users
    $stmt->execute(array($phone, $company_code)); // execute data
    $user_info = $stmt->fetch(); // assign specific data to variable
    $count = $stmt->rowCount(); // specific count of data
    // return
    return $count > 0 ? $user_info : null;
  }


  // insert a new user in specific company
  public function insert_user_info($info)
  {
    // query to insert the new user in `users` table
    $insertInfoQuery = "INSERT INTO `users` (`company_id`, `username`, `password`, `email`, `fullname`, `is_tech`, `job_title_id`, `gender`, `address`, `phone`, `date_of_birth`, `trust_status`, `added_by`, `joined_at`, `updated_at`, `twitter`, `facebook`, `user_add`, `user_update`, `user_delete`, `user_show`, `mal_add`, `mal_update`, `mal_delete`, `mal_show`, `mal_review`, `mal_media_delete`, `mal_media_download`, `comb_add`, `comb_update`, `comb_delete`, `comb_show`, `comb_review`, `comb_media_delete`, `comb_media_download`, `pcs_add`, `pcs_update`, `pcs_delete`, `pcs_show`, `clients_add`, `clients_update`, `clients_delete`, `clients_show`, `dir_add`, `dir_update`, `dir_delete`, `dir_show`,  `connection_add`, `connection_update`, `connection_delete`, `connection_show`, `permission_update`, `permission_show`, `change_mikrotik`, `change_company_img`) ";
    $insertInfoQuery .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    // insert user info in database
    $stmt = $this->con->prepare($insertInfoQuery);
    $stmt->execute($info); // execute the query
    $count = $stmt->rowCount(); // get number of effected rows
    // return 
    return $count > 0 ? true : false;
  }

  // delete user 
  public function temp_delete_user($userid)
  {
    // query for delete all user info, permissions, points, columns
    $q = "UPDATE `users` SET `deleted_at` = now() WHERE `UserID` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($q);
    $stmt->execute(array($userid)); // execute the query
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // delete user 
  public function delete_user($userid)
  {
    // query for delete all user info, permissions, points, columns
    $q = "DELETE FROM `users` WHERE `UserID` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($q);
    $stmt->execute(array($userid)); // execute the query
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // delete user 
  public function restore_deleted_user($userid)
  {
    // query for delete all user info, permissions, points, columns
    $q = "UPDATE `users` SET `deleted_at` = NULL WHERE `UserID` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($q);
    $stmt->execute(array($userid)); // execute the query
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // update user info
  public function update_user_info($info)
  {
    // update personal info
    $update_info_query = "UPDATE `users` SET `username` = ?, `password` = ?, `email` = ?, `fullname` = ?, `is_tech` = ?, `job_title_id` = ?, `gender` = ?, `address` = ?, `phone` = ?, `date_of_birth` = ?, `trust_status` = ?, `updated_at` = now(), `twitter` = ?, `facebook` = ? WHERE `UserID` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($update_info_query);
    $stmt->execute($info);
    $count = $stmt->rowCount(); // get number of effected rows
    // // return
    // return $count > 0 ? true : false;
  return $stmt;
  }

  public function upload_profile_img($info)
  {
    // update query
    $upload_profile_img_query = "UPDATE `users` SET `profile_img` = ? WHERE `UserID` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_profile_img_query);
    $stmt->execute($info);
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function delete_profile_img($user_id)
  {
    // update query
    $upload_profile_img_query = "UPDATE `users` SET `profile_img` = '' WHERE `UserID` = ?";
    // update the database with this info
    $stmt = $this->con->prepare($upload_profile_img_query);
    $stmt->execute(array($user_id));
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // update user permissions
  public function update_user_permissions($permissions)
  {
    // update permissions
    $permissionsQuery = "UPDATE `users` SET  `user_add` = ?, `user_update` = ?, `user_delete` = ?, `user_show` = ?, `mal_add` = ?, `mal_update` = ?, `mal_delete` = ?, `mal_show` = ?, `mal_review` = ?, `mal_media_delete` = ?, `mal_media_download` = ?, `comb_add` = ?, `comb_update` = ?, `comb_delete` = ?, `comb_show` = ?, `comb_review` = ?, `comb_media_delete` = ?, `comb_media_download` = ?, `pcs_add` = ?, `pcs_update` = ?, `pcs_delete` = ?, `pcs_show` = ?, `clients_add` = ?, `clients_update` = ?, `clients_delete` = ?, `clients_show` = ?, `dir_add` = ?, `dir_update` = ?, `dir_delete` = ?, `dir_show` = ?, `connection_add` = ?, `connection_update` = ?, `connection_delete` = ?, `connection_show` = ?, `permission_update` = ?, `permission_show` = ?, `change_mikrotik` = ?, `change_company_img` = ? WHERE `UserID` = ?";
    $stmt = $this->con->prepare($permissionsQuery);
    $stmt->execute($permissions);
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // change user language
  public function change_user_language($language, $user_id)
  {
    // change language query
    $changeLangQuery = "UPDATE `users` SET `system_lang` = ? WHERE `UserID` = ?";
    // prepare statement
    $stmt = $this->con->prepare($changeLangQuery);
    $stmt->execute(array($language, $user_id));
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // do rating app
  public function do_rating_app($info)
  {
    // rating app query
    $ratingAppQuery = "INSERT INTO `app_rating`(`added_by`, `created_at`, `company_id`, `rating`, `comment`) VALUES (?, now(), ?, ?, ?)";
    // prepare statement
    $stmt = $this->con->prepare($ratingAppQuery);
    $stmt->execute($info);
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  public function change_other_settings($info)
  {
    // change other settings query
    $other_settings_query = "UPDATE `users` SET `ping_counter` = ? WHERE `UserID` = ?";
    // prepare statement
    $stmt = $this->con->prepare($other_settings_query);
    $stmt->execute($info);
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : null;
  }

  public function activate_phone($id)
  {
    // activate phone query
    $other_settings_query = "UPDATE `users` SET `is_activated_phone` = 1 WHERE `UserID` = ?";
    // prepare statement
    $stmt = $this->con->prepare($other_settings_query);
    $stmt->execute(array($id));
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : null;
  }

  // function to store activation code 
  public function add_activation_code($info)
  {
    // insert code query
    $insertCode = "INSERT INTO `users_activations`(`id`, `mobile`, `token`, `created_at`) VALUES (?, ?, ?, now())";
    // prepare statement
    $stmt = $this->con->prepare($insertCode);
    $stmt->execute($info);
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // function to delete activation code 
  public function delete_activation_code($id, $mobile)
  {
    // // delete code query
    // $deleteCode = "DELETE FROM `users_activations` WHERE `id` = ? AND `mobile` = ?";
    // // prepare statement
    // $stmt = $this->con->prepare($deleteCode);
    // $stmt->execute(array($id, $mobile));
    // $count = $stmt->rowCount(); // get number of effected rows
    // // return
    // return $count > 0 ? true : false;
    return false;
  }

  public function get_activation_info($id, $mobile)
  {
    // select user info query
    $users_info_query = "SELECT *FROM `users_activations` WHERE `id` = ? AND `mobile` = ?";
    // prepare the query
    $stmt = $this->con->prepare($users_info_query); // select all users
    $stmt->execute(array($id, $mobile)); // execute data
    $rows_counter = $stmt->fetch(); // all count of data
    // return
    return $rows_counter;
  }

  // function to store password_reset code 
  public function add_password_reset_code($info)
  {
    // insert code query
    $insertCode = "INSERT INTO `password_resets`(`phone`, `token`, `company_code`, `created_at`) VALUES (?, ?, ?, now())";
    // prepare statement
    $stmt = $this->con->prepare($insertCode);
    $stmt->execute($info);
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : false;
  }

  // function to delete password_reset code 
  public function delete_password_reset_code($phone, $company_code)
  {
    // // delete code query
    // $deleteCode = "DELETE FROM `password_resets` WHERE `phone` = ? AND `company_code` = ?";
    // // prepare statement
    // $stmt = $this->con->prepare($deleteCode);
    // $stmt->execute(array($phone, $company_code));
    // $count = $stmt->rowCount(); // get number of effected rows
    // // return
    // return $count > 0 ? true : false;
    return false;
  }

  public function get_password_reset_info($phone, $company_code)
  {
    // select user info query
    $users_info_query = "SELECT *FROM `password_resets` WHERE `phone` = ? AND `company_code` = ?";
    // prepare the query
    $stmt = $this->con->prepare($users_info_query); // select all users
    $stmt->execute(array($phone, $company_code)); // execute data
    $rows_counter = $stmt->fetch(); // all count of data
    // return
    return $rows_counter;
  }

  // reset user password
  public function reset_password($password, $user_id)
  {
    // activate phone query
    $other_settings_query = "UPDATE `users` SET `password` = ? WHERE `UserID` = ?";
    // prepare statement
    $stmt = $this->con->prepare($other_settings_query);
    $stmt->execute(array($password, $user_id));
    $count = $stmt->rowCount(); // get number of effected rows
    // return
    return $count > 0 ? true : null;
  }

  // search for employee
  public function search($search_stmt, $company_id)
  {
    // activate phone query
    $search_query = "SELECT `UserID`, `fullname`, `username`, `email`, `is_tech`, `job_title_id`, `address`, `phone` FROM `users` WHERE (`fullname` LIKE '%{$search_stmt}%' OR `username` LIKE '%{$search_stmt}%' OR `email` LIKE '%{$search_stmt}%' OR `is_tech` LIKE '%{$search_stmt}%' OR `job_title_id` LIKE '%{$search_stmt}%' OR `address` LIKE '%{$search_stmt}%' OR `phone` LIKE '%{$search_stmt}%') AND `company_id` = ?;";
    // prepare statement
    $stmt = $this->con->prepare($search_query);
    $stmt->execute(array($company_id));
    $count = $stmt->rowCount(); // get number of effected rows
    $serach_res = $stmt->fetchAll(); // all count of data
    // empty response
    $response = [];
    // loop on data
    foreach ($serach_res as $key => $search) {
      // extract
      extract($search);
      // prepare response
      $response[] = [
        'userid' => $UserID,
        'fullname' => $fullname,
        'username' => $username,
        'email' => $email,
        'is_tech' => $is_tech,
        'job_title_id' => $job_title_id,
        'address' => $address,
        'phone' => $phone,
      ];
    }

    // return
    return $count > 0 ?  $response : null;
  }
}
