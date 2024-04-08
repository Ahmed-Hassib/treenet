<?php
// get search 
$search = trim($_GET['search'], ' ');

// create an object from User class
$emp_obj = new User();
// search in employees
$employees = $emp_obj->search($search, base64_decode($_SESSION['sys']['company_id']));
// get employees counter
$emp_count = $employees != null ? count($employees) : 0;

// create an object of Direction class
$dir_obj = new Direction();
// search in directions
$directions = $dir_obj->search($search, base64_decode($_SESSION['sys']['company_id']));
// get directions counter
$dir_count = $directions != null ? count($directions) : 0;

// create an object of Pieces Class
$pcs_obj = new Pieces();
// search in pieces
$pieces = $pcs_obj->search($search, base64_decode($_SESSION['sys']['company_id']), 0);
// get pieces counter
$pcs_count = $pieces != null ? count($pieces) : 0;

// search in clients
$clients = $pcs_obj->search($search, base64_decode($_SESSION['sys']['company_id']), 1);
// get clients counter
$clients_count = $clients != null ? count($clients) : 0;

// total search results
$total_results = $emp_count + $dir_count + $pcs_count + $clients_count;
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if (empty($search)) { ?>
    <header class="mb-5">
      <h5 class="h5 text-capitalize text-danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?php echo lang('SEARCH STMT EMPTY') ?>
      </h5>
    </header>
  <?php } else { ?>
    <header class="mb-5">
      <!-- search form -->
      <form action="?do=search" class="mb-3 search-form">
        <div class="search-container">
          <i class="bi bi-search search-icon <?php echo $page_dir == 'rtl' ? 'search-icon-right' : 'search-icon-left' ?>"></i>
          <input type="search" name="search" id="" class="form-control <?php echo $page_dir == 'rtl' ? 'search-right' : 'search-left' ?>" value="<?php echo $search ?>" placeholder="<?php echo lang('SEARCH HERE', $lang_file) ?>">
        </div>
      </form>
      <h3 class="h3 text-capitalize"><?php echo lang('SEARCH RESULT') ?>: <?php echo $search ?></h3>
      <h6 class="h6 text-capitalize"><?php echo lang('TOTAL RESULTS') ?>: <?php echo $total_results ?></h6>
    </header>
    <!-- employees search -->
    <div class="mb-5 employee-search">
      <header class="<?php echo $page_dir == 'rtl' ? 'text-right' : 'text-left' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#employeesResult" aria-expanded="false" aria-controls="employeesResult">
        <h5 class="h5 text-capitalize"><?php echo lang('EMPLOYEES') ?></h5>
        <h6 class="h6 text-capitalize"><?php echo lang('#RESULTS') ?>: <?php echo $emp_count ?></h6>
        <hr>
      </header>
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3 collapse" id="employeesResult">
        <?php if ($emp_count > 0) { ?>
          <?php foreach ($employees as $key => $emp) { ?>
            <div class="col-12">
              <div class="py-2 section-block">
                <header class="seaction-header">
                  <?php if ($_SESSION['sys']['user_add']) { ?>
                    <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($emp['userid']) ?>" target="_blank">
                      <h5 class="h5 text-capitalize">
                        <?php echo $emp['fullname'] ?>
                      </h5>
                    </a>
                  <?php } else { ?>
                    <h5 class="h5 text-capitalize">
                      <?php echo $emp['fullname'] ?>
                    </h5>
                  <?php } ?>
                </header>
                <!-- employee info -->
                <div>
                  <?php if ($emp['job_title_id'] > 0) { ?>
                    <span class="m-1 badge bg-secondary">
                      <?php
                      // get user job name
                      $job_name = $emp_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $emp['job_title_id'])['job_title_name'];
                      // disply job title
                      echo lang($job_name, 'employees');
                      ?>
                    </span>
                  <?php } ?>
                  <?php if (!empty($emp['email'])) { ?>
                    <span class="m-1 badge bg-secondary">
                      <i class="bi bi-envelope"></i>&nbsp;
                      <?php echo $emp['email'] ?>
                    </span>
                  <?php } ?>
                  <?php if (!empty($emp['address'])) { ?>
                    <span class="m-1 badge bg-secondary">
                      <i class="bi bi-geo-alt-fill"></i>&nbsp;
                      <?php echo $emp['address'] ?>
                    </span>
                  <?php } ?>
                  <?php if (!empty($emp['phone'])) { ?>
                    <span class="m-1 badge bg-secondary">
                      <i class="bi bi-telephone-fill"></i>&nbsp;
                      <?php echo $emp['phone'] ?>
                    </span>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <h5 class="h5 text-capitalize text-danger"><?php echo lang('NO RESULT MATCH') ?></h5>
        <?php } ?>
      </div>
    </div>

    <!-- directions search -->
    <div class="mb-5 directions-search">
      <header class="<?php echo $page_dir == 'rtl' ? 'text-right' : 'text-left' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#directionsResult" aria-expanded="false" aria-controls="directionsResult">
        <h5 class="h5 text-capitalize"><?php echo lang('DIRECTIONS') ?></h5>
        <h6 class="h6 text-capitalize"><?php echo lang('#RESULTS') ?>: <?php echo $dir_count ?></h6>
        <hr>
      </header>
      <div class="mb-3 row row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-3 collapse" id="directionsResult">
        <?php if ($dir_count > 0) { ?>
          <?php foreach ($directions as $key => $dir) { ?>
            <div class="col-12">
              <div class="py-2 section-block">
                <header class="seaction-header">
                  <?php if ($_SESSION['sys']['user_add']) { ?>
                    <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($dir['direction_id']) ?>" target="_blank">
                      <h5 class="h5 text-capitalize">
                        <?php echo $dir['direction_name'] ?>
                      </h5>
                    </a>
                  <?php } else { ?>
                    <h5 class="h5 text-capitalize">
                      <?php echo $dir['direction_name'] ?>
                    </h5>
                  <?php } ?>
                </header>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <h5 class="h5 text-capitalize text-danger"><?php echo lang('NO RESULT MATCH') ?></h5>
        <?php } ?>
      </div>
    </div>

    <!-- pieces search -->
    <div class="mb-5 pieces-search">
      <header class="<?php echo $page_dir == 'rtl' ? 'text-right' : 'text-left' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#pcsResult" aria-expanded="false" aria-controls="pcsResult">
        <h5 class="h5 text-capitalize"><?php echo lang('PIECES') ?></h5>
        <h6 class="h6 text-capitalize"><?php echo lang('#RESULTS') ?>: <?php echo $pcs_count ?></h6>
        <hr>
      </header>
      <div class="mb-3 collapse" id="pcsResult">
        <?php if ($pcs_count > 0) { ?>
          <div class="table-responsive-sm">
            <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" style="width:100%">
              <thead class="primary text-capitalize w-100">
                <tr>
                  <th>#</th>
                  <th><?php echo lang('PCS NAME', 'pieces') ?></th>
                  <th><?php echo lang('PROP ADDR', 'pieces') ?></th>
                  <th><?php echo lang('AGENT PHONE', 'pieces') ?></th>
                  <th><?php echo lang('DIRECTION', 'directions') ?></th>
                  <th><?php echo lang('MAC') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pieces as $key => $pcs) { ?>
                  <tr>
                    <td><?php echo $key + 1 ?></td>
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
                        <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("direction not assigned", $lang_file) ?>"></i>
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
                      <?php if (is_null($piece['address'])) { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang('NOT ASSIGNED') ?>
                        </span>
                      <?php } else {
                        echo wordwrap(trim($piece['address']), "50", "<br>");
                      } ?>
                    </td>
                    <!-- piece phone -->
                    <td>
                      <?php
                      // get piece phone
                      $phones = $pcs_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $pcs['id']);
                      // check result
                      if (count($phones) > 0) {
                        echo trim($phones['phone']);
                      } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang('NOT ASSIGNED') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- piece direction -->
                    <td class="text-capitalize big-data">
                      <?php $dir_name = is_null($piece['direction_id']) ? null : $pcs_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $piece['direction_id'])['direction_name']; ?>
                      <?php if (!is_null($dir_name)) { ?>
                        <?php if ($_SESSION['sys']['dir_update'] == 0) { ?>
                          <span>
                            <?php echo $dir_name ?>
                          </span>
                        <?php } else { ?>
                          <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($piece['direction_id']); ?>">
                            <?php echo $dir_name ?>
                          </a>
                        <?php } ?>
                      <?php } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("direction not assigned", $lang_file) ?>"></i>
                          <?php echo lang("direction not assigned", $lang_file) ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- piece type -->
                    <td class="text-capitalize">
                      <?php
                      if ($pcs['is_client'] == 1) {
                        $type = lang("CLT", 'clients');
                        $type_class = "";
                      } elseif ($pcs['is_client'] == 0) {
                        if ($pcs['device_type'] == 1) {
                          $type = lang('TRANSMITTER', 'pieces');
                          $type_class = "";
                        } elseif ($pcs['device_type'] == 2) {
                          $type = lang('RECEIVER', 'pieces');
                          $type_class = "";
                        } else {
                          $type = lang('NOT ASSIGNED');
                          $type_class = "text-danger fs-12 fw-bold";
                        }
                      } else {
                        $type = lang('NOT ASSIGNED');
                        $type_class = "text-danger fs-12 fw-bold";
                      }
                      ?>
                      <!-- display type -->
                      <span class="<?php echo isset($type_class) ? $type_class : '' ?>">
                        <?php echo $type ?>
                      </span>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } else { ?>
          <h5 class="h5 text-capitalize text-danger"><?php echo lang('NO RESULT MATCH') ?></h5>
        <?php } ?>
      </div>
    </div>

    <!-- clients search -->
    <div class="mb-5 clients-search">
      <header class="<?php echo $page_dir == 'rtl' ? 'text-right' : 'text-left' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#clientsResult" aria-expanded="false" aria-controls="clientsResult">
        <h5 class="h5 text-capitalize"><?php echo lang('CLIENTS') ?></h5>
        <h6 class="h6 text-capitalize"><?php echo lang('#RESULTS') ?>: <?php echo $clients_count ?></h6>
        <hr>
      </header>
      <div class="mb-3 collapse" id="clientsResult">
        <?php if ($clients_count > 0) { ?>
          <div class="table-responsive-sm">
            <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" style="width:100%">
              <thead class="primary text-capitalize w-100">
                <tr>
                  <th>#</th>
                  <th><?php echo lang('CLT NAME', 'clients') ?></th>
                  <th><?php echo lang('ADDR', 'clients') ?></th>
                  <th><?php echo lang('PHONE', 'clients') ?></th>
                  <th><?php echo lang('DIRECTION', 'directions') ?></th>
                  <th><?php echo lang('MAC') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($clients as $key => $client) { ?>
                  <tr>
                    <td><?php echo $key + 1 ?></td>
                    <!-- client name -->
                    <td>
                      <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                        <a href="?do=edit-client&client-id=<?php echo base64_encode($client['id']); ?>" target="">
                          <?php echo trim($client['full_name'], ' ') ?>
                        </a>
                      <?php } else { ?>
                        <span>
                          <?php echo trim($client['full_name'], ' ') ?>
                        </span>
                      <?php } ?>
                      <?php if (is_null($client['direction_id']) || $client['direction_id'] == 0) { ?>
                        <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("direction not assigned", 'pieces') ?>"></i>
                      <?php } ?>
                      <?php if ($client['created_at'] == date('Y-m-d')) { ?>
                        <span class="badge bg-danger p-1 <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'me-1' : 'ms-1' ?>">
                          <?php echo lang('NEW') ?>
                        </span>
                      <?php } ?>
                      <?php if ($_SESSION['sys']['mikrotik']['status'] && $is_connected_mikrotik && isset($client['ip']) && $client['ip'] !== '0.0.0.0') { ?>
                        <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="<?php echo $nav_up_level ?>pieces/index.php?do=mikrotik&ip=<?php echo $client['ip'] ?>&port=<?php echo $client['port'] == '80' ? '80' : '443' ?>" target='_blank'>
                          <?php echo lang('VISIT DEVICE', $lang_file) ?>
                        </a>
                      <?php } ?>
                    </td>
                    <!-- client address -->
                    <td>
                      <?php
                      if (!is_null($client['address'])) {
                        echo trim($client['address']);
                      } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang('NOT ASSIGNED') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- client phone -->
                    <td>
                      <?php
                      // get client phone
                      $phones = $pcs_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $client['id']);
                      // check result
                      if (count($phones) > 0) {
                        echo trim($phones['phone']);
                      } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang('NOT ASSIGNED') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- client direction -->
                    <td class="text-capitalize">
                      <?php $dir_name = is_null($client['direction_id']) ? null : $pcs_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $client['direction_id'])['direction_name']; ?>
                      <?php if (!is_null($dir_name)) { ?>
                        <?php if ($_SESSION['sys']['dir_update'] == 1) { ?>
                          <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($client['direction_id']); ?>">
                            <?php echo $dir_name ?>
                          </a>
                        <?php } else { ?>
                          <span>
                            <?php echo $dir_name ?>
                          </span>
                        <?php } ?>
                      <?php } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang("NOT ASSIGNED") ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- mac address -->
                    <td>
                      <?php
                      // get mac address
                      $mac_addr_info = $db_obj->select_specific_column("`mac_add`", "`pieces_mac_addr`", "WHERE `id` = " . $client['id']);
                      // check result
                      if (count($mac_addr_info) <= 0 || $mac_addr_info == null) {
                        $mac_addr = lang('NOT ASSIGNED');
                        $mac_class = 'text-danger fs-12 fw-bold';
                      } else {
                        $mac_addr = $mac_addr_info['mac_add'];
                        $mac_class = '';
                      }
                      ?>
                      <span class="<?php echo isset($mac_class) ? $mac_class : '' ?>">
                        <?php echo $mac_addr ?>
                      </span>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } else { ?>
          <h5 class="h5 text-capitalize text-danger"><?php echo lang('NO RESULT MATCH') ?></h5>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
</div>