<?php
// redirect page
header("refresh:0;url=../../login.php?rt=" . base64_encode('root-login'));
// exit
exit();