<?php if (!isset($manufacture_companies)) {
  // create an object of Database class
  $dev_comp_obj = !isset($dev_comp_obj) ? new ManufuctureCompanies() : $dev_comp_obj;
  // get all devices companies data
  $manufacture_companies = $dev_comp_obj->get_all_man_companies(base64_decode($_SESSION['sys']['company_id']));
}
?>
<!-- Modal -->
<div class="modal fade" id="addNewDevice" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("ADD DEVICE", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <form action="?do=devices-companies&action=insert-device" method="POST" id="addDevice"
            onchange="form_validation(this)">
            <?php if (isset($dev_company_name)) { ?>
              <input type="hidden" name="company-id" id="company-id" value="<?php echo base64_encode($dev_company_id) ?>">
            <?php } ?>
            <!-- start company name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <?php if (isset($dev_company_name)) { ?>
                <input type="text" class="form-control" id="company-name" name="company-name"
                  value="<?php echo $dev_company_name ?>" autocomplete="off" required readonly />
              <?php } else { ?>
                <select class="form-select" name="company-id" id="company-id" required>
                  <?php if (count($manufacture_companies) > 0 && $manufacture_companies != null) { ?>
                    <option value="default" disabled selected>
                      <?php echo lang('SELECT MAN COMPANY', $lang_file) ?>
                    </option>
                    <?php foreach ($manufacture_companies as $company) { ?>
                      <option value="<?php echo base64_encode($company['man_company_id']) ?>">
                        <?php echo $company['man_company_name'] ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                </select>
              <?php } ?>
              <label for="<?php echo isset($dev_company_name) ? 'company-name' : 'company-id' ?>">
                <?php echo lang('COMPANY NAME', $lang_file) ?>
              </label>
              <?php if (count($manufacture_companies) == 0 && $manufacture_companies == null) { ?>
                <div id="man-company-help" class="form-text text-danger">
                  <?php echo lang('NO DATA', $lang_file) ?>
                </div>
              <?php } ?>
            </div>
            <!-- end company name -->
            <!-- start device name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="device-name" name="device-name"
                placeholder="<?php echo lang('DEVICE NAME', $lang_file) ?>" autocomplete="off" required />
              <label for="device-name">
                <?php echo lang('DEVICE NAME', $lang_file) ?>
              </label>
            </div>
            <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
              <!-- end device name -->
              <button type="button" class="btn btn-outline-success me-auto fs-12 py-1" onclick="add_model(this)"
                data-model-num="0">
                <i class="bi bi-plus"></i>
                <?php echo lang("ADD MODEL", $lang_file) ?>
              </button>
            <?php } ?>
          </form>
        <?php } else { ?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addDevice"
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