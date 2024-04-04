<?php
// check the request post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get company id
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  // company name
  $company_name = str_replace_whitespace($_SESSION['sys']['company_name']);
  // create an object of Company class
  $company_obj = new Company();
  // create an object of Mikrotik class
  $mikrotik_obj = new Mikrotik();


  // array of errors
  $err_arr = array();

  // get mikrotik data
  $ip = isset($_POST['mikrotik-ip']) && !empty($_POST['mikrotik-ip']) ? $_POST['mikrotik-ip'] : null;
  $port = isset($_POST['mikrotik-port']) && !empty($_POST['mikrotik-port']) ? $_POST['mikrotik-port'] : "";
  $username = isset($_POST['mikrotik-username']) && !empty($_POST['mikrotik-username']) ? $_POST['mikrotik-username'] : null;
  $password = isset($_POST['mikrotik-password']) && !empty($_POST['mikrotik-password']) ? $_POST['mikrotik-password'] : null;
  $status = 1;

  // ip validation
  if ($ip == null) {
    $err_arr[] = 'ip empty';
  }

  // username validation
  if ($username == null) {
    $err_arr[] = 'username empty';
  }

  // password validation
  if ($password == null) {
    $err_arr[] = 'password empty';
  }

  // create a new object of mikrotik api
  $mikrotik_api_obj = new RouterosAPI();

  // connect to cloud server of mikrotik
  if (!$mikrotik_api_obj->connect($conf['mikrotik']['ip'], $conf['mikrotik']['username'], $conf['mikrotik']['password'])) {
    $errors[] = 'process error';
  }

  if (empty($err_arr)) {
    // check if company has a mikrotik info in database
    $is_exist_data = $mikrotik_obj->is_exist("`company_id`", "`mikrotik_settings`", $company_id);

    echo $is_exist_data;
    // check if exists
    if ($is_exist_data) {
      // call function to update info
      $is_updated = $mikrotik_obj->update_mikrotik_info(array($ip, $port, $username, $password, $status, $company_id));
    } else {
      // insert new values
      // call function to update info
      $is_updated = $mikrotik_obj->insert_mikrotik_info(array($company_id, $ip, $port, $username, $password, $status));
    }

    // check if changed
    if ($is_updated) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'MIKROTIK UPDATED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = 'services';

      // log message
      $log_msg = "mikrotik info was updated successfully by " . $_SESSION['sys']['username'] . " at " . date('D d/m/Y h:i a');

      // create an object of Session class
      $session_obj = new Session();
      // set user session
      $session_obj->update_session(base64_decode($_SESSION['sys']['UserID']));

      // craeet an object of Database class
      $db_obj = new Database("localhost", "jsl_db");

      $next_ip = $db_obj->select_specific_column("`next_remote_ip`", "`settings`", "LIMIT 1")[0]["next_remote_ip"];
      $is_exist_remote_ip = $db_obj->is_exist("`remote_ip`", "`companies`", "{$next_ip}");
      $is_exist_company_remote_ip = $company_obj->get_remote_ip("{$company_id}");

      if (!empty($is_exist_company_remote_ip)) {
        $remote_ip = $is_exist_company_remote_ip;
      } else {
        if ($is_exist_remote_ip == true) {
          $remote_ip = get_next_ip($next_ip);
          $db_obj->set_next_remote_ip($remote_ip);
        } else {
          $remote_ip = $next_ip;
        }
      }
      $company_obj->set_remote_ip($company_id, $remote_ip);

      $next_ip_list = $db_obj->select_specific_column("`next_ip_list`", "`settings`", "LIMIT 1")[0]["next_ip_list"];
      $is_exist_ip_list = $db_obj->is_exist("`ip_list`", "`companies`", "{$next_ip_list}");
      $is_exist_company_ip_list = $company_obj->get_ip_list("{$company_id}");

      if (!empty($is_exist_company_ip_list)) {
        $ip_list = $is_exist_company_ip_list;
      } else {
        if ($is_exist_ip_list == true) {
          $ip_list = get_next_2_ip($next_ip_list);
          $db_obj->set_next_ip_list($ip_list);
        } else {
          $ip_list = $next_ip_list;
        }
      }

      $company_obj->set_ip_list($company_id, $ip_list);

      // set user session
      $session_obj->update_session(base64_decode($_SESSION['sys']['UserID']));
      
      // create a secret role in ppp
      $mikrotik_api_obj->comm("/ppp/secret/add", [
        "name" => $company_name,
        "password" => $_SESSION["sys"]["mikrotik"]["password"],
        "service" => "any",
        "remote-address" => $remote_ip,
      ]);
      // create a sstp server
      $mikrotik_api_obj->comm("/interface/sstp-server/add", array(
        "user" => $company_name,
        "name" => $company_name,
      ));

      // create a eoip
      $mikrotik_api_obj->comm("/interface/eoip/add", array(
        "name" => $company_name . '-eoip',
        "local-address" => "199.198.197.1",
        "remote-address" => $remote_ip,
        "tunnel-id" => intval($company_id) + 1200,
        "disabled" => "no"
      ));

      // // create a bridge
      // $mikrotik_api_obj->comm("/interface/bridge/add", array(
      //   "name" => "Bridge-{$company_id}"
      // ));

      // create a bridge port
      $mikrotik_api_obj->comm("/interface/bridge/port/add", array(
        "bridge" => "bridge1",
        "interface" => $company_name . '-eoip'
      ));

      $back_url = '?msg=mikrotik-ok';
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'NO CHANGES';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'info';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
      // log message
      $log_msg = "there is no data was added to update mikrotik info";
      $back_url = 'back';
    }
  } else {
    // prepare flash session variables
    foreach ($err_arr as $key => $err) {
      $_SESSION['flash_message'][$key] = strtoupper($err);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
    // log message
    $log_msg = "mikrotik was not updated because there is a problem while updating it";
    $back_url = 'back';
  }
  // create a log
  create_logs($_SESSION['sys']['username'], $log_msg);
  // redirect home
  redirect_home(null, $back_url, 0);
} else {
  // include_once per
  include_once $globmod . 'permission-error.php';
}
