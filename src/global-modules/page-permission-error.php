<?php
// prepare flash session variables
$_SESSION['flash_message'][0] = 'NO PAGE';
$_SESSION['flash_message_icon'][0] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'][0] = 'danger';
$_SESSION['flash_message_status'][0] = false;
$_SESSION['flash_message_lang_file'][0] = 'global_';

// prepare flash session variables
$_SESSION['flash_message'][1] = 'PERMISSION FAILED';
$_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'][1] = 'danger';
$_SESSION['flash_message_status'][1] = false;
$_SESSION['flash_message_lang_file'][1] = 'global_';

// check if posible back
$is_back = isset($_SESSION['UserID']) ? 'back' : null;
// redirect to the previous page
redirect_home(null, $is_back, 0);