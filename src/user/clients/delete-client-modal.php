<!-- Modal -->
<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel">
          <?php echo lang('DELETE CLT', $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <h5 class="h5">
          <?php echo lang('CONFIRM DELETE') ?>&nbsp;<span class="text-danger" id="deleted-client-name"></span>&nbsp;
          <?php echo @$_SESSION['sys']['lang'] == "ar" ? "؟" : "?" ?>
        </h5>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['clients_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <a id="deleted-client-url" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>"
            class="btn btn-danger text-capitalize fs-12 py-1">
            <?php echo lang('DELETE') ?>&nbsp;
            <i class="bi bi-trash"></i>
          </a>
        <?php } ?>
        <button type="button" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>"
          class="btn btn-outline-secondary fs-12 py-1" data-bs-dismiss="modal">
          <?php echo lang('CLOSE') ?>
        </button>
      </div>
    </div>
  </div>
</div>