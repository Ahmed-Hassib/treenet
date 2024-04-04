<?php
// create an object of Versions class
$version_obj = new Versions();
// get current version info
$latest_version = $version_obj->get_latest_version();
// get current version id
$sys_curr_version_id = $latest_version['v_id'];
// get current version name
$sys_curr_version_name = $latest_version['v_name'];
