<?php

if (isset($_SESSION['sys']) || isset($_SESSION['website'])) {
  // create an object of Database class
  $db_obj = new Database();
  // get latest backup details
  $latest_backup = $db_obj->get_latest_records("*", "`backups`", "WHERE `backup_date` = '" . get_date_now() . "'", "`id`", 1);
  // check the count
  if (count($latest_backup) == 0 && empty($latest_backup)) {
    // make flag false;
    $backup_flag = false;
    // database backup file
    $db_backup_file_name = "db_backup_" . get_date_now('dmY') . ".sql";
    // get backup
    require_once $func . "autobackup.php";
  } else {
    // make flag true
    $backup_flag = true;
    // database backup file
    $db_backup_file_name = null;
  }
}
