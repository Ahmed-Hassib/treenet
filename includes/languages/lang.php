<?php
// check page type
if ($page_category == 'website') {
  // current language
  $lang = isset($_SESSION['website']['lang']) && !empty($_SESSION['website']['lang']) ? $_SESSION['website']['lang'] : 'ar';
} elseif ($page_category == 'treenet') {
  // current language
  $lang = isset($_SESSION['sys']['lang']) && !empty($_SESSION['sys']['lang']) ? $_SESSION['sys']['lang'] : 'ar';
}

// all language files
$global_lang = ['global', 'description'];

// for sys tree
$treenet_lang = [
  'user' => ['landing', 'login', 'dashboard', 'directions', 'pieces', 'comp_sugg', 'employees', 'pcs_conn', 'clients', 'malfunctions', 'combinations', 'reports', 'settings', 'payment', 'services', 'deletes', 'errors'],
  'root' => ['dashboard_root', 'companies_root']
];

// language file
$lang_files = $treenet_lang;

// loop on language files
foreach ($global_lang as $file) {
  // include file
  include_once "global/$lang/$file.php";
}

// loop on language files
foreach ($lang_files as $key => $file) {
  // check vlaue if array 
  if (gettype($file) == 'array') {
    // loop on files
    foreach ($file as $k => $f) {
      // get file name
      $lang_file_name = "{$page_category}/{$lang}/{$key}/{$f}.php";
      // include file
      include_once $lang_file_name;
    }
  } else {
    // get file name
    $lang_file_name = "{$page_category}/{$lang}/{$file}.php";
    // include file
    include_once $lang_file_name;
  }
}

// language function
function lang($phrase, $file = 'global_', $lang = "ar")
{
  // return the word
  return function_exists($file) && $file(strtoupper($phrase)) != null ? $file(strtoupper($phrase)) : $phrase;
}
