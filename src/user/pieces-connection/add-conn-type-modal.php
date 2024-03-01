<!-- Modal -->
<div class="modal fade" id="addNewPieceConnTypeModal" tabindex="-1" aria-labelledby="staticBackdropLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("ADD NEW", 'pcs_conn') ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <form action="<?php echo $nav_up_level ?>pieces-connection/index.php?do=insert-piece-conn-type" method="POST"
            id="addPieceConnType" onchange="form_validation(this)">
            <!-- start connection type name -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="conn-type-name" name="conn-type-name"
                placeholder="<?php echo lang('CONN NAME', 'pcs_conn') ?>" autocomplete="off" required />
              <label for="conn-type-name">
                <?php echo lang('CONN NAME', 'pcs_conn') ?>
              </label>
            </div>
            <!-- end type name -->
            <!-- start type note -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <textarea class="form-control" style="resize: none; width: 100%; height: 120px;" id="conn-type-note"
                name="conn-type-note" placeholder="<?php echo lang('NOTE') ?>"></textarea>
              <label for="conn-type-note">
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
          <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addPieceConnType"
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