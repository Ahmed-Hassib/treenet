<?php

/**
 * PiecesConn class
 */
class PiecesConn extends Database
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

  // get all types_conn
  public function get_all_conn_types($company_id)
  {
    // get all pieces types_conn
    $typesQuery = "SELECT *FROM `connection_types` WHERE `company_id` = ?";
    $stmt = $this->con->prepare($typesQuery);
    $stmt->execute(array($company_id));
    $typesRows = $stmt->fetchAll();
    $typesCount =  $stmt->rowCount();
    // return result
    return $typesCount > 0 ? $typesRows : null;
  }

  // insert a new piece type
  public function insert_new_conn_type($name, $note, $company_id)
  {
    // insert query
    $insertQuery = "INSERT INTO `connection_types` (`connection_name`, `notes`, `company_id`) VALUES (?, ?, ?);";
    $stmt = $this->con->prepare($insertQuery);
    $stmt->execute(array($name, $note, $company_id));
    $typesCount =  $stmt->rowCount();       // count effected rows
    // return result
    return $typesCount > 0 ? true : false;
  }

  // update type
  public function update_conn_type($name, $note, $id)
  {
    // insert query
    $updateQuery = "UPDATE `connection_types` SET `connection_name` = ?, `notes` = ? WHERE `id` = ?";
    $stmt = $this->con->prepare($updateQuery);
    $stmt->execute(array($name, $note, $id));
    $typesCount =  $stmt->rowCount();       // count effected rows
    // return result
    return $typesCount > 0 ? true : false;
  }

  // delete type
  public function delete_conn_type($id)
  {
    // // delete query
    // $deleteQuery = "DELETE FROM `connection_types` WHERE `id` = ?";
    // $stmt = $this->con->prepare($deleteQuery);
    // $stmt->execute(array($id));
    // $typesCount =  $stmt->rowCount();       // count effected rows
    // // return result
    // return $typesCount > 0 ? true : false;
    return false;
  }
}
