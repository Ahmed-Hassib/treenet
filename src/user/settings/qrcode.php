<?php

include_once '../../../../classes/global/Ultramsg.class.php';

$whatsapp_obj = new WhatsAppApi('xgkn9ejfc8b9ti1a', '46427');

header('Content-Type: image/png');
$api = $whatsapp_obj->getInstanceQr();

echo json_encode($api);
?>