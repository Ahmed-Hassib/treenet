<?php

/**
 * countries class
 */
class Countries extends Database
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

  // get all countries
  public function get_all_countries()
  {
    // prepare query
    $countries_query = "SELECT *From `countries`";
    $stmt = $this->con->prepare($countries_query); // select all users
    $stmt->execute(); // execute data
    $countries_data = $stmt->fetchAll(); // assign all data to variable
    $countries_count = $stmt->rowCount(); // assign all data to variable

    // an empty result
    $res = [];
    // check count
    if ($countries_count > 0) {
      foreach ($countries_data as $key => $country) {
        extract($country);
        $res[] = [
          'country_id' => $country_id,
          'country_name_ar' => $country_name_ar,
          'country_name_en' => $country_name_en,
          'flag' => $flag,
        ];
      }
      // return result
      return $res;
    }
    // return null
    return null;
  }

  // get country data
  public function get_country($id)
  {
    // prepare query
    $country_query = "SELECT *From `countries` WHERE `country_id` = ? LIMIT 1";
    $stmt = $this->con->prepare($country_query); // select all users
    $stmt->execute(array($id)); // execute data
    $country_data = $stmt->fetch(); // assign all data to variable
    $country_count = $stmt->rowCount(); // assign all data to variable

    // check count
    if ($country_count > 0) {
      extract($country_data);
      return [
        'country_id' => $country_id,
        'country_name_ar' => $country_name_ar,
        'country_name_en' => $country_name_en,
        'flag' => $flag,
      ];
    }
    // return null
    return null;
  }
}
