<?php
// create an object of Direction class
$dir_obj = new Direction();
// get all directions
$directions = $dir_obj->get_all_directions(base64_decode($_SESSION['sys']['company_id']));
// data count
$directions_counter = !is_null($directions) ? count($directions) : 0;
// data rows
$directions_info = $directions;
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 hstack gap-3">
    <?php if ($_SESSION['sys']['dir_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
      <!-- add new direction -->
      <button type="button" class="btn btn-outline-primary py-1 fs-12" data-bs-toggle="modal" data-bs-target="#addNewDirectionModal">
        <i class="bi bi-node-plus"></i>
        <?php echo lang("ADD NEW", "directions") ?>
      </button>
    <?php } ?>

    <?php if (!is_null($directions_info) || $directions_counter != 0) { ?>
      <?php if ($_SESSION['sys']['dir_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <!-- edit direction -->
        <button type="button" class="btn btn-outline-primary py-1 fs-12" data-bs-toggle="modal" data-bs-target="#editDirectionModal">
          <i class="bi bi-pencil-square"></i>
          <?php echo lang("EDIT DIR", "directions") ?>
        </button>
      <?php } ?>

      <?php if ($_SESSION['sys']['dir_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <!-- delete direction -->
        <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteDirectionModal">
          <i class="bi bi-trash"></i>
          <?php echo lang("DELETE DIR", "directions") ?>
        </button>
      <?php } ?>
    <?php } ?>
  </div>

  <!-- second row -->
  <div class="mb-3">
    <?php if (is_null($directions_info) || $directions_counter == 0) { ?>
      <div class="page-error text-center">
        <img loading="lazy" src="<?php echo $assets ?>images/no-data-founded.svg" class="img-fluid" alt="<?php echo lang('NO DATA') ?>">
      </div>
      <h5 class='h5 text-center text-danger '>
        <?php echo lang('NO DATA') ?>
      </h5>
    <?php } else { ?>
      <!-- display all employees -->
      <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 align-items-stretch justify-content-start">
        <?php foreach ($directions_info as $index => $row) { ?>
          <div class="col-12">
            <div class="card card-fw <?php echo $_SESSION['sys']['system_theme'] == 2 ? 'card-effect' : ''; ?> <?php echo @$_SESSION['sys']['lang'] == "ar" ? "card-effect-right" : "card-effect-left"; ?>">
              <!-- employee details -->
              <div class="card-body">
                <!-- vstack for employee info -->
                <div class="vstack gap-1">
                  <!-- card title -->
                  <h5 class="mb-0 card-title">
                    <?php echo $row['direction_name'] ?>
                    <?php if (get_date_now() == $row['added_date']) { ?>
                      <span class="badge bg-danger py-1 fs-12">
                        <?php echo lang('NEW') ?>
                      </span>
                    <?php } ?>
                  </h5>
                  <h6 class="my-0 card-subtitle">
                    <?php echo lang('dir code', $lang_file) . ": " . $row['direction_id'] . $_SESSION['sys']['company_code'] ?>
                  </h6>
                  <!-- horizontal rule -->
                  <hr>
                </div>
                <!-- vstack for some statistics -->
                <div class="vstack gap-1 nums <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'text-end' : 'text-start' ?>">
                  <?php
                  // clients condition
                  $clients_conditions = "WHERE `direction_id` = '" . $row['direction_id'] . "' AND `is_client` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                  // pieces condition
                  $pieces_conditions = "WHERE `direction_id` = '" . $row['direction_id'] . "' AND `is_client` = 0 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                  // pieces condition
                  $unkown_conditions = "WHERE `direction_id` = '" . $row['direction_id'] . "' AND `is_client` NOT IN (0, 1) AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                  // count pieces
                  $pieces = $dir_obj->count_records("`id`", "pieces_info", $pieces_conditions);
                  // count clients
                  $clients = $dir_obj->count_records("`id`", "pieces_info", $clients_conditions);
                  // count unkown
                  $unkown = $dir_obj->count_records("`id`", "pieces_info", $unkown_conditions);
                  ?>
                  <!-- clients -->
                  <a href="<?php echo $nav_up_level ?>clients/index.php?do=show-dir-clients&dir-id=<?php echo base64_encode($row["direction_id"]) ?>" class="mb-0 text-capitalize">
                    <i class="bi bi-people"></i>
                    <span>
                      <?php echo lang('CLIENTS') ?>
                    </span>
                    <span class="num" data-goal="<?php echo $clients ?>">0</span>
                  </a>
                  <!-- pieces -->
                  <a href="<?php echo $nav_up_level ?>pieces/index.php?do=show-dir-pieces&type=0&dir-id=<?php echo base64_encode($row["direction_id"]) ?>" class="mb-0 text-capitalize">
                    <i class="bi bi-hdd-rack"></i>
                    <span>
                      <?php echo lang('PIECES') ?>
                    </span>
                    <span class="num" data-goal="<?php echo $pieces ?>">0</span>
                  </a>
                  <!-- un assigned -->
                  <a href="<?php echo $nav_up_level ?>pieces/index.php?do=show-dir-pieces&type=-1&dir-id=<?php echo base64_encode($row["direction_id"]) ?>" class="mb-0 text-capitalize">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>
                      <?php echo lang('UNKNOWN') ?>
                    </span>
                    <span class="num" data-goal="<?php echo $unkown ?>">0</span>
                  </a>
                  <!-- horizontal rule -->
                  <hr>
                </div>
                <!-- hstack for buttons -->
                <div class="vstack gap-1">
                  <!-- added date -->
                  <p class="card-text text-secondary text-capitalize mb-0 fs-12 fs-10-sm <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ms-auto' : 'me-auto' ?>">
                    <?php echo lang('ADDED DATE') . " " . $row['added_date'] ?>
                  </p>
                  <!--  -->
                  <div class="row row-cols-sm-1 row-cols-md-2 g-2 align-items-baseline">
                    <?php if ($_SESSION['sys']['dir_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                      <div class="col-6">
                        <!-- edit direction -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editDirectionModal" class='py-1 w-100 btn btn-primary text-capitalize fs-12 fs-10-sm' onclick="put_dir_info(this, 'update')" data-direction-id="<?php echo base64_encode($row['direction_id']) ?>" data-direction-name="<?php echo $row['direction_name'] ?>">
                          <i class="bi bi-pencil-square p-1"></i>
                          <?php echo lang('EDIT') ?>
                        </button>
                      </div>
                    <?php } ?>

                    <?php if ($_SESSION['sys']['dir_delete'] == 1 && $clients < 1 && $pieces < 1 && $unkown < 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                      <div class="col-6">
                        <!-- delete direction -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteDirectionModal" class='w-100 btn btn-outline-danger text-capitalize py-1 fs-12 fs-10-sm' style="<?php echo $_SESSION['sys']['user_delete'] == 0 || $clients > 0 || $pieces > 0 ? 'cursor: not-allowed' : '' ?>" onclick="put_dir_info(this, 'delete')" data-direction-id="<?php echo base64_encode($row['direction_id']) ?>">
                          <i class="bi bi-trash p-1"></i>
                          <?php echo lang('DELETE') ?>
                        </button>
                      </div>
                    <?php } ?>

                  </div>
                  <?php if ($_SESSION['sys']['dir_show'] == 1) { ?>
                    <!-- show direction tree -->
                    <a href="?do=show-direction-tree&dir-id=<?php echo base64_encode($row["direction_id"]) ?>" class="w-100 btn btn-outline-primary p-1 fs-12 fs-10-sm">
                      <i class="bi bi-diagram-3 p-1"></i>
                      <?php echo lang('SHOW TREE') ?>
                    </a>
                  <?php } ?>
                  <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                    <a href="?do=direction-map&dir-id=<?php echo base64_encode($row['direction_id']) ?>" class="w-100 btn btn-outline-primary p-1 fs-12 fs-10-sm">
                      <i class="bi bi-geo-alt"></i>
                      <?php echo lang('DIRECTION MAP') ?>
                    </a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
  <!-- end stats -->
</div>

<?php
if (!empty($directions_info) || $directions_counter != 0) {
  if ($_SESSION['sys']['dir_update'] == 1) {
    // include edit direction modal
    include_once 'edit-direction-modal.php';
  }

  if ($_SESSION['sys']['dir_delete'] == 1) {
    // include delete direction modal
    include_once 'delete-direction-modal.php';
  }
}
?>