<?php $pcs_obj = new Pieces(); ?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="mb-3 hstack gap-3">
      <?php if ($_SESSION['sys']['pcs_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <a href="?do=add-new-piece" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-plus"></i>
          <?php echo lang('ADD NEW', $lang_file) ?>
        </a>
      <?php } ?>
      <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
        <a href="?do=devices-companies" class="btn btn-outline-primary py-1 fs-12">
          <i class="bi bi-hdd-rack"></i>
          <?php echo lang('MNG PCS TYPES', $lang_file) ?>
        </a>
      <?php } ?>
    </div>

    <!-- start new design -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-3 align-items-stretch justify-content-start">
      <!-- total numbers of pieces/pieces -->
      <div class="col-12">
        <?php $pieces = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `deleted_at` IS NULL AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
        <div class="dashboard-card card card-white bg-gradient">
          <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "router.svg" ?>" loading="lazy" alt="">
          <div class="card-body">
            <h5 class="h5 text-capitalize"><?php echo lang('LIST', $lang_file) ?>
            </h5>
            <h5 class="h5 text-capitalize">
              <span class="nums">
                (<span class="num" data-goal="<?php echo $pieces; ?>">0</span>)
              </span>
            </h5>
            <?php
            // get new pieces counter
            $new_pcs_counter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `deleted_at` IS NULL AND Date(`created_at`) = CURRENT_DATE AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
            // check the counter
            if ($new_pcs_counter > 0) {
              echo "<h5>(" . ($new_pcs_counter) . " " . lang('NEW') . ")</h5>";
            }
            ?>
          </div>
          <a href="?do=show-all-pieces" class="stretched-link"></a>
        </div>
      </div>
      <div class="col-12">
        <?php $pieces = $pcs_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND `deleted_at` IS NOT NULL AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
        <div class="dashboard-card card card-white bg-gradient">
          <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "trash.svg" ?>" loading="lazy" alt="">
          <div class="card-body">
            <h5 class="h5 text-capitalize"><?php echo lang('deletes') ?>
            </h5>
            <h5 class="h5 text-capitalize">
              <span class="nums">
                (<span class="num" data-goal="<?php echo $pieces; ?>">0</span>)
              </span>
            </h5>
          </div>
          <a href="?do=deletes" class="stretched-link"></a>
        </div>
      </div>
    </div>

    <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
      <? $is_big_data_ping = true; ?>
      <div class="mb-3 row row-cols-1 g-3">
        <!-- latest added pieces -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('LATEST ADDED', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang('LATEST ADDED STMT', $lang_file) ?>
              </p>
              <hr>
            </div>
            <!-- get latest added pieces -->
            <?php $latest_added_pcs = $pcs_obj->get_latest_records("*", "`pieces_info`", "WHERE `is_client` = 0 AND `deleted_at` IS NulL AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']), "`id`", 10); ?>
            <?php
            if (count($latest_added_pcs) > 0) {
              // get data
              $all_data = prepare_pcs_datatables($latest_added_pcs, $lang_file);
              // json data
              $all_data_json = json_encode($all_data);
            } else {
              $all_data = [];
            }
            ?>
            <!-- strst pieces table -->
            <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false"  style="width:100%">
              <thead class="primary text-capitalize">
                <tr>
                  <th>#</th>
                  <th>
                    <?php echo lang('PCS NAME', $lang_file) ?>
                  </th>
                  <th>
                    <?php echo lang('PROP ADDR', $lang_file) ?>
                  </th>
                  <th>
                    <?php echo lang('AGENT PHONE', $lang_file) ?>
                  </th>
                  <th>
                    <?php echo lang('CONTROL') ?>
                  </th>
                </tr>
              </thead>
              <tbody id="piecesTbl">
                <?php foreach ($all_data as $index => $piece) { ?>
                  <?php $name = $piece['is_client'] ? 'clients' : 'pieces' ?>
                  <tr>
                    <!-- index -->
                    <td>
                      <?php echo ++$index; ?>
                    </td>
                    <!-- piece name -->
                    <td>
                      <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                        <a href="?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="">
                          <?php echo trim($piece['full_name'], ' ') ?>
                        </a>
                      <?php } else { ?>
                        <span>
                          <?php echo trim($piece['full_name'], ' ') ?>
                        </span>
                      <?php } ?>
                      <?php if ($piece['direction_id'] == 0) { ?>
                        <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("NOT ASSIGNED") ?>"></i>
                      <?php } ?>
                      <?php if (date_format(date_create($piece['created_at']), 'Y-m-d') == date('Y-m-d')) { ?>
                        <span class="badge bg-danger p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-1' : 'ms-1' ?>">
                          <?php echo lang('NEW') ?>
                        </span>
                      <?php } ?>
                      <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($is_connected_mikrotik) && $is_connected_mikrotik && isset($piece['ip']) && $piece['ip'] !== '0.0.0.0') { ?>
                        <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="?do=mikrotik&ip=<?php echo $piece['ip'] ?>&port=<?php echo $piece['port'] == '80' ? '80' : '443' ?>" target='_blank'>
                          <?php echo lang('VISIT DEVICE', $lang_file) ?>
                        </a>
                      <?php } ?>
                    </td>
                    <!-- piece address -->
                    <td>
                      <?php
                      // get piece address
                      $addr = $pcs_obj->select_specific_column("`address`", "`pieces_addr`", "WHERE `id` = " . $piece['id']);
                      // check result
                      if (count($addr) > 0) {
                        echo trim($addr[0]['address']);
                      } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang('NOT ASSIGNED') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- piece phone -->
                    <td>
                      <?php
                      // get piece phone
                      $phones = $pcs_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $piece['id']);
                      // check result
                      if (count($phones) > 0) {
                        echo trim($phones[0]['phone']);
                      } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang('NOT ASSIGNED') ?>
                        </span>
                      <?php } ?>
                    </td>

                    <!-- control -->
                    <td>
                      <div class="hstack gap-1">
                        <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                          <a class="btn btn-success text-capitalize fs-12 " href="?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="_blank">
                            <i class="bi bi-pencil-square"></i>
                            <?php echo lang('EDIT') ?>
                          </a>
                        <?php } ?>
                        <?php if ($piece['is_client'] == 0 && $_SESSION['sys']['pcs_show'] == 1) { ?>
                          <a class="btn btn-outline-primary text-capitalize fs-12" href="?do=show-piece&dir-id=<?php echo base64_encode($piece['direction_id']) ?>&src-id=<?php echo base64_encode($piece['id']) ?>"><i class="bi bi-eye"></i>
                            <?php echo lang('SHOW DETAILS') ?>
                          </a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece-<?php echo ($index + 1) ?>" data-piece-id="<?php echo base64_encode($piece['id']) ?>" data-piece-name="<?php echo $piece['full_name'] ?>" onclick="confirm_delete_piece(this, true)" style="width: 80px"><i class="bi bi-trash"></i>
                            <?php echo lang('DELETE') ?>
                          </button>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <!-- end stats -->
</div>
<!-- end home stats container -->
