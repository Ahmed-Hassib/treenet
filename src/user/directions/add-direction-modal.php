<!-- Modal -->
<div class="modal fade" id="addNewDirectionModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"
  dir="<?php echo $page_dir ?>">
  <div class="modal-dialog modal-dialog-centered modal-type-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="m-auto modal-title h5 " id="staticBackdropLabel">
          <?php echo lang("ADD NEW", 'directions') ?>
        </h5>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <!-- start add new user form -->
          <form action="<?php echo $treenet_user ?>directions/index.php?do=insert-new-direction" method="POST"
            id="addNewDirection" onchange="form_validation(this)">
            <!-- start direction name field -->
            <div
              class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" name="direction-name" id="direction-name"
                placeholder="<?php echo lang('DIR NAME', 'directions') ?>" onblur="direction_validation(this)" required>
              <label for="direction-name">
                <?php echo lang('DIR NAME', 'directions') ?>
              </label>
            </div>
            <!-- end direction name field -->
          </form>
        <?php } else { ?>
          <p class="lead text-danger">
            <?php echo lang('FEATURE NOT AVAILABLE') ?>
          </p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="addNewDirection"
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