<!-- Modal -->
<div class="modal fade" id="addNewDevCompanyModal" tabindex="-1" aria-labelledby="staticBackdropLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("ADD COMPANY", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <form action="?do=devices-companies&action=insert-man-company" method="POST" id="addManCompany"
          onchange="form_validation(this)">
          <!-- start company name -->
          <div
            class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" class="form-control" id="company-name" name="company-name"
              placeholder="<?php echo lang('COMPANY NAME', $lang_file) ?>" autocomplete="off" required />
            <label for="company-name" class="col-sm-12 col-form-label text-capitalize">
              <?php echo lang('COMPANY NAME', $lang_file) ?>
            </label>
          </div>
          <!-- end type name -->
        </form>
        <?php } else { ?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addManCompany"
            onclick="form_validation(this.form, 'submit')">
            <?php echo lang("ADD") ?>
          </button>
        <?php } ?>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal">
          <?php echo lang("CLOSE") ?>
        </button>
      </div>
    </div>
  </div>
</div>