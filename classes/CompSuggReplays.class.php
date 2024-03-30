<?php

/**
 * Company class
 */
class CompSuggReplays extends Database
{
  // properties
  public $con;
  public $table_name = 'comp_sugg_replay';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // get all comments
  public function get_comments($comp_sugg_id) {
    $query = "SELECT *FROM `{$this->table_name}` WHERE `comp_sugg_id` = ?;";
    $stmt = $this->con->prepare($query);
    $stmt->execute(array($comp_sugg_id));
    $comments = $stmt->fetchAll();
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? $comments : null;
  
  }

  // add a new comment
  public function insert_comment($info) {
    $query = "INSERT INTO `{$this->table_name}` (`comp_sugg_id`, `replay_text`, `added_by`, `created_at`) VALUES (?, ?, ?, now());";
    $stmt = $this->con->prepare($query);
    $stmt->execute($info);
    $count = $stmt->rowCount();    // all count of data
    // return
    return $count > 0 ? true : null;
  }

}