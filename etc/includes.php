<?php

// up level
$up_level = get_up_level($level);
// nav up level
$nav_up_level = get_up_level($nav_level);

// array of used classes to include_once it

// libraries classes
$lib_classes = [
	'pChart' => [
		'content_folder' => 'class',
		'classes' => [
			'pDraw',
			'pImage',
			'pData'
		]
	]
];

// treenet classes
$treenet_classes = [
	'Database',
	'Agents',
	'Ultramsg',
	'Login',
	'User',
	'Direction',
	'Registration',
	'ManufuctureCompanies',
	'Devices',
	'Models',
	'Pieces',
	'PiecesConn',
	'Malfunction',
	'Combination',
	'Companies',
	'Session',
	'CompSugg',
	'CompSuggReplays',
	'Countries',
	'Pricing',
	'PaymentMethods',
	'Transaction',
	'Mikrotik',
	'Whatsapp',
	'SystemSettings',
	'Alerts',
	'Versions'
];

// loop on classes
foreach ($lib_classes as $key => $lib) {
	$lib_name = trim($key, "\n\r\t\v\x00"); // library name
	$classes_folder = $lib['content_folder']; // classes folder
	$classes = $lib['classes']; // classes
	// loop on classes
	foreach ($classes as $key => $class) {
		// class path
		$class_path = $up_level . "includes/libraries/$lib_name/$classes_folder/$class.class.php";
		// check if exist to include
		if (file_exists($class_path)) {
			include_once $class_path;
		}
	}
}

// loop on classes
foreach ($treenet_classes as $class) {
	// include_once classes
	include_once $up_level . "classes/$class.class.php";
}

function get_up_level($level)
{
	// get up level depebding on current level
	$up_level = $level > 0 ? str_repeat("../", $level) : "./";
	// return $up_level
	return $up_level;
}
