<!-- Modal -->
<div class="modal fade" id="editDirectionModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
  dir="<?php echo $page_dir ?>">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("EDIT DIR", $lang_file) ?>
        </h5>
      </div>
      <div class="modal-body">
        <form action="?do=update-direction-info" method="POST" id="editDirection" onchange="form_validation(this)">
          <!-- type id -->
          <input type="hidden" name="updated-dir-id" id="updated-dir-id">
          <!-- start old direction name -->
          <div
            class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <?php
            if (!isset($dir_obj)) {
              // create an object of Direction class
              $dir_obj = new Direction();
            }
            // get all directions 
            $directions = $dir_obj->get_all_directions(base64_decode($_SESSION['sys']['company_id']));
            $directions_info = $directions[1];
            ?>
            <select class="form-select" id="updated-dir-name" name="updated-dir-name" required>
              <option value="default" disabled selected>
                <?php echo lang('SELECT DIRECTION', $lang_file) ?>
              </option>
              <!-- loop on pieces types -->
              <?php foreach ($directions_info as $dir) { ?>
                <option value="<?php echo base64_encode($dir['direction_id']) ?>">
                  <?php echo $dir['direction_name'] ?>
                </option>
              <?php } ?>
            </select>
            <label for="updated-dir-name">
              <?php echo lang('DIRECTION', $lang_file) ?>
            </label>

          </div>
          <!-- end old direction name -->
          <!-- start direction name field -->
          <div
            class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" class="form-control" name="new-direction-name" id="new-direction-name"
              placeholder="<?php echo lang('DIR NAME', $lang_file) ?>" onblur="direction_validation(this)"
              onblur="direction_validation(this)" required>
            <label for="new-direction-name">
              <?php echo lang('DIR NAME', $lang_file) ?>
            </label>
          </div>
          <!-- end direction name field -->
        </form>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-primary py-1 fs-12" form="editDirection"
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