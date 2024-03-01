<?php

// get data
$address = isset($_GET['address']) && !empty($_GET['address']) ? $_GET['address'] : -1; // target ip
$port = isset($_GET['port']) && !empty($_GET['port']) ? $_GET['port'] : 443; // target port

// get users
$users = $api_obj->comm("/ip/firewall/nat/print", array(
  "?comment" => "mohamady",
  "?disabled" => "false"
)
);

// empty array for errors
$errors = array();

// check id
if ($id == -1 || empty($id)) {
  $errors[] = 'id cannot be empty';
}

// check address
if ($address == -1 || empty($address)) {
  $errors[] = 'ip address cannot be empty';
}

// check port
if ($port == -1 || empty($port)) {
  $errors[] = 'port cannot be empty';
}

// check if array of erros is empty or not
if (empty($errors)) {
  // change ir in api
  $users = $API->comm(
    "/ip/firewall/nat/set",
    array(
      "numbers" => $id,
      "to-ports" => $port,
      "to-addresses" => $address,
    )
  );

  // redirect page to url to open device
  header("refresh:0;url=leadergroupegypt.com:5002");
  die;
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