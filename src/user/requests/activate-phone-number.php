<?php
require_once($vendor . 'ultramsg/whatsapp-php-sdk/ultramsg.class.php');
// mobile phone
$phone_number = '+2'.$_SESSION['sys']['phone'];
// $phone_number = '+201028680375';
// activation code
$activation_code = random_digits(4);
// message body
$msg_body  = lang('HI', @$_SESSION['sys']['lang']) . ' ' . $_SESSION['sys']['username'] . ' ';
$msg_body .= lang('SYS TREE APP TEAM GREATE YOU', @$_SESSION['sys']['lang']) . '. ';
$msg_body .= lang('YOUR ACTIVATION CODE IS', @$_SESSION['sys']['lang']) . ' ';
$msg_body .= " _*$activation_code*_, ";
$msg_body .= lang('DON`T SHARE THE ACTIVATION CODE WITH ANY ONE ELSE', @$_SESSION['sys']['lang']) . ' ';
$msg_body .= lang('THUS', @$_SESSION['sys']['lang']) . ' ';
$msg_body .= lang('YOUR ACTIVATION CODE WILL EXPIRE WITHIN 1 MINUTE', @$_SESSION['sys']['lang']) . ' ';

// $msg_body .= lang('THE SYS TREE APP TEAM INFORMS YOU THAT THEY ARE WORKING ON A NEW ALGORITHM TO CONFIRM THE PHONE NUMBER, THIS IS A RECORDED MESAGE AND YOU WILL BE NOTIFIED BY THE APPLICATION WHEN IT IS COMPLETED. WE WISH YOU CONTINUED SUCCESS', @$_SESSION['sys']['lang']);

// api info
$ultramsg_token = "xgkn9ejfc8b9ti1a"; // Ultramsg.com token
$instance_id = "instance46427"; // Ultramsg.com instance id
$client = new WhatsAppApi($ultramsg_token, $instance_id);

// phone number
$to = $phone_number;

// send message
$api_response = $client->sendChatMessage($to, $msg_body);

// print api response
print_r($api_response);

// echo $phone_number;

?>