<?php
// create an object of PiecesDeletes
$pcs_del_obj = new PiecesDeletes();
// create an object of Direction
$dir_obj = new Direction();
// get id 
$id = base64_decode(trim($_GET['id'], " "));
// check if target id exists in database or not
$is_exist = $pcs_del_obj->is_exist("`id`", "`pieces_info`", $id);
// check result
if ($is_exist) {
  ?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <div class="row mb-3 justify-content-center">
      <div class="col-sm-12 col-lg-6">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize">
              <i class="bi bi-trash"></i>
              <?php echo lang('CONFIRM DELETE PIECE', $lang_file) ?>
            </h5>
            <hr>
          </header>
          <div>
            <h5 class="mb-3 h5 text-capitalize text-danger">
              <i class="bi bi-info-circle-fill"></i>
              <?php echo lang('CONFIRM DELETE PIECE NOTE', $lang_file) ?>
            </h5>

            <form class="mt-5" action="?do=delete-piece" method="post">
              <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
              <div
                class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <select class="form-select" id="direction" name="direction" required
                  onchange="get_sources(this, '<?php echo $_SESSION['sys']['company_id'] ?>', '<?php echo $dirs . $_SESSION['sys']['company_id'] ?>', ['sources']);">
                  <?php
                  // create an object of Direction class
                  $dir_obj = new Direction();
                  // get all directions
                  $dirs = $dir_obj->get_all_directions(base64_decode($_SESSION['sys']['company_id']));
                  // counter
                  $dirs_count = $dirs[0];
                  // directions data
                  $dir_data = $dirs[1];
                  // check the row dirs_count
                  if ($dirs_count > 0) { ?>
                    <option value="default" disabled selected>
                      <?php echo lang('SELECT DIRECTION', 'directions') ?>
                    </option>
                    <?php foreach ($dir_data as $dir) { ?>
                      <option value="<?php echo base64_encode($dir['direction_id']) ?>"
                        data-dir-company="<?php echo $_SESSION['sys']['company_id'] ?>">
                        <?php echo $dir['direction_name'] ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                </select>
                <label for="direction">
                  <?php echo lang('DIRECTION', 'directions') ?>
                </label>
                <?php if ($dirs_count == 0) { ?>
                  <span class="text-danger fs-12">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </div>

              <div
                class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <select class="form-select" id="sources" name="source-id" required>
                  <option value="default" selected disabled>
                    <?php echo lang('SELECT SRC', $lang_file) ?>
                  </option>
                </select>
                <label for="sources">
                  <?php echo lang('THE SRC', $lang_file) ?>
                </label>
              </div>

              <?php if ($_SESSION['sys']['pcs_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                <div class="hstack gap-3">
                  <button type="button" class="btn btn-danger me-auto" onclick="form_validation(this.form, 'submit')">
                    <i class="bi bi-trash"></i>
                    <?php echo lang('SAVE') . "&nbsp;" . lang('AND') . "&nbsp;" . lang('DELETE') ?>
                  </button>
                </div>
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else {
  // include no data founded module
  include_once $globmod . "no-data-founded.php";
}
