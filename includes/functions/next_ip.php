<?php
function get_next_ip($ip)
{
  if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    return long2ip(ip2long($ip) + 1);
  }
  return false; // invalid IP address
}


function get_next_2_ip($ip)
{
  if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    $ip_long = ip2long($ip);
    $new_ip_long = $ip_long + 3;
    $new_ip_address = long2ip($new_ip_long);
    return $new_ip_address;
  }
  return false;
}