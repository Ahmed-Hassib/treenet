<!-- Modal -->
<div class="modal fade" id="deletePieceConnTypeModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo lang("DELETE CONN", 'pcs_conn') ?></h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <form action="<?php echo $nav_up_level ?>pieces-connection/index.php?do=delete-piece-conn-type&back=true" method="POST" id="deletePieceConnType" onchange="form_validation(this)">
          <!-- type id -->
          <input type="hidden" name="deleted-conn-type-id" id="deleted-conn-type-id">
          <!-- start type name -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <?php
            $pcs_conn_obj = !isset($pcs_conn_obj) ? new PiecesConn() : $pcs_conn_obj;
            // get all connections data
            $delete_connections = $pcs_conn_obj->get_all_conn_types(base64_decode($_SESSION['sys']['company_id']));
            $delete_types_rows = $delete_connections[1];
            ?>
            <select class="form-select" id="deleted-conn-type-name" name="deleted-conn-type-name" onchange="document.getElementById('deleted-conn-type-id').value = this.value;" required>
              <option value="default" disabled selected><?php echo lang('SELECT CONN TYPE', 'pcs_conn') ?></option>
              <!-- loop on pieces types -->
              <?php foreach ($delete_types_rows as $type) { ?>
                <option value="<?php echo base64_encode($type['id']) ?>" data-note="<?php echo $type['notes'] ?>"><?php echo $type['connection_name'] ?></option>
              <?php } ?>
            </select>
            <label for="deleted-conn-type-name"><?php echo lang('CONN TYPE', 'pcs_conn') ?></label>
          </div>
          <!-- end type name -->
        </form>
        <?php } else {?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <button type="button" class="btn btn-danger py-1 fs-12" form="deletePieceConnType" onclick="form_validation(this.form, 'submit')"><i class="bi bi-trash"></i>&nbsp;<?php echo lang("DELETE") ?></button>
        <?php } ?>
        <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo lang("CLOSE") ?></button>
      </div>
    </div>
  </div>
</div>