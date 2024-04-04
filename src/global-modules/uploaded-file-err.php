<?php
// prepare flash session variables
$_SESSION['flash_message'] = 'file err';
$_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'] = 'danger';
$_SESSION['flash_message_status'] = false;
$_SESSION['flash_message_lang_file'] = 'global_';
// redirect to the previous page
redirect_home(null, 'back', 0);
