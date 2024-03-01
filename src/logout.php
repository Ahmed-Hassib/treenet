<?php
// start output buffering
ob_start();

// start session
session_start();

// regenerate session id
session_regenerate_id();

// unset all data session
unset($_SESSION['sys']);

// check GET request
$req = isset($_GET['rt']) && !empty($_GET['rt']) ? '?rt=' . $_GET['rt'] : '';

// redirect to the login page
header("Location: ../login.php". $req);

// output flush
ob_end_flush();

// exit
exit();
?>