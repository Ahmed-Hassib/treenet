<?php

/**
 * Company class
 */
class CompSugg extends Database
{
  // properties
  public $con;
  public $max_file_size = 1048576;  // (1MB = 1048576B in binary) is max file size


  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // function to complaints of specific company
  public function get_complaints($user_id, $company_id)
  {
    // complaints data
    $complaints_query = "SELECT *FROM `comp_sugg` WHERE `type` = 'comp' AND `added_by` = ? AND `company_id` = ?;";
    $stmt = $this->con->prepare($complaints_query);
    $stmt->execute(array($user_id, $company_id));
    $complaints_data = $stmt->fetchAll();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $complaints_data : null;
  }

  // function to suggestions of specific company
  public function get_suggestions($user_id, $company_id)
  {
    // suggestions data
    $suggestions_query = "SELECT *FROM `comp_sugg` WHERE `type` = 'sugg' AND `added_by` = ? AND `company_id` = ?;";
    $stmt = $this->con->prepare($suggestions_query);
    $stmt->execute(array($user_id, $company_id));
    $suggestions_data = $stmt->fetchAll();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $suggestions_data : null;
  }


  // function to get data of specific id
  public function get_specific_data($id, $company_id)
  {
    // data
    $query = "SELECT *FROM `comp_sugg` WHERE `id` = ? AND `company_id` = ? LIMIT 1;";
    $stmt = $this->con->prepare($query);
    $stmt->execute(array($id, $company_id));
    $data = $stmt->fetch();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $data : null;
  }

  // function to get specific data inspecific period
  public function get_data($type, $user_id, $company_id, $condition = null)
  {
    // check condition
    if (!is_null($condition)) {
      // data query
      $data_query = "SELECT *FROM `comp_sugg` WHERE {$condition};";
    } else {
      $data_query = "SELECT *FROM `comp_sugg` WHERE `type` = ? AND `added_by` = ? AND `company_id` = ?;";
    }
    // prepare query
    $stmt = $this->con->prepare($data_query);
    $stmt->execute(is_null($condition) ? array($type, $user_id, $company_id) : null);
    $data = $stmt->fetchAll();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $data : null;
  }

  // function for insert a new complaint or suggestion
  public function insert_new($info)
  {
    // prepare the query
    $insert_query = "INSERT INTO `comp_sugg` (`company_id`, `added_by`, `text`, `type`) VALUES (?, ?, ?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();    // count afected rows
    // return
    return $count > 0 ? true : false;
  }

  // function for insert a new complaint or suggestion media
  public function insert_media($id, $media, $type)
  {
    // prepare the query
    $insert_query = "INSERT INTO `comp_sugg_media` (`comp_sugg_id`, `media`, `type`) VALUES (?, ?, ?);";
    $stmt = $this->con->prepare($insert_query);
    $stmt->execute(array($id, $media, $type));
    $count = $stmt->rowCount();    // count afected rows
    // return
    return $count > 0 ? true : false;
  }

  // function to get complaint or suggestion media 
  public function get_media($id) {
    // data query
    $media_query = "SELECT *FROM `comp_sugg_media` WHERE `comp_sugg_id` = ? LIMIT 1;";
    // prepare query
    $stmt = $this->con->prepare($media_query);
    $stmt->execute(array($id));
    $data = $stmt->fetch();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $data : null;
  }

  // function for update complaint or suggestion
  public function update($info)
  {
    // prepare the query
    $update_query = "UPDATE `comp_sugg` SET `text` = ?, `type` = ?, `updated_at` = now() WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute($info);
    $count = $stmt->rowCount();    // count afected rows
    // return
    return $count > 0 ? true : false;
  }

  // function for update complaint or suggestion
  public function update_status($status, $id)
  {
    // prepare the query
    $update_query = "UPDATE `comp_sugg` SET `status` = ? WHERE `id` = ?;";
    $stmt = $this->con->prepare($update_query);
    $stmt->execute(array($status, $id));
    $count = $stmt->rowCount();    // count afected rows
    // return
    return $count > 0 ? true : false;
  }
}
