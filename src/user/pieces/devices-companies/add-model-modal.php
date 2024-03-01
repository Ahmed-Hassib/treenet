<!-- Modal -->
<div class="modal fade" id="addNewDeviceModel" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-company-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("ADD MODEL", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <form action="?do=devices-companies&action=insert-model" method="POST" id="addDeviceModelForm"
            onchange="form_validation(this)">
            <input type="hidden" name="device-id" id="device-id" value="<?php echo base64_encode($device_id) ?>">
            <!-- button to add a model field -->
            <button type="button" class="btn btn-outline-success me-auto fs-12 py-1" onclick="add_model(this)"
              data-model-num="0">
              <i class="bi bi-plus"></i>
              <?php echo lang("ADD MODEL", $lang_file) ?>
            </button>
          </form>
        <?php } else { ?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addDeviceModelForm"
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