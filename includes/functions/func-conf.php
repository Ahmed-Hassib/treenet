<?php


// all functions to include it
$func_conf = ['functions', 'send-whatsapp-msg', 'next_ip', 'coordinates'];

// loop on page category functions
foreach ($func_conf as $key => $func_file) {
  include_once $func . "{$func_file}.php";
}
