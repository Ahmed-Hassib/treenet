<?php
// user name
$username = isset($_GET['username']) ? $_GET['username'] : '';
// query statement
$query = "SELECT `UserID` FROM `users` WHERE `username` LIKE ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($username));
// get all rows
$result = $stmt->fetchAll();
// send the result as a json formate
echo json_encode($result);