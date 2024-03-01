<!-- Modal -->
<div class="modal fade" id="editDeviceModel" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-model-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("EDIT MODEL INFO", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <form action="?do=devices-companies&action=update-model" method="POST" id="edit-model"
            onchange="form_validation(this)">
            <input type="hidden" name="model-id" id="model-id">
            <!-- start model name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="old-model-name" name="old-model-name"
                placeholder="<?php echo lang('OLD MODEL NAME', $lang_file) ?>" autocomplete="off" required readonly />
              <label for="old-model-name">
                <?php echo lang('OLD MODEL NAME', $lang_file) ?>
              </label>
            </div>
            <!-- end model name -->
            <!-- start model name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="new-model-name" name="new-model-name"
                placeholder="<?php echo lang('NEW MODEL NAME', $lang_file) ?>" autocomplete="off" required />
              <label for="new-model-name">
                <?php echo lang('NEW MODEL NAME', $lang_file) ?>
              </label>
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
          <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="edit-model"
            onclick="form_validation(this.form, 'submit')">
            <?php echo lang("SAVE") ?>
          </button>
        <?php } ?>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal">
          <?php echo lang("CLOSE") ?>
        </button>
      </div>
    </div>
  </div>
</div>