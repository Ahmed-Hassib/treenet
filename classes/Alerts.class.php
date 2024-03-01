<?php


class Alerts extends Database
{
  // properties
  public $con;
  // table name
  public $table_name = 'system_alerts';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
    $this->con = $db_obj->con;
  }

  // get all alerts
  public function get_all_alerts($company_id, $condition = null)
  {
    // query
    $query = "SELECT *FROM `$this->table_name` WHERE `company_id` = ? {$condition};";
    $stmt = $this->con->prepare($query);
    $stmt->execute(array($company_id));
    // get records
    $alerts = $stmt->fetchAll();
    $count = $stmt->rowCount();

    // check cout
    if ($count > 0) {
      // result
      $res = [];
      // loop on aalerts
      foreach ($alerts as $key => $alert) {
        $res[] = $this->prepare_alert_data($alert);
      }

      // return final result
      return $res;
    }
    // return null
    return null;
  }

  public function prepare_alert_data($alert_data) {
    extract($alert_data);
    return [
      'id' => $id,
      'alert_title_ar' => $alert_title_ar,
      'alert_title_en' => $alert_title_en,
      'alert_content_ar' => $alert_content_ar,
      'alert_content_en' => $alert_content_en,
      'alert_type' => $alert_type,
      'company_id' => $company_id,
      'created_at' => $created_at,
      'updated_at' => $updated_at,
      'deleted_at' => $deleted_at,
      'expire_at' => $expire_at,
    ];

  }
}
