<?php header('Accept-Encoding: deflate, gzip, compress, *');  // set accept encoding.?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- page title -->
  <title><?php get_page_tilte($lang_file); ?></title>
  <!-- css files -->
  <?php include_once 'css-includes.php' ?>
</head>
<body>
<?php 
// set the default timezone to use.
date_default_timezone_set('Africa/Cairo');
// check if page have a preloader variable or not
if (isset($preloader) && $preloader == true) {
  include_once 'preloader.php';
}
?>