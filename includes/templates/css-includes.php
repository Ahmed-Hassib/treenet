<!-- GET ALL GLOBAL FILES -->
<?php $global_fonts_files = get_page_dependencies('global', 'fonts'); ?>
<?php $global_css_files = get_page_dependencies('global', 'css'); ?>
<?php $global_css_node_files = get_page_dependencies('global', 'node')['css']; ?>

<?php if ($global_fonts_files != null) { ?>
  <!-- GLOBAL FONTS FILES -->
  <?php foreach ($global_fonts_files as $fonts_files) { ?>
    <link rel="stylesheet" href="<?php echo $fonts . $fonts_files; ?>">
  <?php } ?>
<?php } ?>

<?php if ($global_css_files != null) { ?>
  <!-- GLOBAL CSS FILES -->
  <?php foreach ($global_css_files as $global_css_file) { ?>
    <link rel="stylesheet" href="<?php echo $css . $global_css_file; ?>">
  <?php } ?>
<?php } ?>

<?php if ($global_css_node_files != null) { ?>
  <!-- GLOBAL NODE CSS FILES -->
  <?php foreach ($global_css_node_files as $global_node_css_file) { ?>
    <link rel="stylesheet" href="<?php echo $node . $global_node_css_file; ?>">
  <?php } ?>
<?php } ?>

<?php if (isset($is_contain_table) && $is_contain_table == true) { ?>
  <!-- GET ALL CSS TABLES STYLE -->
  <?php $tables_css_files = get_page_dependencies('tables', 'css') ?>
  <?php foreach ($tables_css_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $css . $css_file; ?>">
  <?php } ?>

  <!-- GET ALL CSS TABLES STYLE -->
  <?php $tables_css_node_files = get_page_dependencies('tables', 'node')['css'] ?>
  <?php foreach ($tables_css_node_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $node . $css_file; ?>">
  <?php } ?>
<?php } ?>

<?php if (isset($is_contain_chart) && $is_contain_chart == true) { ?>
  <!-- GET ALL CSS CHARTS STYLE -->
  <?php $charts_css_files = get_page_dependencies('charts', 'css') ?>
  <?php foreach ($charts_css_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $css . $css_file; ?>">
  <?php } ?>

  <!-- GET ALL CSS CHARTS STYLE -->
  <?php $charts_css_node_files = get_page_dependencies('charts', 'node')['css'] ?>
  <?php foreach ($charts_css_node_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $node . $css_file; ?>">
  <?php } ?>

  <!-- GET ALL CHART CUSTOM JS FILES -->
  <?php $chart_js_files = get_page_dependencies('charts', 'js'); ?>
  <!-- GET ALL CHARTS NODE JS FILES -->
  <?php $charts_node_js_files = get_page_dependencies('charts', 'node')['js']; ?>

  <!-- INCLUDE ALL CHARTS NODE JS FILES -->
  <?php foreach ($charts_node_js_files as $charts_node_js_file) { ?>
    <script type="text/javascript" src="<?php echo $node . $charts_node_js_file; ?>" defer></script>
  <?php } ?>

  <!-- INCLUDE ALL CHART CUSTOM JS FILES -->
  <?php foreach ($chart_js_files as $chart_js_file) { ?>
    <script type="text/javascript" src="<?php echo $js . $chart_js_file; ?>" defer></script>
  <?php } ?>
<?php } ?>


<!-- GET ALL GLOBAL CSS FILES DEPENDING ON PAGE CATEGORY -->
<?php $global_web_css_files = get_page_dependencies("treenet_global", 'css'); ?>

<?php if ($global_web_css_files != null) { ?>
  <?php foreach ($global_web_css_files as $css_file) { ?>
    <link rel="stylesheet" href="<?php echo $css . $css_file; ?>">
  <?php } ?>
<?php } ?>

<?php if (isset($page_role)) { ?>
  <!-- GET ALL CSS FILES DEPENDING ON PAGE ROLE IN CURRENT CATEGORY -->
  <?php $page_role_css_file = get_page_dependencies($page_role, 'css'); ?>

  <?php if ($page_role_css_file != null) { ?>
    <?php foreach ($page_role_css_file as $css_file) { ?>
      <link rel="stylesheet" href="<?php echo $css . $css_file; ?>">
    <?php } ?>
  <?php } ?>
<?php } ?>

<?php if (isset($is_contain_map) && $is_contain_map) { ?>
  <!-- GET ALL JS FILES DEPENDING ON MAP IN CURRENT CATEGORY -->
  <?php $map_js_files = get_page_dependencies('treenet_map', 'js'); ?>

  <?php if ($map_js_files != null) { ?>
    <?php foreach ($map_js_files as $js_file) { ?>
      <script type="text/javascript" src="<?php echo $js . $js_file; ?>" defer></script>
    <?php } ?>
  <?php } ?>
<?php } ?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="<?php echo $node ?>jquery/dist/jquery.min.js"></script>



<!-- PAGE ICON -->
<link rel="icon" href="<?php echo $treenet_assets ?>resized/treenet.png">