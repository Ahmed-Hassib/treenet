<?php 
// get piece full name 
$mac_add = $_GET['mac_add'];
// get piece id
$id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : '';
// query statement
$add_query = "SELECT COUNT(`mac_add`) FROM `pieces_mac_addr` LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` = ? AND `pieces_info`.`company_id` = ?";
// add info
$add_info = array($mac_add, base64_decode($_SESSION['sys']['company_id']));

// edit piece query statement
$edit_query = "SELECT COUNT(`mac_add`) FROM `pieces_mac_addr` LEFT JOIN `pieces_info` ON `pieces_info`.`id` = `pieces_mac_addr`.`id` WHERE `pieces_mac_addr`.`mac_add` = ? AND `pieces_info`.`company_id` = ? AND `pieces_info`.`id` != ?";
// edit info
$edit_info = array($mac_add, base64_decode($_SESSION['sys']['company_id']), $id);
// prepare statement
$stmt = $con->prepare(empty($id) ? $add_query : $edit_query);
$stmt->execute(empty($id) ? $add_info : $edit_info);

// get all rows
$result = $stmt->fetchColumn();

$is_exist_fullname = $result > 0 ? true :false;
// send the result as a json formate
echo json_encode(array($is_exist_fullname, $result));