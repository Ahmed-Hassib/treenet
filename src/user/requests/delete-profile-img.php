<?php
// get user id to delete his profile image
$user_id = base64_decode($_SESSION['sys']['UserID']);

// create an object of User class
$user_obj = !isset($user_obj) ? new User() : $user_obj;
// delete profile image from disk
unlink($uploads . "//employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $_SESSION['sys']['profile_img']);
// delete profile image
echo json_encode($user_obj->delete_profile_img($user_id));
