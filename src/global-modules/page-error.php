<?php
// prepare flash session variables
$_SESSION['flash_message'] = 'NO PAGE';
$_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'] = 'danger';
$_SESSION['flash_message_status'] = false;
$_SESSION['flash_message_lang_file'] = 'global_';
// check if posible back
$is_back = (isset($_SESSION['sys']['UserID']) && isset($_GET['back'])) || (isset($_SESSION['website']['user_id']) && isset($_GET['back'])) ? 'back' : null;
// redirect to the previous page
redirect_home(null, $is_back, 0);
