<!-- Modal -->
<div class="modal fade" id="deleteDirectionModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
  dir="<?php echo $page_dir ?>">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("DELETE DIR", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <form action="?do=delete-direction" method="POST" id="deleteDirection">
          <!-- type id -->
          <input type="hidden" name="deleted-dir-id" id="deleted-dir-id">
          <!-- start old direction name -->
          <div
            class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <?php
            // create an object of Direction class
            $dir_obj = new Direction();
            // get all directions
            $dirs = $dir_obj->get_all_directions(base64_decode($_SESSION['sys']['company_id']));
            // data counter
            $dirs_counter = count($dirs);
            // data rows
            $dires_data = $dirs;
            ?>
            <select class="form-select" id="deleted-dir-name" name="deleted-dir-name"
              onchange="document.getElementById('deleted-dir-id').value = this.value;" required>
              <option value="default" disabled selected>
                <?php echo lang('SELECT DIRECTION', $lang_file) ?>
              </option>
              <!-- loop on pieces types -->
              <?php foreach ($dires_data as $dir) {
                // clients condition
                $clients_conditions = "WHERE `direction_id` = '" . $dir['direction_id'] . "' AND `is_client` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                // pieces condition
                $pieces_conditions = "WHERE `direction_id` = '" . $dir['direction_id'] . "' AND `is_client` = 0 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                //  unknown conditions
                $unknown_conditions = "WHERE `direction_id` = '" . $dir['direction_id'] . "' AND `is_client` NOT IN (0, 1) AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                // count pieces
                $pieces = $dir_obj->count_records("`id`", "pieces_info", $pieces_conditions);
                // count clients
                $clients = $dir_obj->count_records("`id`", "pieces_info", $clients_conditions);
                // count unknown
                $unknown = $dir_obj->count_records("`id`", "pieces_info", $unknown_conditions);
                ?>
                <?php if ($pieces == 0 && $clients == 0 && $unknown == 0) { ?>
                  <option value="<?php echo base64_encode($dir['direction_id']) ?>">
                    <?php echo $dir['direction_name'] ?>
                  </option>
                <?php } ?>
              <?php } ?>
            </select>
            <label for="deleted-dir-name">
              <?php echo lang('DIRECTION', $lang_file) ?>
            </label>

          </div>
          <!-- end old direction name -->
        </form>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-danger py-1 fs-12" form="deleteDirection"
            onclick="form_validation(this.form, 'submit')"><i class="bi bi-trash"></i>&nbsp;
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