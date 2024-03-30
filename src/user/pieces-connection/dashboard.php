<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <!-- buttons section -->
    <div class="mb-4 hstack gap-3">
      <?php if ($_SESSION['sys']['connection_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <!-- add new connection type -->
        <button type="button" class="btn btn-outline-primary shadow-sm py-1 fs-12" data-bs-toggle="modal" data-bs-target="#addNewPieceConnTypeModal">
          <i class="bi bi-file-plus"></i>
          <?php echo lang("ADD NEW", $lang_file) ?>
        </button>
      <?php } ?>

      <?php if ($_SESSION['sys']['connection_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <!-- edit connection type -->
        <button type="button" class="btn btn-outline-primary shadow-sm py-1 fs-12" data-bs-toggle="modal" data-bs-target="#editPieceConnTypeModal">
          <i class="bi bi-pencil-square"></i>
          <?php echo lang("EDIT CONN", $lang_file) ?>
        </button>
      <?php } ?>

      <?php if ($_SESSION['sys']['connection_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <!-- delete connection type -->
        <button type="button" class="btn btn-outline-danger shadow-sm py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceConnTypeModal">
          <i class="bi bi-pencil-square"></i>
          <?php echo lang("DELETE CONN", $lang_file) ?>
        </button>
      <?php } ?>
    </div>

    <!-- start new design -->

    <?php
    // create an object of PiecesConn class
    $conn_obj = !isset($conn_obj) ? new PiecesConn() : $conn_obj;
    // company id
    $company_id = base64_decode($_SESSION['sys']['company_id']);
    // get all connections 
    $conn_data = $conn_obj->get_all_conn_types($company_id);
    // data counter
    $types_count = $conn_data[0];
    // data rows
    $types_data = $conn_data[1];
    // check types count
    if ($types_count > 0) {
    ?>
      <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        <?php
        // counter
        $i = 1;
        // loop on types
        foreach ($types_data as $key => $type) {
          // type id
          $type_id = $type['id'];
          // get count of pieces
          $all_count = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `connection_type` = {$type_id} AND `pieces_info`.`company_id` = {$company_id}");
          $pcs_count = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `connection_type` = {$type_id} AND `pieces_info`.`company_id` = {$company_id}");
          $clients_count = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `connection_type` = {$type_id} AND `pieces_info`.`company_id` = {$company_id}");
          $unknown_count = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` NOT IN (0, 1) AND `connection_type` = {$type_id} AND `pieces_info`.`company_id` = {$company_id}");
          // check counter
          if ($i > 9) {
            $i = 1;
          }
        ?>
          <div class="col-12">
            <div class="card card-white shadow-sm border border-1">
              <div class="card-body">
                <h5 class="h5 card-title text-uppercase">
                  <?php echo $type['connection_name'] ?>
                </h5>
                <div class="nums">
                  <div class="row row-cols-sm-2 g-3">
                    <h5 class="col-12 h5 text-capitalize">
                      <span class="num" data-goal="<?php echo $all_count ?>">0</span>
                      <span><?php echo lang('TOTAL') ?></span>
                    </h5>
                    <h5 class="col-12 h5 text-capitalize">
                      <span class="num" data-goal="<?php echo $pcs_count ?>">0</span>
                      <span><?php echo lang('PIECES') ?></span>
                    </h5>
                    <h5 class="col-12 h5 text-capitalize">
                      <span class="num" data-goal="<?php echo $clients_count ?>">0</span>
                      <span><?php echo lang('CLIENTS') ?></span>
                    </h5>
                    <h5 class="col-12 h5 text-capitalize">
                      <span class="num" data-goal="<?php echo $unknown_count ?>">0</span>
                      <span><?php echo lang('UNKNOWN') ?></span>
                    </h5>
                  </div>
                </div>
              </div>
              <a href="?do=show-pieces-conn&conn-id=<?php echo base64_encode($type_id) ?>" class="stretched-link text-black"></a>
            </div>
          </div>
          <?php $i++; ?>
        <?php } ?>
        <!-- show the number of clients that not assigned the connection type -->
        <div class="col-12">
          <div class="card card-mal shadow-sm border border-1">
            <div class="card-body">
              <?php
              $not_assigned = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `connection_type` = 0 AND `company_id` = {$company_id}");
              $not_assigned_pcs_count = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `connection_type` = 0 AND `pieces_info`.`company_id` = {$company_id}");
              $not_assigned_clients_count = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `connection_type` = 0 AND `pieces_info`.`company_id` = {$company_id}");
              $not_assigned_unknown_count = $conn_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` NOT IN (0, 1) AND `connection_type` = 0 AND `pieces_info`.`company_id` = {$company_id}");
              ?>
              <h5 class="h5 card-title text-uppercase">
                <?php echo lang('NOT ASSIGNED') ?>
              </h5>
              <div class="nums">
                <div class="row row-cols-sm-2 g-3">
                  <h5 class="col-12 h5 text-capitalize">
                    <span class="num" data-goal="<?php echo $not_assigned ?>">0</span>
                    <span><?php echo lang('TOTAL') ?></span>
                  </h5>
                  <h5 class="col-12 h5 text-capitalize">
                    <span class="num" data-goal="<?php echo $not_assigned_pcs_count ?>">0</span>
                    <span><?php echo lang('PIECES') ?></span>
                  </h5>
                  <h5 class="col-12 h5 text-capitalize">
                    <span class="num" data-goal="<?php echo $not_assigned_clients_count ?>">0</span>
                    <span><?php echo lang('CLIENTS') ?></span>
                  </h5>
                  <h5 class="col-12 h5 text-capitalize">
                    <span class="num" data-goal="<?php echo $not_assigned_unknown_count ?>">0</span>
                    <span><?php echo lang('UNKNOWN') ?></span>
                  </h5>
                </div>
              </div>
              <a href="?do=show-pieces-conn&conn-id=0" class="stretched-link text-black"></a>
            </div>
          </div>
        </div>
      <?php } else {
      // include no data founded file
      include_once $globmod . 'no-data-founded-no-redirect.php';
    } ?>
      </div>
  </div>
</div>