<?php 
// get piece full name 
$direction_name = $_GET['direction-name'];
// check id if isset
$id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : '';
// company id
$company_id = base64_decode($_SESSION['sys']['company_id']);

// create an object of Direction class
$dir_obj = new Direction();
// query statement
$query = isset($_GET['id']) && !empty($_GET['id']) ? "SELECT COUNT(`direction_id`) FROM `direction` WHERE `direction_name` = ? AND `company_id` = ? AND `direction_id` != ?"  : "SELECT COUNT(`direction_id`) FROM `direction` WHERE `direction_name` = ? AND `company_id` = ?";
// prepare statement
$stmt = $con->prepare($query);
$stmt->execute(isset($_GET['id']) && !empty($_GET['id']) ? array($direction_name, $company_id, $id) : array($direction_name, $company_id));
// get all rows
$result = $stmt->fetchColumn();

$is_exist_direction = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_direction, $result));