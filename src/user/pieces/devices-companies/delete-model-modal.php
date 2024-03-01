<!-- Modal -->
<div class="modal fade" id="deleteDeviceModel" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-model-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("DELETE MODEL INFO", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <form action="?do=devices-companies&action=delete-model&back=true" method="POST" id="delete-model">
            <input type="hidden" name="deleted-model-id" id="deleted-model-id">
            <!-- start model name -->
            <div class="mb-3">
              <h4 class="h4">
                <?php echo lang('CONFIRM DELETE') ?>&nbsp;`<span class="text-danger"
                  id="deleted-model-name"></span>`&nbsp;
                <?php echo @$_SESSION['sys']['lang'] == 'ar' ? '؟' : '?' ?>
              </h4>
            </div>
            <!-- end model name -->
          </form>
        <?php } else { ?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-danger py-1 px-5 fs-12" form="delete-model"
            onclick="form_validation(this.form, 'submit')">
            <?php echo lang("DELETE") ?>
          </button>
        <?php } ?>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal">
          <?php echo lang("CLOSE") ?>
        </button>
      </div>
    </div>
  </div>
</div>