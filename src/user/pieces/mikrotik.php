<?php
if (isset($_SESSION['sys']['UserID'])) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get data
    $id = isset($_POST['id']) && !empty($_POST['id']) ? base64_decode($_POST['id']) : null;
    $ip = isset($_POST['ip']) && !empty($_POST['ip']) ? trim($_POST['ip'], "\n\r\t\v\x") : null; // target ip
    $port = isset($_POST['port']) && !empty($_POST['port']) ? trim($_POST['port'], "\n\r\t\v\x") : null; // target port
  } else {
    // get data
    $id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;
    $ip = isset($_GET['ip']) && !empty($_GET['ip']) ? trim($_GET['ip'], "\n\r\t\v\x") : null; // target ip
    $port = isset($_GET['port']) && !empty($_GET['port']) ? trim($_GET['port'], "\n\r\t\v\x") : null; // target port
  }

  // company name
  $company_name = str_replace_whitespace($_SESSION['sys']['company_name']);

  // empty array for errors
  $errors = array();

  // check ip
  if ($ip == null || empty($ip)) {
    $errors[] = 'ip null';
  }

  // check port
  if ($port == null || empty($port)) {
    $errors[] = 'port null';
  }

  // check if array of erros is empty or not
  if (empty($errors)) {
    // create an object of Pieces class
    $pcs_obj = new Pieces();
    // create an object of Company class
    $company_obj = new Company();
    // check number of opened port from database
    $opened_ports = intval($pcs_obj->select_specific_column("`opened_ports`", "`companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']))['opened_ports']);
    // check number of opened ports
    if ($opened_ports >= $conf['available_ports']) {
      // reset opened ports
      $opened_ports = 1;
    } else {
      // increase opened ports
      $opened_ports += 1;
    }

    // update number of opened port in database
    $company_obj->update_opened_ports(base64_decode($_SESSION['sys']['company_id']), $opened_ports);
    // get refused ports
    $refused_ports = $company_obj->select_specific_column("`refused_port`", "`settings`", "LIMIT 1")['refused_port'];
    $refused_ports = explode(",", $refused_ports);

    do {
      // get next port
      $next_port = intval($_SESSION['sys']['mikrotik']['company_port']) + $opened_ports;
    } while (in_array($next_port, $refused_ports));

    // echo "opened port => {$opened_ports} & next port => {$next_port}<br>";

    // create an object of RouterosAPI
    $api_opj = new RouterosAPI();

    // connect to mikrotik api
    if ($api_obj->connect($_SESSION['sys']['mikrotik']['remote_ip'], $_SESSION['sys']['mikrotik']['username'], $_SESSION['sys']['mikrotik']['password'])) {
      // get user_roles
      $user_roles = $api_obj->comm(
        "/ip/firewall/nat/print",
        array(
          "?comment" => "mohamady",
          "?disabled" => "false"
        )
      );

      // check count of roles
      if (empty($user_roles) || count($user_roles) < $conf['available_ports']) {
        // create a new role
        $new_role = $api_obj->comm(
          "/ip/firewall/nat/add",
          array(
            "action" => "dst-nat",
            "chain" => "dstnat",
            "comment" => "mohamady",
            "dst-port" => "{$next_port}",
            "in-interface" => $company_name . '-eoip',
            "protocol" => "tcp",
            "to-addresses" => "{$ip}",
            "to-ports" => "{$port}",
            "disabled" => "false"
          )
        );
      } else {
        // target id
        $id = $user_roles[$opened_ports - 1]['.id'];
        // change ir in api
        $update_role = $api_obj->comm(
          "/ip/firewall/nat/set",
          array(
            "numbers" => $id,
            "to-ports" => $port,
            "to-addresses" => $ip,
          )
        );
      }

      // create new object
      $api_server_obj = new RouterosAPI();
      // $api_server_obj->debug = true;
      // connect to server 
      $api_server_obj->connect($conf['mikrotik']['ip'], $conf['mikrotik']['username'], $conf['mikrotik']['password']);
      // get server users
      $server_roles = $api_server_obj->comm(
        "/ip/firewall/nat/print",
        array(
          "?comment" => "{$company_name}",
          "?disabled" => "false"
        )
      );

      if (empty($server_roles) || count($server_roles) < $conf['available_ports']) {
        // create a new role
        $server_new_role = $api_server_obj->comm(
          "/ip/firewall/nat/add",
          array(
            "action" => "dst-nat",
            "chain" => "dstnat",
            "comment" => "{$company_name}",
            "dst-port" => $next_port,
            "in-interface" => "ether1",
            "protocol" => "tcp",
            "to-addresses" => $_SESSION['sys']['mikrotik']['remote_ip'],
            "to-ports" => $next_port,
            "disabled" => "false"
          )
        );
      } else {
        // get id
        $id = $server_roles[$opened_ports - 1]['.id'];
        // change ir in api
        $server_update_role = $api_server_obj->comm(
          "/ip/firewall/nat/set",
          array(
            "numbers" => $id,
            "to-ports" => $next_port,
            "to-addresses" => $_SESSION['sys']['remote_ip'],
          )
        );
      }

      // protocol
      $protocol = $port == 80 ? 'http' : 'https';
      // url
      $url = "{$protocol}://leadergroupegypt.com:{$next_port}/";

      echo "<div dir='ltr'>";
      // target link
      echo "If your browser does not support automatic redirection <a href='$url'>click here</a><br>";
      echo "</div>";
      // redirect page to url to open device
      header("refresh:2;url=$url");
      die;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'MIKROTIK FAILED';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = 'global_';
      // redirect to the previous page
      redirect_home(null, "back", 0);
    }
  } else {
    foreach ($errors as $key => $error) {
      // prepare flash session variables
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
    // redirect to the previous page
    redirect_home(null, "back", 0);
  }
} else {
  // include page error module
  include_once $globmod . "permission-error.php";
}