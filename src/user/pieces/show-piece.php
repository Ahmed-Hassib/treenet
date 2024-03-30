<?php
// check if Get request dir-id is numeric and get the integer value
$dir_id = isset($_GET['dir-id']) && !empty($_GET['dir-id']) ? base64_decode($_GET['dir-id']) : -1;
// check if Get request src-id is numeric and get the integer value
$src_id = isset($_GET['src-id']) && !empty($_GET['src-id']) ? base64_decode($_GET['src-id']) : -1;
// check the direction and source id
if ($dir_id != -1 && $src_id != -1) {
  // create an object of Pieces class
  $pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
  // get name of current devices
  $current_piece_name = $pcs_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = {$src_id}")[0]['full_name'];
  // condition
  $condition = "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `direction_id` = $dir_id AND `source_id` = {$src_id} AND `deleted_at` IS NULL"; // query condition
  // get all pieces
  $all_data = $pcs_obj->get_pieces($condition);

  // flag for include js code
  $is_big_data_ping = true;
?>
  <!-- start edit profile page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start table container -->
    <div class="section-block">
      <!-- start header -->
      <header class="section-header">
        <h2 class="h2 text-capitalize mt-1">
          <?php echo $current_piece_name ?>
          <?php if ($_SESSION['sys']['pcs_update'] == 1) { ?>
            <!-- edit current piece -->
            <a class="btn btn-outline-success fs-12 py-1" href="?do=edit-piece&piece-id=<?php echo base64_encode($src_id); ?>">
              <i class="bi bi-pencil-square"></i>
              <?php echo lang('EDIT') ?>
            </a>
          <?php } ?>
          <?php $src_ip = $db_obj->select_specific_column("`ip`", "`pieces_info`", "WHERE `id` = $src_id")[0]['ip'] ?>
          <?php $src_port = $db_obj->select_specific_column("`port`", "`pieces_info`", "WHERE `id` = $src_id")[0]['port'] ?>
          <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($src_ip) && $src_ip !== '0.0.0.0') { ?>
            <!-- visit current device -->
            <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-1" href="?do=mikrotik&ip=<?php echo $src_ip ?>&port=<?php echo $src_port == '80' ? '80' : '443' ?>" target='_blank'>
              <?php echo lang('VISIT DEVICE', $lang_file) ?>
            </a>
          <?php } ?>
        </h2>
        <hr>
      </header>
      <?php if (!is_null($all_data)) { ?>
        <!-- strst pieces table -->
        <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo count($all_data) <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="null" style="width:100%">
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
                <?php echo lang('TYPE', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('COORDINATES', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('NOTE') ?>
              </th>
              <th>
                <?php echo lang('VISIT TIME', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('DIRECTION', 'directions') ?>
              </th>
              <th>
                <?php echo lang('THE SRC', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('ALT SRC', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('DEV TYPE', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('DEV MODEL', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('CONN TYPE', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('IP') ?>
              </th>
              <th>
                <?php echo lang('PORT') ?>
              </th>
              <th>
                <?php echo lang('MAC') ?>
              </th>
              <th>
                <?php echo lang('USERNAME') ?>
              </th>
              <th>
                <?php echo lang('SSID', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('FREQ', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('WAVE', $lang_file) ?>
              </th>
              <th class="date-data">
                <?php echo lang('ADDED DATE') ?>
              </th>
              <th>
                <?php echo lang('CONTROL') ?>
              </th>
            </tr>
          </thead>
          <tbody id="piecesTbl">
            <?php foreach ($all_data as $index => $piece) { ?>
              <tr>
                <!-- index -->
                <td>
                  <?php echo ++$index; ?>
                </td>
                <!-- piece name -->
                <td>
                  <?php $piece_name = wordwrap(trim($piece['fullname'], ' '), 50, "<br>") ?>
                  <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                    <a href="?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="">
                      <?php echo $piece_name ?>
                    </a>
                  <?php } else { ?>
                    <span>
                      <?php echo $piece_name ?>
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
                <!-- piece address -->
                <td>
                  <?php
                  if (!is_null($piece['address'])) {
                    echo wordwrap($piece['address'], 50, "<br>");
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
                    $phone = $phones[0]['phone'];
                    $phone_ex = explode(",", $phone);
                    if (count($phone_ex) > 1) {
                      foreach ($phone_ex as $key => $ph) {
                        echo $ph . "<br>";
                      }
                    } else {
                      echo $phone;
                    }
                  } else { ?>
                    <span class="text-danger fs-12 fw-bold">
                      <?php echo lang('NOT ASSIGNED') ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- pice type -->
                <td class="text-capitalize">
                  <?php
                  if ($piece['is_client'] == 1) {
                    $type = lang("CLT", 'clients');
                    $type_class = "";
                  } elseif ($piece['is_client'] == 0) {
                    if ($piece['device_type'] == 1) {
                      $type = lang('TRANSMITTER', $lang_file);
                      $type_class = "";
                    } elseif ($piece['device_type'] == 2) {
                      $type = lang('RECEIVER', $lang_file);
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
                <!-- internet source -->
                <td>
                  <?php
                  if (!is_null($piece['coordinates'])) {
                    echo $piece['coordinates'];
                  } else { ?>
                    <span class="text-danger fs-12 fw-bold">
                      <?php echo lang('NOT ASSIGNED') ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- notes -->
                <td>
                  <?php echo wordwrap($piece['notes'], 50, "<br>") ?>
                </td>
                <!-- visit time -->
                <td>
                  <?php if ($piece['visit_time'] == 1) {
                    echo lang('ANY TIME', $lang_file);
                  } elseif ($piece['visit_time'] == 2) {
                    echo lang('ADV CONN', $lang_file);
                  } else { ?>
                    <span class="text-danger fs-12 fw-bold">
                      <?php echo lang('NOT ASSIGNED') ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- piece direction -->
                <td class="text-capitalize big-data">
                  <?php $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $piece['direction_id'])[0]['direction_name']; ?>
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
                <td class="text-capitalize big-data" data-ip="<?php echo convert_ip($source_ip) ?>">
                  <?php
                  // get source info
                  $source_info = $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $piece['source_id']);
                  // check info
                  if (!empty($source_info)) {
                    $source_name = trim($source_info[0]['full_name'], ' ');
                    $source_ip = trim($source_info[0]['ip'], ' ');
                    $source_port = trim($source_info[0]['port'], ' ');
                  } elseif ($piece['source_id'] == 0) {
                    $source_name = trim($piece['fullname'], ' ');
                    $source_ip = trim($piece['ip'], ' ');
                    $source_port = trim($piece['port'], ' ');
                  }
                  ?>
                  <span class="device-status">
                    <?php if (isset($source_ip) && $source_ip != '0.0.0.0') { ?>
                      <span class="ping-preloader ping-preloader-table position-relative">
                        <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                      </span>
                      <span class="ping-status"></span>
                    <?php } ?>
                    <span class="pcs-ip" data-pcs-ip="<?php echo $source_ip ?>">
                      <?php echo $source_name ?>
                    </span><br>
                    <?php if (isset($source_ip) && $source_ip != '0.0.0.0') { ?>
                      <a href="http://<?php echo $source_ip ?>" target="_blank">
                        <?php echo $source_ip ?>
                      </a>
                    <?php } ?>
                  </span><br>
                  <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($source_ip) && $source_ip != '0.0.0.0') { ?>
                    <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="?do=mikrotik&ip=<?php echo $source_ip ?>&port=<?php echo $source_port == '80' ? '80' : '443' ?>" target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                    <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $source_ip ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                  <?php } ?>
                </td>
                <!-- piece alt source -->
                <td class="text-capitalize big-data" data-ip="<?php echo convert_ip($source_ip) ?>">
                  <?php
                  // get source info
                  $alt_source_info = $piece['alt_source_id'] > 0 ? $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $piece['alt_source_id']) : null;
                  // default info is null
                  $alt_source_name = null;
                  $alt_source_ip = null;
                  $alt_source_port = null;
                  // check info
                  if (!empty($alt_source_info) || !is_null($alt_source_info)) {
                    $alt_source_name = trim($alt_source_info[0]['full_name'], ' ');
                    $source_ip = trim($alt_source_info[0]['ip'], ' ');
                    $alt_source_port = trim($alt_source_info[0]['port'], ' ');
                  } elseif ($piece['alt_source_id'] == 0) {
                    $alt_source_name = trim($piece['fullname'], ' ');
                    $alt_source_ip = trim($piece['ip'], ' ');
                    $alt_source_port = trim($piece['port'], ' ');
                  }
                  ?>
                  <?php if (is_null($alt_source_ip)) { ?>
                    <span class="text-danger fs-12 fw-bold">
                      <?php echo lang("NOT ASSIGNED") ?>
                    </span>
                  <?php } else { ?>
                    <span class="device-status">
                      <span class="ping-preloader ping-preloader-table position-relative">
                        <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                      </span>
                      <span class="ping-status"></span>
                      <span class="pcs-ip" data-pcs-ip="<?php echo $alt_source_ip ?>">
                        <?php echo $alt_source_name ?>
                      </span><br>
                      <a href="http://<?php echo $source_ip ?>" target="_blank">
                        <?php echo $alt_source_ip ?>
                      </a><br>
                    </span>
                    <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($alt_source_ip) && $alt_source_ip != '0.0.0.0') { ?>
                      <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="?do=mikrotik&ip=<?php echo $alt_source_ip ?>&port=<?php echo $alt_source_port == '80' ? '80' : '443' ?>" target='_blank'>
                        <?php echo lang('VISIT DEVICE', $lang_file) ?>
                      </a>
                      <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $alt_source_ip ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                    <?php } ?>
                  <?php } ?>
                </td>
                <!-- device type -->
                <td class="text-capitalize">
                  <?php
                  if (is_null($piece['device_id']) || $piece['device_id'] <= 0) {
                    $device_type = lang('NOT ASSIGNED');
                    $device_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $device_type = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = " . $piece['device_id'])[0]['device_name'];
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
                  if (is_null($piece['device_model']) || $piece['device_model'] <= 0) {
                    $model_name = lang('NOT ASSIGNED');
                    $model_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $model_name = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `model_id` = " . $piece['device_model'])[0]['model_name'];
                    $model_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($model_class) ? $model_class : '' ?>">
                    <?php echo $model_name ?>
                  </span>
                </td>
                <!-- connection type -->
                <td class="text-uppercase" data-value="<?php echo $piece['connection_type'] ?>">
                  <?php
                  if (is_null($piece['connection_type']) || $piece['connection_type'] <= 0) {
                    $conn_name = lang('NOT ASSIGNED');
                    $conn_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $conn_name = $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = " . $piece['connection_type'])[0]['connection_name'];
                    $conn_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($conn_class) ? $conn_class : '' ?>">
                    <?php echo $conn_name ?>
                  </span>
                </td>
                <!-- piece ip -->
                <td>
                  <?php
                  if ($piece['ip'] == null || empty($piece['ip']) || $piece['ip'] == '0.0.0.0') { ?>
                    <span class="text-danger fs-12 fw-bold">
                      <?php echo lang('NOT ASSIGNED') ?>
                    </span>
                  <?php } else { ?>
                    <span class="device-status">
                      <span class="ping-preloader ping-preloader-table position-relative">
                        <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                      </span>
                      <span class="ping-status"></span>
                      <span class="pcs-ip" data-pcs-ip="<?php echo trim($piece['ip'], ' ') ?>">
                        <a href="https://<?php echo trim($piece['ip'], ' ') ?>" target="_blank">
                          <?php echo trim($piece['ip'], ' ') ?>
                        </a>
                      </span>
                    </span><br>
                    <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($piece['ip']) && $piece['ip'] != '0.0.0.0') { ?>
                      <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="?do=mikrotik&ip=<?php echo $piece['ip'] ?>&port=<?php echo $piece['port'] == '80' ? '80' : '443' ?>" target='_blank'>
                        <?php echo lang('VISIT DEVICE', $lang_file) ?>
                      </a>

                      <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo trim($piece['ip'], ' ') ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                    <?php } ?>
                  <?php } ?>
                </td>
                <!-- piece port -->
                <td>
                  <?php
                  if (is_null($piece['port']) || $piece['port'] <= 0) {
                    $port_name = lang('NOT ASSIGNED');
                    $port_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $port_name = $piece['port'];
                    $port_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($port_class) ? $port_class : '' ?>">
                    <?php echo $port_name ?>
                  </span>
                </td>
                <!-- mac address -->
                <td>
                  <?php if (is_null($piece['mac_add'])) {
                    $mac_addr = lang('NOT ASSIGNED');
                    $mac_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $mac_addr = $piece['mac_add'];
                    $mac_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($mac_class) ? $mac_class : '' ?>">
                    <?php echo $mac_addr ?>
                  </span>
                </td>
                <!-- piece username -->
                <td>
                  <?php
                  if ($piece['username'] == null || strlen($piece['username']) <= 0) {
                    $username_name = lang('NOT ASSIGNED');
                    $username_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $username_name = $piece['username'];
                    $username_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($username_class) ? $username_class : '' ?>">
                    <?php echo $username_name ?>
                  </span>
                </td>
                <!-- ssid -->
                <td>
                  <?php if (is_null($piece['ssid'])) {
                    $ssid = lang('NOT ASSIGNED');
                    $ssid_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $ssid = $piece['ssid'];
                    $ssid_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($ssid_class) ? $ssid_class : '' ?>">
                    <?php echo $ssid ?>
                  </span>
                </td>
                <!-- frequency -->
                <td>
                  <?php
                  if (is_null($piece['frequency'])) {
                    $frequency = lang('NOT ASSIGNED');
                    $frequency_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $frequency = $piece['frequency'];
                    $frequency_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($frequency_class) ? $frequency_class : '' ?>">
                    <?php echo $frequency ?>
                  </span>
                </td>
                <!-- wave -->
                <td>
                  <?php
                  if (is_null($piece['wave'])) {
                    $wave = lang('NOT ASSIGNED');
                    $wave_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $wave = $piece['wave'];
                    $wave_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($wave_class) ? $wave_class : '' ?>">
                    <?php echo $wave ?>
                  </span>
                </td>
                <!-- added date -->
                <td>
                  <?php
                  // check result
                  if (is_null($piece['created_at'])) {
                    $date = lang('NOT ASSIGNED');
                    $date_class = 'text-danger fs-12 fw-bold';
                  } else {
                    $date = date_format(date_create($piece['created_at']), 'h:ia d-m-Y');
                    $date_class = '';
                  }
                  ?>
                  <span class="<?php echo isset($date_class) ? $date_class : '' ?>">
                    <?php echo $date ?>
                  </span>
                </td>
                <!-- control -->
                <td>
                  <div class="hstack gap-1">
                    <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                      <a class="btn btn-success text-capitalize fs-12" href="?do=edit-piece&piece-id=<?php echo base64_encode($piece['id']); ?>" target="_blank">
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
                      <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal" id="delete-piece-<?php echo ($index + 1) ?>" data-piece-id="<?php echo base64_encode($piece['id']) ?>" data-piece-name="<?php echo $piece['fullname'] ?>" onclick="confirm_delete_piece(this, true)"><i class="bi bi-trash"></i>
                        <?php echo lang('DELETE') ?>
                      </button>
                    <?php } ?>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else {
        // include data error
        include_once $globmod . 'no-data-founded-no-redirect.php';
      } ?>
    </div>
  </div>
<?php
} else {
  // include data error
  include_once $globmod . 'data-error.php';
}
?>