<?php
// user name
$username = isset($_GET['username']) ? $_GET['username'] : '';
// query statement
$query = "SELECT count(`UserID`) FROM `users` WHERE `username` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($username));
// get all rows
$result = $stmt->fetchColumn();
// check result
if ($result > 0) {
  $response = [
    'status' => true,
    'message' => 'Invalid username.'
  ];
} else {
  $response = [
    'status' => false,
    'message' => 'Valid username.'
  ];
}
// send the result as a json formate
echo json_encode($response);