<?php
// create an object of Pieces class
$pcs_obj = new Pieces();
// get type
$type = isset($_GET['type']) && !empty($_GET['type']) ? intval($_GET['type']) : 0;
// get connection id
$connection_id = isset($_GET['conn-id']) && !empty($_GET['conn-id']) ? base64_decode($_GET['conn-id']) : null;
// show all clients of specific connection type
$condition = "WHERE `pieces_info`.`connection_type` = {$connection_id} AND `pieces_info`.`company_id` = " . base64_decode($_SESSION['sys']['company_id']); // query condition
// get connection name
$conn_type_name = $pcs_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = {$connection_id}");

// check the connection id 
if (!is_null($connection_id)) {
  // page subtitle
  $subtitle = $conn_type_name['connection_name'];
} else {
  // page subtitle
  $subtitle = '';
}

// get specific pieces/clients
$all_data = $pcs_obj->get_pieces($condition);

// check is_exist
if (!is_null($all_data)) {
?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start table container -->
    <div class="section-block">
      <?php if ($subtitle != '') { ?>
        <!-- start header -->
        <header class="section-header mb-3">
          <h2 class="h2 text-capitalize">
            <?php echo $subtitle; ?>
          </h2>
          <hr>
        </header>
      <?php } ?>
      <!-- strst pieces table -->
      <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo count($all_data) <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="null" data-scroll-y="400" style=" width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <th>#</th>
            <th class="text-uppercase">
              <?php echo lang('IP') ?>
            </th>
            <th class="text-uppercase">
              <?php echo lang('MAC') ?>
            </th>
            <th>
              <?php echo lang('PCS NAME', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('USERNAME') ?>
            </th>
            <th>
              <?php echo lang('DIRECTION', 'directions') ?>
            </th>
            <th>
              <?php echo lang('THE SRC', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('TYPE', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DEV TYPE', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DEV MODEL', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('CONN TYPE', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('ADDED DATE') ?>
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
              <!-- piece ip -->
              <td class="text-capitalize" data-ip="<?php echo convert_ip(trim($piece['ip'], ' \t\n\v')) ?>">
                <?php if (trim($piece['ip'], ' \t\n\v') == '0.0.0.0') { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang("NOT ASSIGNED") ?>
                  </span>
                <?php } else { ?>
                  <a href="http://<?php echo trim($piece['ip'], ' \t\n\v') ?>" class="pcs-ip" data-pcs-ip="<?php echo trim($piece['ip'], ' \t\n\v') ?>">
                    <?php echo trim($piece['ip'], ' \t\n\v') ?>
                  </a>
                  <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                    <br>
                    <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $piece['ip'] ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                  <?php } ?>
                <?php } ?>
              </td>
              <!-- piece mac address -->
              <td class="text-capitalize <?php echo !empty($piece['mac_add']) ? "" : "text-danger fw-bold" ?>">
                <?php echo !empty($piece['mac_add']) ? $piece['mac_add'] : lang("NOT ASSIGNED") ?>
              </td>
              <!-- piece name -->
              <td>
                <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="">
                    <?php echo wordwrap(trim($piece['full_name'], ' \t\n\v'), 50, "<br>") ?>
                  </a>
                <?php } else { ?>
                  <span>
                    <?php echo wordwrap(trim($piece['full_name'], ' \t\n\v'), 50, "<br>") ?>
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
              </td>
              <!-- piece username -->
              <td class="text-capitalize">
                <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                  <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>">
                    <?php echo wordwrap($piece['username'], 50, "<br>"); ?>
                  </a>
                <?php } else { ?>
                  <span>
                    <?php echo wordwrap($piece['username'], 50, "<br>"); ?>
                  </span>
                <?php } ?>
              </td>
              <!-- piece direction -->
              <td class="text-capitalize">
                <?php $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $piece['direction_id'])['direction_name']; ?>
                <?php if ($piece['direction_id'] != 0 && $_SESSION['sys']['dir_update'] == 1) { ?>
                  <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($piece['direction_id']); ?>">
                    <?php echo $dir_name ?>
                  </a>
                <?php } elseif ($_SESSION['sys']['dir_update'] == 0) { ?>
                  <span>
                    <?php echo $dir_name ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang("NOT ASSIGNED") ?>
                  </span>
                <?php } ?>
              </td>
              <!-- piece source -->
              <?php $source_ip = $piece['source_id'] == 0 ? $piece['ip'] : $db_obj->select_specific_column("`ip`", "`pieces_info`", "WHERE `id` = " . $piece['source_id'])['ip']; ?>
              <td class="text-capitalize" data-ip="<?php echo convert_ip($source_ip) ?>">
                <?php if (trim($source_ip, ' \t\n\v') == '0.0.0.0') { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang("NOT ASSIGNED") ?>
                  </span>
                <?php } else { ?>
                  <a href="http://<?php echo trim($source_ip, ' \t\n\v') ?>" class="pcs-ip" data-pcs-ip="<?php echo trim($source_ip, ' \t\n\v') ?>">
                    <?php echo trim($source_ip, ' \t\n\v') ?>
                  </a>
                  <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                    <br>
                    <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $source_ip ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                  <?php } ?>
                <?php } ?>
              </td>
              <!-- type -->
              <td class="text-capitalize">
                <?php
                if ($piece['is_client'] == 1) {
                  $type = lang("CLT", 'clients');
                  $type_class = "";
                } elseif ($piece['is_client'] == 0) {
                  if ($piece['device_type'] == 1) {
                    $type = lang('TRANSMITTER', 'pieces');
                    $type_class = "";
                  } elseif ($piece['device_type'] == 2) {
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
              <!-- device type -->
              <td class="text-capitalize">
                <?php
                if ($piece['device_id'] <= 0) {
                  $device_type = lang('NOT ASSIGNED');
                  $device_class = 'text-danger fs-12 fw-bold';
                } else {
                  $device_type = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = " . $piece['device_id'])['device_name'];
                  $device_class = '';
                }
                ?>
                <span class="<?php echo isset($device_class) ? $device_class : '' ?>">
                  <?php echo $device_type ?>
                </span>
              </td>
              <!-- device model -->
              <td>
                <?php
                if ($piece['device_model'] <= 0) {
                  $model_name = lang('NOT ASSIGNED');
                  $model_class = 'text-danger fs-12 fw-bold';
                } else {
                  $model_name = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `model_id` = " . $piece['device_model'])['model_name'];
                  $model_class = '';
                }
                ?>
                <span class="<?php echo isset($model_class) ? $model_class : '' ?>">
                  <?php echo $model_name ?>
                </span>
              </td>
              <!-- connection type -->
              <td class="text-uppercase" data-value="<?php echo $piece['connection_type'] ?>">
                <?php echo $piece['connection_type'] == 0 ? 'none' : $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = " . $piece['connection_type'])['connection_name']; ?>
              </td>
              <!-- added date -->
              <td>
                <?php
                // check result
                if (is_null($piece['created_at'])) {
                  $date = ucfirst(lang('NOT ASSIGNED'));
                  $date_class = 'text-danger fs-12 fw-bold';
                } else {
                  $date = wordwrap(date_format(date_create($piece['created_at']), 'h:i:sa d-m-Y'), 11, "<br>");
                  $date_class = '';
                }
                ?>
                <span class="<?php echo isset($date_class) ? $date_class : '' ?>">
                  <?php echo $date ?>
                </span>
              </td>
              <!-- control -->
              <td>
                <div class="hstach gap-1">
                  <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                    <a class="btn btn-success text-capitalize fs-12 " href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="_blank">
                      <i class="bi bi-pencil-square"></i>
                      <?php echo lang('EDIT') ?>
                    </a>
                  <?php } ?>
                  <?php if ($piece['is_client'] == 0 && $_SESSION['sys']['pcs_show'] == 1) { ?>
                    <a class="btn btn-outline-primary text-capitalize fs-12" href="<?php echo $nav_up_level ?>?do=show-piece&dir-id=<?php echo base64_encode($piece['direction_id']) ?>&src-id=<?php echo base64_encode($piece['id']) ?>">
                      <i class="bi bi-eye"></i>
                      <?php echo lang('SHOW DETAILS') ?>
                    </a>
                  <?php } ?>
                  <?php if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                    <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece" data-piece-id="<?php echo base64_encode($piece['id']) ?>" data-piece-name="<?php echo $piece['full_name'] ?>" onclick="confirm_delete_piece(this, true)" style="width: 80px">
                      <i class="bi bi-trash"></i>
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
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>