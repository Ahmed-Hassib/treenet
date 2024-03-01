<!-- Modal -->
<div class="modal fade" id="deleteMalModal" tabindex="-1" aria-labelledby="deleteMalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel">
          <?php echo lang('confirm delete', 'malfunctions') ?>
        </h5>
      </div>
      <div class="modal-body">
        <h5 class="h5">
          <?php echo lang('CONFIRM DELETE', 'malfunctions') ?>&nbsp;<?php echo @$_SESSION['sys']['lang'] == "ar" ? "؟" : "?" ?>
        </h5>
        <p class="lead text-danger">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <?php echo lang('YOU CANNOT UNDO') ?>
        </p>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['user_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <a id="deleted-malfunction-url" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-danger text-capitalize fs-12 py-1">
            <?php echo lang('PERMANENT DELETE') ?>
            &nbsp;<i class="bi bi-trash"></i>
          </a>
        <?php } ?>
        <button type="button" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-outline-secondary fs-12 py-1" data-bs-dismiss="modal">
          <?php echo lang('CLOSE') ?>
        </button>
      </div>
    </div>
  </div>
</div>