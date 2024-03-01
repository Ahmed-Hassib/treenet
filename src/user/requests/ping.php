<?php
// get ip
$ip = $_GET['ip'];
// get number of ping message
$c = isset($_GET['c']) && intval($_GET['c']) > 0 && $_GET['c'] != null ? intval($_GET['c']) : $_SESSION['sys']['ping_counter'];

// create an object of RouterosAPI class
$mikrotik_obj = new RouterosAPI();

// connect to mikrotik
if (isset($_SESSION['sys']['mikrotik']['status']) && !empty($_SESSION['sys']['mikrotik']['remote_ip']) && !empty($_SESSION['sys']['mikrotik']['username']) && !empty($_SESSION['sys']['mikrotik']['password']) && $mikrotik_obj->connect($_SESSION['sys']['mikrotik']['remote_ip'], $_SESSION['sys']['mikrotik']['username'], $_SESSION['sys']['mikrotik']['password'])) {
  // response arry
  $response = array();

  // command
  $command = "ping -c {$c} {$ip}";

  // execute command
  $mikrotik_obj->write("/ping", false);
  $mikrotik_obj->write("=address={$ip}", false);
  $mikrotik_obj->write("=count={$c}", false);
  $mikrotik_obj->write("=interval=0.1");

  $response['data'] = $mikrotik_obj->read(false);
  // push status flag
  $response['status'] = 'success';
  $response['created_at'] = Date('Y-m-d H:i:s');
  // return result
  echo json_encode($response);
} else {
  echo json_encode(
    array(
      'status' => 'failed',
      'created_at' => Date('Y-m-d H:i:s')
    )
  );
}
