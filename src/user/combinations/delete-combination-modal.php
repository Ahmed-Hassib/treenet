<!-- Modal -->
<div class="modal fade" id="deleteCombModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo lang('DELETE COMB', $lang_file) ?></h5>
      </div>
      <div class="modal-body">
        <h5 class="h5"><?php echo lang('CONFIRM DELETE' ,$lang_file) ?>&nbsp;<span class="text-danger" id="deleted-piece-name"></span>&nbsp;<?php echo @$_SESSION['sys']['lang'] == "ar" ? "؟" : "?" ?></h5>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <a class="btn btn-danger text-capitalize fs-12" id="confirm-delete-combination"><i class="bi bi-trash"></i>&nbsp;<?php echo lang('DELETE') ?></a>
        <?php } ?>
        <button type="button" class="btn btn-outline-secondary fs-12" data-bs-dismiss="modal"><?php echo lang('CLOSE') ?></button>
      </div>
    </div>
  </div>
</div>