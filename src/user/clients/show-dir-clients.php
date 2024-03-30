<?php
// create an object of Pieces class
$pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
// get type
$dir_id = isset($_GET['dir-id']) && !empty($_GET['dir-id']) ? base64_decode($_GET['dir-id']) : -1;
// clients condition
$clients_condition = "WHERE `is_client` = 1 AND `direction_id` = {$dir_id} AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL";
// get all clients
$all_data = $pcs_obj->get_pieces($clients_condition);


// get direction name
$dir_name = $pcs_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $dir_id)[0]['direction_name'];
// main title
$main_title = "DIR CLTS";
?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo $page_dir ?>">


  <div class="mb-3 hstack gap-3">
    <?php if ($_SESSION['sys']['clients_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
      <a href="?do=add-new-client" class="btn btn-outline-primary py-1 fs-12">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD NEW', $lang_file) ?>
      </a>
    <?php } ?>
  </div>
</div>
<?php
// check counter
if (!is_null($all_data)) {
  // json data
  $all_data_json = json_encode($all_data);
?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <div class="section-block">
      <!-- start header -->
      <header class="section-header mb-3">
        <h2 class="h2 text-capitalize">
          <?php echo lang($main_title, $lang_file) ?>
        </h2>
        <h5 class="h5">
          <?php echo $dir_name ?>
        </h5>
        <hr>
      </header>
      <!-- strst clients table -->
      <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" data-scroll-y="<?php echo count($all_data) <= 10 ? 'auto' : 400 ?>" data-last-td=" null" style="width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <!-- <th></th> -->
            <th>#</th>
            <th>
              <?php echo lang('CLT NAME', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('ADDR', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('PHONE', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('TYPE', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('COORDINATES', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('NOTE') ?>
            </th>
            <th>
              <?php echo lang('VISIT TIME', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DIRECTION', 'directions') ?>
            </th>
            <th>
              <?php echo lang('THE SRC', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('ALT SRC', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DEV TYPE', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('DEV MODEL', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('CONN TYPE', 'pieces') ?>
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
              <?php echo lang('SSID', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('FREQ', 'pieces') ?>
            </th>
            <th>
              <?php echo lang('WAVE', 'pieces') ?>
            </th>
            <th class="date-data">
              <?php echo lang('ADDED DATE') ?>
            </th>
            <th>
              <?php echo lang('CONTROL') ?>
            </th>
          </tr>
        </thead>
        <tbody id="clientsTbl">
          <?php foreach ($all_data as $index => $client) { ?>
            <tr>
              <!-- index -->
              <td>
                <?php echo ++$index; ?>
              </td>
              <!-- client name -->
              <td>
                <?php $client_name = wordwrap(trim($client['fullname'], ' '), 50, "<br>") ?>
                <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
                  <a href="?do=edit-client&client-id=<?php echo base64_encode($client['id']); ?>" target="">
                    <?php echo $client_name ?>
                  </a>
                <?php } else { ?>
                  <span>
                    <?php echo $client_name ?>
                  </span>
                <?php } ?>
                <?php if ($client['direction_id'] == 0) { ?>
                  <i class="bi bi-exclamation-triangle-fill text-danger fw-bold" title="<?php echo lang("NOT ASSIGNED") ?>"></i>
                <?php } ?>
                <?php if ($client['created_at'] == date('Y-m-d')) { ?>
                  <span class="badge bg-danger p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-1' : 'ms-1' ?>">
                    <?php echo lang('NEW') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client address -->
              <td>
                <?php
                if (!is_null($client['address'])) {
                  echo wordwrap($client['address'], 50, "<br>");
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client phone -->
              <td>
                <?php
                // get piece phone
                $phones = $pcs_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $client['id']);
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
                if ($client['is_client'] == 1) {
                  $type = lang("CLT", 'clients');
                  $type_class = "";
                } elseif ($client['is_client'] == 0) {
                  if ($client['device_type'] == 1) {
                    $type = lang('TRANSMITTER', 'pieces');
                    $type_class = "";
                  } elseif ($client['device_type'] == 2) {
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
              <!-- internet source -->
              <td>
                <?php
                if (!is_null($client['coordinates'])) {
                  echo $client['coordinates'];
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- notes -->
              <td>
                <?php echo wordwrap($client['notes'], 50, "<br>") ?>
              </td>
              <!-- visit time -->
              <td>
                <?php if ($client['visit_time'] == 1) {
                  echo lang('ANY TIME', 'pieces');
                } elseif ($client['visit_time'] == 2) {
                  echo lang('ADV CONN', 'pieces');
                } else { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- client direction -->
              <td class="text-capitalize">
                <?php $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $client['direction_id'])[0]['direction_name']; ?>
                <?php if ($client['direction_id'] != 0 && $_SESSION['sys']['dir_update'] == 1) { ?>
                  <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($client['direction_id']); ?>">
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
              <!-- client source -->
              <td class="text-capitalize">
                <?php
                // get source info
                $source_info = $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $client['source_id']);
                // check info
                if (!empty($source_info)) {
                  $source_name = trim($source_info[0]['full_name'], ' \t\n\v');
                  $source_ip = trim($source_info[0]['ip'], ' \t\n\v');
                  $source_port = trim($source_info[0]['port'], ' \t\n\v');
                } elseif ($client['source_id'] == 0) {
                  $source_name = trim($client['fullname'], ' \t\n\v');
                  $source_ip = trim($client['ip'], ' \t\n\v');
                  $source_port = trim($client['port'], ' \t\n\v');
                }
                ?>
                <?php if ($source_ip == '0.0.0.0') { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang("NOT ASSIGNED") ?>
                  </span>
                <?php } else { ?>
                  <span class="device-status">
                    <span class="ping-preloader ping-preloader-table position-relative">
                      <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                    </span>
                    <span class="ping-status"></span>
                    <span class="pcs-ip" data-pcs-ip="<?php echo $source_ip ?>">
                      <?php echo $source_name ?>
                    </span><br>
                    <a href="http://<?php echo $source_ip ?>" target="_blank">
                      <?php echo $source_ip ?>
                    </a>
                  </span><br>
                  <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($source_ip) && $source_ip != '0.0.0.0' && 0) { ?>
                    <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="<?php echo $nav_up_level ?>pieces/index.php?do=mikrotik&ip=<?php echo $source_ip ?>&port=<?php echo $source_port == '80' ? '80' : '443' ?>" target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $source_ip ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- client alt source -->
              <td class="text-capitalize" data-ip="<?php echo convert_ip($source_ip) ?>">
                <?php
                // get source info
                $alt_source_info = $client['alt_source_id'] > 0 ? $db_obj->select_specific_column("`full_name`, `ip`, `port`", "`pieces_info`", "WHERE `id` = " . $client['alt_source_id']) : null;
                // default info is null
                $alt_source_name = null;
                $alt_source_ip = null;
                $alt_source_port = null;
                // check info
                if (!empty($alt_source_info)) {
                  $alt_source_name = trim($alt_source_info[0]['full_name'], ' \t\n\v');
                  $source_ip = trim($alt_source_info[0]['ip'], ' \t\n\v');
                  $alt_source_port = trim($alt_source_info[0]['port'], ' \t\n\v');
                } elseif ($client['alt_source_id'] == 0) {
                  $alt_source_name = trim($client['fullname'], ' \t\n\v');
                  $alt_source_ip = trim($client['ip'], ' \t\n\v');
                  $alt_source_port = trim($client['port'], ' \t\n\v');
                }
                ?>
                <?php if ($alt_source_ip == null) { ?>
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
                    <a href="http://<?php echo $alt_source_ip ?>" target="_blank">
                      <?php echo $alt_source_ip ?>
                    </a>
                  </span><br>
                  <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($alt_source_ip) && $alt_source_ip != '0.0.0.0' && 0) { ?>
                    <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="<?php echo $nav_up_level ?>pieces/index.php?do=mikrotik&ip=<?php echo $alt_source_ip ?>&port=<?php echo $source_port == '80' ? '80' : '443' ?>" target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo $alt_source_ip ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- device type -->
              <td class="text-capitalize">
                <?php
                if ($client['device_id'] <= 0) {
                  $device_type = lang('NOT ASSIGNED');
                  $device_class = 'text-danger fs-12 fw-bold';
                } else {
                  $device_type = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = " . $client['device_id'])[0]['device_name'];
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
                if ($client['device_model'] <= 0) {
                  $model_name = lang('NOT ASSIGNED');
                  $model_class = 'text-danger fs-12 fw-bold';
                } else {
                  $model_name = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `model_id` = " . $client['device_model'])[0]['model_name'];
                  $model_class = '';
                }
                ?>
                <span class="<?php echo isset($model_class) ? $model_class : '' ?>">
                  <?php echo $model_name ?>
                </span>
              </td>
              <!-- connection type -->
              <td class="text-uppercase" data-value="<?php echo $client['connection_type'] ?>">
                <?php
                if ($client['connection_type'] <= 0) {
                  $conn_name = lang('NOT ASSIGNED');
                  $conn_class = 'text-danger fs-12 fw-bold';
                } else {
                  $conn_name = $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = " . $client['connection_type'])[0]['connection_name'];
                  $conn_class = '';
                }
                ?>
                <span class="<?php echo isset($conn_class) ? $conn_class : '' ?>">
                  <?php echo $conn_name ?>
                </span>
              </td>
              <!-- client ip -->
              <td>
                <?php
                if (trim($client['ip'], ' \t\n\v') == null || empty(trim($client['ip'], ' \t\n\v')) || trim($client['ip'], ' \t\n\v') == '0.0.0.0') { ?>
                  <span class="text-danger fs-12 fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } else { ?>
                  <span class="device-status">
                    <span class="ping-preloader ping-preloader-table position-relative">
                      <span class="ping-spinner ping-spinner-table spinner-grow spinner-border"></span>
                    </span>
                    <span class="ping-status"></span>
                    <span class="pcs-ip" data-pcs-ip="<?php echo trim($client['ip'], ' \t\n\v') ?>">
                      <a href="http://<?php echo trim($client['ip'], ' \t\n\v') ?>" target="_blank">
                        <?php echo trim($client['ip'], ' \t\n\v') ?>
                      </a>
                    </span>
                  </span><br>
                  <?php if ($_SESSION['sys']['mikrotik']['status'] && isset($client['ip']) && $client['ip'] != '0.0.0.0' && 0) { ?>
                    <a class="mx-1 btn btn-outline-primary fs-12 px-3 py-0" href="<?php echo $nav_up_level ?>pieces/index.php?do=mikrotik&ip=<?php echo $client['ip'] ?>&port=<?php echo $source_port == '80' ? '80' : '443' ?>" target='_blank'>
                      <?php echo lang('VISIT DEVICE', $lang_file) ?>
                    </a>
                  <?php } ?>
                  <button class="btn btn-outline-primary fs-12 px-3 py-0" data-bs-toggle="modal" data-bs-target="#pingModal" onclick="ping('<?php echo trim($client['ip'], ' \t\n\v') ?>', <?php echo $_SESSION['sys']['ping_counter'] ?>)">ping</button>
                <?php } ?>
              </td>
              <!-- client port -->
              <td>
                <?php
                if (is_null($client['port'])) {
                  $port_name = lang('NOT ASSIGNED');
                  $port_class = 'text-danger fs-12 fw-bold';
                } else {
                  $port_name = $client['port'];
                  $port_class = '';
                }
                ?>
                <span class="<?php echo isset($port_class) ? $port_class : '' ?>">
                  <?php echo $port_name ?>
                </span>
              </td>
              <!-- mac address -->
              <td>
                <?php if (is_null($client['mac_add'])) {
                  $mac_addr = lang('NOT ASSIGNED');
                  $mac_class = 'text-danger fs-12 fw-bold';
                } else {
                  $mac_addr = $client['mac_add'];
                  $mac_class = '';
                }
                ?>
                <span class="<?php echo isset($mac_class) ? $mac_class : '' ?>">
                  <?php echo $mac_addr ?>
                </span>
              </td>
              <!-- client username -->
              <td>
                <?php
                if ($client['username'] == null || strlen($client['username']) <= 0) {
                  $username_name = lang('NOT ASSIGNED');
                  $username_class = 'text-danger fs-12 fw-bold';
                } else {
                  $username_name = $client['username'];
                  $username_class = '';
                }
                ?>
                <span class="<?php echo isset($username_class) ? $username_class : '' ?>">
                  <?php echo $username_name ?>
                </span>
              </td>
              <!-- ssid -->
              <td>
                <?php if (is_null($client['ssid'])) {
                  $ssid = lang('NOT ASSIGNED');
                  $ssid_class = 'text-danger fs-12 fw-bold';
                } else {
                  $ssid = $client['ssid'];
                  $ssid_class = '';
                }
                ?>
                <span class="<?php echo isset($ssid_class) ? $ssid_class : '' ?>">
                  <?php echo $ssid ?>
                </span>
              </td>
              <!-- frequency -->
              <td>
                <?php if (is_null($client['frequency'])) {
                  $frequency = lang('NOT ASSIGNED');
                  $frequency_class = 'text-danger fs-12 fw-bold';
                } else {
                  $frequency = $client['frequency'];
                  $frequency_class = '';
                }
                ?>
                <span class="<?php echo isset($frequency_class) ? $frequency_class : '' ?>">
                  <?php echo $frequency ?>
                </span>
              </td>
              <!-- wave -->
              <td>
                <?php if (is_null($client['wave'])) {
                  $wave = lang('NOT ASSIGNED');
                  $wave_class = 'text-danger fs-12 fw-bold';
                } else {
                  $wave = $client['wave'];
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
                if (is_null($client['created_at'])) {
                  $date = lang('NOT ASSIGNED');
                  $date_class = 'text-danger fs-12 fw-bold';
                } else {
                  $date = $client['created_at'];
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
                  <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
                    <a class="btn btn-success text-capitalize fs-12 " href="?do=edit-client&client-id=<?php echo base64_encode($client['id']); ?>" target="_blank">
                      <i class="bi bi-pencil-square"></i>
                      <?php echo lang('EDIT') ?>
                    </a>
                  <?php } ?>
                  <?php if ($client['is_client'] == 0 && $_SESSION['sys']['clients_show'] == 1) { ?>
                    <a class="btn btn-outline-primary text-capitalize fs-12" href="?do=show-piece&dir-id=<?php echo base64_encode($client['direction_id']) ?>&src-id=<?php echo base64_encode($client['id']) ?>"><i class="bi bi-eye"></i>
                      <?php echo lang('SHOW DETAILS') ?>
                    </a>
                  <?php } ?>
                  <?php if ($_SESSION['sys']['clients_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                    <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteClientModal" id="temp-delete-<?php echo ($index + 1) ?>" data-client-id="<?php echo base64_encode($client['id']) ?>" data-client-name="<?php echo $client['fullname'] ?>" onclick="confirm_delete_client(this, true)"><i class="bi bi-trash"></i>
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
  <?php if ($_SESSION['sys']['clients_delete'] == 1) {
    include_once "delete-client-modal.php";
  } ?>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>