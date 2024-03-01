<?php
// get company id to delete his profile image
$company_id = base64_decode($_SESSION['sys']['company_id']);

// create an object of Company class
$company_obj = !isset($company_obj) ? new Company() : $company_obj;
// delete profile image from disk
unlink($uploads . "//companies-img/$company_id/" . $_SESSION['sys']['company_img']);
// delete profile image
echo json_encode($company_obj->delete_company_img($company_id));
