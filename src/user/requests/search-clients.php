<?php
// get client name
$client_name = $_GET['client-name'];
// company id
$company_id = base64_decode($_SESSION['sys']['company_id']);
// update cliet name with %
$client_name = '%'.$client_name.'%';
// query statement
$query = "SELECT `id`, `full_name` FROM `pieces_info` WHERE `full_name` LIKE ? AND `company_id` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($client_name, $company_id));
// get all rows
$result = $stmt->fetchAll();
// send the result as a json formate
echo json_encode($result);