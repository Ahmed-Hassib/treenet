<!-- Modal -->
<div class="modal fade" id="editDevCompanyModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("EDIT COMPANY INFO", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <form action="?do=devices-companies&action=update-man-company" method="POST" id="edit-man-company"
            onchange="form_validation(this)">
            <input type="hidden" name="updated-company-id" id="updated-company-id">
            <!-- start company name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="old-company-name" name="old-company-name" autocomplete="off"
                placeholder="<?php echo lang('OLD COMPANY NAME', $lang_file) ?>" required readonly />
              <label for="old-company-name">
                <?php echo lang('OLD COMPANY NAME', $lang_file) ?>
              </label>
            </div>
            <!-- end company name -->
            <!-- start company name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="new-company-name" name="new-company-name"
                placeholder="<?php echo lang('NEW COMPANY NAME', $lang_file) ?>" autocomplete="off" required />
              <label for="new-company-name">
                <?php echo lang('NEW COMPANY NAME', $lang_file) ?>
              </label>
            </div>
            <!-- end company name -->
          </form>
        <?php } else { ?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="edit-man-company"
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