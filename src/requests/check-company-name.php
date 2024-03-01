<?php
// user name
$name = isset($_GET['name']) && !empty($_GET['name']) ? $_GET['name'] : '';
// query statement
$query = "SELECT count(`company_id`) FROM `companies` WHERE `company_name` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($name));
// get all rows
$result = $stmt->fetchColumn();
// check result
if ($result > 0) {
  $response = [
    'status' => true,
    'message' => 'Invalid company name.'
  ];
} else {
  $response = [
    'status' => false,
    'message' => 'Valid company name.'
  ];
}
// send the result as a json formate
echo json_encode($response);