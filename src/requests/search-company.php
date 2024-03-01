<?php
// company name
$company_name = isset($_GET['company-name']) ? $_GET['company-name'] : '';
// update cliet name with %
// $company_name = '%'.$company_name.'%';
// query statement
$query = "SELECT `company_id` FROM `companies` WHERE `company_name` LIKE ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(array($company_name));
// get all rows
$result = $stmt->fetchAll();
// send the result as a json formate
echo json_encode($result);