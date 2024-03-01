<!-- Modal -->
<div class="modal fade" id="editPieceConnTypeModal" tabindex="-1" aria-labelledby="staticBackdropLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("EDIT CONN", 'pcs_conn') ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <form action="<?php echo $nav_up_level ?>pieces-connection/index.php?do=update-piece-conn-type" method="POST"
            id="editPieceConnType" onchange="form_validation(this)">
            <!-- type id -->
            <input type="hidden" name="updated-conn-type-id" id="updated-conn-type-id">
            <!-- start type name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <?php
              $pcs_conn_obj = !isset($pcs_conn_obj) ? new PiecesConn() : $pcs_conn_obj;
              // get all connections data
              $edit_connections = $pcs_conn_obj->get_all_conn_types(base64_decode($_SESSION['sys']['company_id']));
              $edit_types_rows = $edit_connections[1];
              ?>
              <select class="form-select" id="old-conn-type-name" name="old-conn-type-name"
                onchange="document.getElementById('updated-conn-type-id').value = this.value; document.getElementById('new-conn-type-note').value = this[this.selectedIndex].dataset.note;"
                required>
                <option value="default" disabled selected>
                  <?php echo lang('SELECT CONN TYPE', 'pcs_conn') ?>
                </option>
                <!-- loop on pieces types -->
                <?php foreach ($edit_types_rows as $type) { ?>
                  <option value="<?php echo base64_encode($type['id']) ?>" data-note="<?php echo $type['notes'] ?>">
                    <?php echo $type['connection_name'] ?>
                  </option>
                <?php } ?>
              </select>
              <label for="old-conn-type-name">
                <?php echo lang('OLD NAME', 'pcs_conn') ?>
              </label>
            </div>
            <!-- end type name -->
            <!-- start type name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="new-conn-type-name" name="new-conn-type-name"
                placeholder="<?php echo lang('NEW NAME', 'pcs_conn') ?>" autocomplete="off" required />
              <label for="new-conn-type-name">
                <?php echo lang('NEW NAME', 'pcs_conn') ?>
              </label>
            </div>
            <!-- end type name -->
            <!-- start type note -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <textarea class="form-control" style="resize: none; width: 100%; height: 120px;" id="new-conn-type-note"
                name="new-conn-type-note" placeholder="<?php echo lang('NOTE') ?>" rows="5" cols="5"></textarea>
              <label for="new-conn-type-note">
                <?php echo lang('NOTE') ?>
              </label>
            </div>
            <!-- end type note -->
          </form>
        <?php } else { ?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-primary py-1 fs-12" form="editPieceConnType"
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