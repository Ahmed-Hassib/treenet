<?php include_once $tpl . "footer.php" ?>

<!-- GET GLOBAL JS FILES -->
<?php $global_js_files = get_page_dependencies('global', 'js'); ?>
<?php $global_node_js_files = get_page_dependencies('global', 'node')['js']; ?>

<!-- INCLUDE GLOBAL JS FILES -->
<?php foreach ($global_node_js_files as $global_node_js_file) { ?>
  <script src="<?php echo $node . $global_node_js_file; ?>" defer></script>
<?php } ?>

<!-- INCLUDE GLOBAL JS FILES -->
<?php foreach ($global_js_files as $global_js_file) { ?>
  <script src="<?php echo $js . $global_js_file; ?>" defer></script>
<?php } ?>


<!-- CHECK IF PAGE CONTAIIN TABLES -->
<?php if (isset($is_contain_table) && $is_contain_table == true) { ?>
  <!-- GET ALL TABLE CUSTOM JS FILES -->
  <?php $table_js_files = get_page_dependencies('tables', 'js'); ?>
  <!-- GET ALL TABLES NODE JS FILES -->
  <?php $tables_node_js_files = get_page_dependencies('tables', 'node')['js']; ?>

  <!-- INCLUDE ALL TABLES NODE JS FILES -->
  <?php foreach ($tables_node_js_files as $tables_node_js_file) { ?>
    <script src="<?php echo $node . $tables_node_js_file; ?>" defer></script>
  <?php } ?>

  <!-- INCLUDE ALL TABLE CUSTOM JS FILES -->
  <?php foreach ($table_js_files as $table_js_file) { ?>
    <script src="<?php echo $js . $table_js_file; ?>" defer></script>
  <?php } ?>
<?php } ?>




<!-- GET ALL GLOBAL CSS FILES DEPENDING ON PAGE CATEGORY -->
<?php $global_web_js_files = get_page_dependencies("treenet_global", 'js'); ?>

<?php foreach ($global_web_js_files as $js_file) { ?>
  <script src="<?php echo $js . $js_file; ?>" defer></script>
<?php } ?>

<?php $page_role_js_files = get_page_dependencies($page_role, 'js'); ?>
<?php if ($page_role_js_files != null) { ?>
  <?php foreach ($page_role_js_files as $js_file) { ?>
    <script src="<?php echo $js . $js_file; ?>" defer></script>
  <?php } ?>
<?php } ?>


<?php
// CHECK PAGE CATEGORY IF EQUAL 'treenet'
if (isset($_SESSION['sys']['isLicenseExpired']) && $_SESSION['sys']['isLicenseExpired'] == 0 && $is_developing == false && $page_category == 'treenet' && $page_role != 'treenet_login' && $page_role != 'treenet_signup' && isset($_SESSION['sys']['UserID']) && $_SESSION['sys']['is_root'] == 0) {
  if ($page_role != 'treenet_err' && $page_role != 'treenet_landing') {
    if ($_SESSION['sys']['dir_add'] == 1) {
      // INCLUDE ADD DIERCTION MODAL
      include_once $nav_up_level . 'directions/add-direction-modal.php';
    }

    if ($_SESSION['sys']['connection_add'] == 1) {
      // include add new connection type modal
      include_once $nav_up_level . 'pieces-connection/add-conn-type-modal.php';
    }

    // include edit connection type modal
    if (isset($conn_data_types) && $conn_data_types > 0) {
      if ($_SESSION['sys']['connection_update'] == 1) {
        include_once $nav_up_level . 'pieces-connection/edit-conn-type-modal.php';
      }

      if ($_SESSION['sys']['connection_delete'] == 1) {
        include_once $nav_up_level . 'pieces-connection/delete-conn-type-modal.php';
      }
    }
  }

  include_once $globmod . 'rating-app.php';

  echo "<script>localStorage.removeItem('sidebarMenuClosed');</script>";
}
?>

<?php if (isset($backup_flag) && $backup_flag == false && $db_backup_file_name != null && $backup_location_file != null) { ?>
  <script src="<?php echo $js ?>backup.js" defer></script>
<?php } ?>

<script>
  localStorage['lang'] = '<?php echo isset($_SESSION['sys']['lang']) ? $_SESSION['sys']['lang'] : 'ar' ?>';
</script>

<!-- save system language to local storage -->
<?php if ($page_role != 'treenet_login') { ?>
  <script>
    document.body.style.direction = '<?php echo $page_dir ?>';
  </script>
<?php } ?>

<?php if (isset($preloader) && $preloader == true) { ?>
  <script>
    $(window).on('load', function() {
      $(".preloader-container").fadeOut(1000, function() {
        $(this).parent('.preloader').fadeOut(1200, function() {
          $("body").css('overflow-x', 'visible');
        });
      });
    })
  </script>
<?php } else { ?>
  <script>
    $(window).on('load', function() {
      $("body").css('overflow-x', 'visible');
    })
  </script>
<?php } ?>


</body>

</html>

<?php
if (isset($_SESSION['request_data'])) {
  unset($_SESSION['request_data']);
}

if (isset($_SESSION['sys']['plan_id_purchase'])) {
  unset($_SESSION['plan_id_purchase']);
}
?>