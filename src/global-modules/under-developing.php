<div class="under-developing" dir="<?php echo $page_dir ?>">
  <!-- section title -->
  <h2>
    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
    <?php echo lang('SYS UNDER DEVELOPING') . "..." ?>
  </h2>
  <!-- refresh button -->
  <a href="" class="btn btn-primary">
    <i class="bi bi-arrow-clockwise"></i>
    <?php echo lang('REFRESH PAGE') ?>
  </a>
</div>
<?php
// prepare flash session variables
$_SESSION['flash_message'] = 'SYS UNDER DEVELOPING';
$_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'] = 'danger';
$_SESSION['flash_message_status'] = false;
$_SESSION['flash_message_lang_file'] = 'global_';
// check if posible back
$is_back = isset($_SESSION['UserID']) ? 'back' : null;
// redirect to the previous page
redirect_home(null, $is_back, 0);
