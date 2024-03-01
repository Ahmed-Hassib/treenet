<?php
/**
 * Direction class
 */
class Direction extends Database
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

  // get all directions
  public function get_all_directions($company)
  {
    // prepare query
    $dirQuery = "SELECT *From `direction` WHERE `company_id` = ? ORDER BY `direction_name` ASC";
    $stmt = $this->con->prepare($dirQuery); // select all users
    $stmt->execute(array($company)); // execute data
    $rows = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // assign all data to variable
    // return result
    return [$count, $rows];
  }

  // get all directions
  public function get_direction_sources($dir_id, $company_id)
  {
    // prepare query
    $dirQuery = "SELECT
        `pieces_info`.`id`,
        `pieces_info`.`full_name`,
        `pieces_info`.`ip`
    FROM
        `pieces_info`
    LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id`
    WHERE
        `pieces_info`.`direction_id` = ? AND `pieces_info`.`is_client` = 0 AND `pieces_info`.`company_id` = ?;";
    $stmt = $this->con->prepare($dirQuery); // select all users
    $stmt->execute(array($dir_id, $company_id)); // execute data
    $rows = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // assign all data to variable
    // return result
    return $count > 0 ? [$count, $rows] : [0, null];
  }

  public function get_all_dir_coordinates($dir_id, $type, $company_id)
  {
    // check direction id value
    if ($dir_id == null) {
      $dir_condition = "`pieces_info`.`is_client` = ? AND `pieces_info`.`company_id` = ?";
    } else {
      $dir_condition = "`pieces_info`.`direction_id` = ? AND `pieces_info`.`is_client` = ? AND `pieces_info`.`company_id` = ?";
    }
    // direction condition
    $dir_condition =
      // prepare query
      $dir_query = "SELECT
        `pieces_info`.`id`,
        `pieces_info`.`ip`,
        `pieces_info`.`full_name`,
        `pieces_info`.`is_client`,
        `pieces_info`.`device_type`,
        `pieces_info`.`source_id`,
        `pieces_info`.`direction_id`,
        `pieces_coordinates`.`coordinates`
    FROM
        `pieces_info`
    LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id`
    LEFT JOIN `pieces_coordinates` ON `pieces_coordinates`.`id` = `pieces_info`.`id`
    WHERE {$dir_condition}";
    $stmt = $this->con->prepare($dir_query); // select all users
    $stmt->execute($dir_id != null ? array($dir_id, $type, $company_id) : array($type, $company_id)); // execute data
    $rows = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // assign all data to variable
    // return result
    return $count > 0 ? $rows : null;
  }
  
  public function get_all_source_pcs_coordinates($dir_id, $src, $company_id)
  {
    // prepare query
    $dir_query = "SELECT
        `pieces_info`.`id`,
        `pieces_info`.`ip`,
        `pieces_info`.`full_name`,
        `pieces_info`.`is_client`,
        `pieces_info`.`device_type`,
        `pieces_info`.`source_id`,
        `pieces_coordinates`.`coordinates`
    FROM
        `pieces_info`
    LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id`
    LEFT JOIN `pieces_coordinates` ON `pieces_coordinates`.`id` = `pieces_info`.`id`
    WHERE
        `pieces_info`.`direction_id` = ? AND `pieces_info`.`source_id` = ? AND `pieces_info`.`company_id` = ?;";
    $stmt = $this->con->prepare($dir_query); // select all users
    $stmt->execute(array($dir_id, $src, $company_id)); // execute data
    $rows = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // assign all data to variable
    // return result
    return $count > 0 ? $rows : null;
  }

  // insert a new direction
  public function insert_new_direction($info)
  {
    // insert query
    $insertDirQuery = "INSERT INTO `direction` (`direction_name`, `added_date`, `added_by`, `company_id`) VALUES (?, ?, ?, ?);";
    $stmt = $this->con->prepare($insertDirQuery);
    $stmt->execute($info);
    $count = $stmt->rowCount(); // assign all data to variable
    // return result
    return $count > 0 ? true : false;
  }

  // update direction info
  public function update_direction($name, $id)
  {
    // insert query
    $updateDirQuery = "UPDATE `direction` SET `direction_name` = ? WHERE `direction_id` = ?;";
    $stmt = $this->con->prepare($updateDirQuery);
    $stmt->execute(array($name, $id));
    $count = $stmt->rowCount(); // assign all data to variable
    // return result
    return $count > 0 ? true : false;
  }

  // delete direction info
  public function delete_direction($id)
  {
    // // insert query
    // $deleteQuery = "DELETE FROM `direction` WHERE `direction_id` = ?";
    // $stmt = $this->con->prepare($deleteQuery);
    // $stmt->execute(array($id));
    // $count = $stmt->rowCount(); // assign all data to variable
    // // return result
    // return $count > 0 ? true : false;
    return false;  
  }

  // search for employee
  public function search($search_stmt, $company_id)
  {
    // activate phone query
    $search_query = "SELECT *FROM `direction` WHERE `direction_name` LIKE '%{$search_stmt}%' AND `company_id` = ?;";
    // prepare statement
    $stmt = $this->con->prepare($search_query);
    $stmt->execute(array($company_id));
    $count = $stmt->rowCount(); // get number of effected rows
    $serach_res = $stmt->fetchAll(); // all count of data
    // empty response
    $response = [];
    // loop on result
    foreach ($serach_res as $key => $search) {
      // extract
      extract($search);
      // prepare response
      $response[] = [
          'direction_id' => $direction_id,
          'direction_name' => $direction_name,
          'added_date' => $added_date,
        ];
    }

    // return
    return $count > 0 ?  $response : null;
  }
}
