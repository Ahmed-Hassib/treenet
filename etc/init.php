<?php
// include_once navbar in all pages expect pages include_once noNavBar
if (isset($page_category) && !isset($no_navbar)) {
  // check backup
  include_once 'auto-backup.php';

  // include_once check version script
  include_once 'check-version.php';
  // check page role
  if ($page_role == 'treenet_landing') {
    // get user navbar
    $navbar = get_page_dependencies("treenet_global", 'navbar')['landing'];
    $tpl_type = "user_tpl";
    // check session
  } elseif (isset($_SESSION['sys']['UserID'])) {
    // check if root
    if ($_SESSION['sys']['is_root'] == 1) {
      // get root navbar
      $navbar = get_page_dependencies("treenet_global", 'navbar')['root'];
      $tpl_type = "root_tpl";
    } else {
      // check developing
      if ($is_developing == false) {
        // get user navbar
        $navbar = get_page_dependencies("treenet_global", 'navbar')['user'];
        $tpl_type = "user_tpl";
      }
    }
  }

  // check if navbar was set
  if (isset($navbar)) {
    // include navbar
    include_once $$tpl_type . $navbar;
  }
}
?>

<?php if ($is_developing == false || (isset($_SESSION['sys']['username']) && $_SESSION['sys']['is_root'])) { ?>
  <?php if (isset($_SESSION['flash_message']) && isset($_SESSION['flash_message_icon']) && isset($_SESSION['flash_message_class']) && isset($_SESSION['flash_message_status'])) { ?>
    <div class="m-0 container">
      <div class="alert-flash-container alert-flash-<?php echo $page_category != 'treenet' ? 'web' : 'sys' ?>" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <?php if (is_array($_SESSION['flash_message'])) { ?>
          <?php foreach ($_SESSION['flash_message'] as $key => $message) { ?>
            <div class="alert alert-<?php echo $_SESSION['flash_message_class'][$key]; ?> alert-flash-status" dir="rtl">
              <i class="bi <?php echo $_SESSION['flash_message_icon'][$key] ?>"></i>
              <?php echo lang($message, $_SESSION['flash_message_lang_file'][$key]) ?>
              <button type="button" class="btn-close btn-close-left" data-bs-dismiss="alert" aria-label="Close"></button>
              <span class="alert-progress"></span>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="alert alert-<?php echo $_SESSION['flash_message_class']; ?> alert-flash-status" dir="rtl">
            <i class="bi <?php echo $_SESSION['flash_message_icon'] ?>"></i>
            <?php echo lang($_SESSION['flash_message'], $_SESSION['flash_message_lang_file']) ?>
            <button type="button" class="btn-close btn-close-left" data-bs-dismiss="alert" aria-label="Close"></button>
            <span class="alert-progress"></span>
          </div>
        <?php } ?>
      </div>
    </div>

    <script>
      let wait = 1000;
      let progress = 100;
      let flash_alert = document.querySelectorAll('.alert-flash-status');
      var alert_progress_el = document.querySelectorAll('.alert-progress');

      let alert_progress = setInterval(() => {
        // decrease progress
        progress--;
        // decrease width depending on progress
        alert_progress_el.forEach(prog => {
          prog.style.width = `${progress}%`;
        });
        // check progress
        if (progress == 0) clearInterval(alert_progress);
      }, 100);


      setTimeout(() => {
        flash_alert.forEach(alert => {
          alert.remove();
        });
      }, 16300);
    </script>

    <?php unset($_SESSION['flash_message']); ?>
    <?php unset($_SESSION['flash_message_icon']); ?>
    <?php unset($_SESSION['flash_message_class']); ?>
    <?php unset($_SESSION['flash_message_status']); ?>
    <?php unset($_SESSION['flash_message_lang_file']); ?>
  <?php } ?>
<?php } ?>