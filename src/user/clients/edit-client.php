<?php
// get client id from $_GET variable
$client_id = isset($_GET['client-id']) && !empty($_GET['client-id']) ? base64_decode($_GET['client-id']) : 0;
// create an object of Piece Class
$pcs_obj = !isset($pcs_obj) ? new Pieces() : $pcs_obj;
// check client id 
$is_exist_id = $pcs_obj->is_exist("`id`", "`pieces_info`", $client_id);
// condition
if ($client_id != 0 && $is_exist_id) {
  // get client or client info
  $client_data = $pcs_obj->get_pieces("WHERE `pieces_info`.`id` = {$client_id}", 1);
  // check type
  if ($client_data['is_client'] == 0) {
    // redirect to pieces page
    redirect_home(null, $nav_up_level . 'pieces/index.php?do=edit-piece&piece-id=' . base64_encode($client_id), 0);
  }
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start form -->
    <form class="custom-form need-validation" action="?do=update-client-info" method="POST" id="update-client-info" onchange="form_validation(this)">
      <!-- submit -->
      <div class="hstack gap-3">
        <?php if ($_SESSION['sys']['clients_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" form="update-client-info" class="btn btn-primary text-capitalize bg-gradient fs-12 py-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="edit-client-top" onclick="form_validation(this.form, 'submit')">
            <i class="bi bi-check-all"></i>
            <?php echo lang('SAVE') ?>
          </button>
        <?php } ?>

        <?php if ($_SESSION['sys']['mikrotik']['status'] && 0) { ?>
          <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&address=<?php echo $client_data['ip'] ?>&port=<?php !empty($client_data['port']) || $client_data != 0 ? $client_data['port'] : '443' ?>" target='_blank'>
            <?php echo lang('VISIT DEVICE', $lang_file) ?>
          </a>
        <?php } ?>

        <?php if ($_SESSION['sys']['clients_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <!-- delete button -->
          <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteClientModal" data-client-id="<?php echo base64_encode($client_data['id']) ?>" data-client-name="<?php echo $client_data['full_name'] ?>" onclick="confirm_delete_client(this)">
            <i class="bi bi-trash"></i>
            <?php echo lang('DELETE'); ?>
          </button>
        <?php } ?>
      </div>
      <!-- horzontal stack -->
      <div class="hstack gap-3">
        <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
          <span>
            <?php echo lang('*REQUIRED') ?>
          </span>
        </h6>
      </div>
      <!-- start client info -->
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
        <!-- first column -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('CLT INFO', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <!-- client id -->
            <input type="hidden" name="client-id" id="client-id" value="<?php echo base64_encode($client_data['id']) ?>">
            <!-- full name -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="full-name" name="full-name" placeholder="<?php echo lang('CLT NAME', $lang_file) ?>" onblur="fullname_validation(this, <?php echo base64_encode($client_data['id']) ?>)" onblur="fullname_validation(this, <?php echo base64_encode($client_data['id']) ?>)" value="<?php echo $client_data['fullname'] ?>" autocomplete="off" required />
              <label for="full-name">
                <?php echo lang('CLT NAME', $lang_file) ?>
              </label>
            </div>
            <!-- address -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="address" id="address" class="form-control w-100" value="<?php echo $client_data['address'] ?>" placeholder="<?php echo lang('ADDR', $lang_file) ?>" />
              <label for="address">
                <?php echo lang('ADDR', $lang_file) ?>
              </label>
            </div>
            <!-- phone -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="phone-number" id="phone-number" class="form-control w-100" placeholder="<?php echo lang('PHONE', $lang_file) ?>" value="<?php echo $client_data['phone'] ?>" />
              <label for="phone-number">
                <?php echo lang('PHONE', $lang_file) ?>
              </label>
            </div>
            <!-- is client -->
            <div class="mb-sm-2 mb-md-3 row">
              <label for="is-client" class="col-sm-12 col-md-4 col-form-label text-capitalize">
                <?php echo lang('TYPE', 'pieces') ?>
              </label>
              <div class="mt-2 col-sm-12 col-md-8 position-relative">
                <!-- CLIENT -->
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="is-client" id="client" value="0" <?php echo $client_data['is_client'] == 1 ? 'checked' : '' ?>>
                  <label class="form-check-label text-capitalize" for="client">
                    <?php echo lang('CLT', $lang_file) ?>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- additional info -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('ADD INFO', 'pieces') ?>
              </h5>
              <hr />
            </div>

            <!-- internet source -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="coordinates" id="coordinates" class="form-control" placeholder="<?php echo lang('COORDINATES', 'pieces') ?>" value="<?php echo $client_data['coordinates'] ?>" />
              <label for="coordinates">
                <?php echo lang('COORDINATES', 'pieces'); ?>
              </label>
            </div>
            <!-- notes -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100" style="height: 8rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo lang('PUT YOUR NOTES HERE', $lang_file) ?>"><?php echo $client_data['notes'] ?></textarea>
              <label for="notes">
                <?php echo lang('NOTE') ?>
              </label>
            </div>
            <!-- visit time -->
            <div class="mb-3 row">
              <label for="visit-time" class="col-sm-12 col-md-4 col-form-label text-capitalize">
                <?php echo lang('VISIT TIME', 'pieces') ?>
              </label>
              <div class="mt-2 col-sm-12 col-md-8">
                <!-- ANY TIME -->
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="visit-time" id="visit-time-piece" value="1" <?php echo $client_data['visit_time'] == 1 ? 'checked' : '' ?>>
                  <label class="form-check-label text-capitalize" for="visit-time-piece">
                    <?php echo lang('ANY TIME', 'pieces') ?>
                  </label>
                </div>
                <!-- ADVANCE CONNECTION -->
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="visit-time" id="visit-time-client" value="2" <?php echo $client_data['visit_time'] == 2 ? 'checked' : '' ?>>
                  <label class="form-check-label text-capitalize" for="visit-time-client">
                    <?php echo lang('ADV CONN', 'pieces') ?>
                  </label>
                </div>
              </div>
            </div>
            <!-- malfunctions counter -->
            <?php $malCounter = $pcs_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `client_id` = " . $client_data['id']) ?>
            <?php if ($malCounter > 0) { ?>
              <div class="mb-3 row align-items-center">
                <label for="malfunction-counter" class="col-sm-12 col-md-4 col-form-label text-capitalize">
                  <?php echo lang('CLT MALS', $lang_file); ?>
                </label>
                <div class="col-sm-12 col-md-8 position-relative">
                  <span class="me-5 text-start" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
                    <?php echo $malCounter . " " . ($malCounter > 2 ? lang("MALS", 'malfunctions') : lang("MAL", 'malfunctions')) ?>
                  </span>
                  <?php if ($_SESSION['sys']['mal_show']) { ?>
                    <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=show-malfunctions&pieceid=<?php echo base64_encode($client_data['id']) ?>" class="mt-2 text-start" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
                      <?php echo lang("DETAILS") ?>&nbsp;<i class="bi bi-arrow-up-left-square"></i>
                    </a>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- connection info -->
      <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
        <!-- first column -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('CONN INFO', 'pieces') ?>
              </h5>
              <hr />
            </div>
            <div class="row row-cols-sm-1 row-cols-md-2 alignitems-stretch justify-content-start flex-row">
              <!-- first column -->
              <div class="col-12">
                <div class="row row-cols-sm-1">
                  <!-- direction -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <select class="form-select" id="direction" name="direction" required onchange="get_sources(this, <?php echo base64_decode($_SESSION['sys']['company_id']) ?>, '<?php echo $dirs . $_SESSION['sys']['company_name'] ?>', ['sources', 'alternative-sources']);">
                        <option value="default" disabled>
                          <?php echo lang('SELECT DIRECTION', 'directions') ?>
                        </option>
                        <?php
                        // get all directions
                        $dirs_data = $pcs_obj->select_specific_column("*", "`direction`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " ORDER BY `direction_name` ASC");
                        // counter
                        $dirs_count = count($dirs_data);
                        // directions data
                        $dir_data = $dirs_data;
                        // check the row dirs_count
                        if ($dirs_count > 0) { ?>
                          <?php foreach ($dir_data as $dir) { ?>
                            <option value="<?php echo base64_encode($dir['direction_id']) ?>" data-dir-company="<?php echo base64_decode($_SESSION['sys']['company_id']) ?>" <?php echo $client_data['direction_id'] == $dir['direction_id'] ? 'selected' : '' ?>>
                              <?php echo $dir['direction_name'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="direction">
                        <?php echo lang('DIRECTION', 'directions') ?>
                      </label>
                    </div>
                  </div>

                  <!-- source -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <select class="form-select" id="sources" name="source-id" required>
                        <option value="default" disabled>
                          <?php echo lang('SELECT SRC', 'pieces') ?>
                        </option>
                        <?php
                        $condition = "LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id` WHERE `pieces_info`.`direction_id` = " . $client_data['direction_id'] . " AND `pieces_info`.`is_client` = 0 AND `pieces_info`.`company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                        $sources = $pcs_obj->select_specific_column("`pieces_info`.`id`, `pieces_info`.`full_name`, `pieces_info`.`ip`", "`pieces_info`", $condition);
                        // counter
                        $sources_count = count($sources);
                        // directions data
                        $sources_data = $sources;
                        // check the row sources_count
                        if ($sources_count) { ?>
                          <?php foreach ($sources_data as $source) { ?>
                            <option value="<?php echo base64_encode($source['id']) ?>" <?php echo $client_data['source_id'] == $source['id'] || ($client_data['source_id'] == 0 && $client_data['ip'] == $source['ip']) ? 'selected' : '' ?>>
                              <?php echo $source['full_name'] . " - " . $source['ip'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="sources">
                        <?php echo lang('THE SRC', 'pieces') ?>
                      </label>
                    </div>
                  </div>

                  <!-- alternative source -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <select class="form-select" id="alternative-sources" name="alt-source-id">
                        <option value="default" selected disabled>
                          <?php echo lang('SELECT ALT SRC', 'pieces') ?>
                        </option>
                        <?php if ($sources_count) { ?>
                          <?php foreach ($sources_data as $alt_source) { ?>
                            <option value="<?php echo base64_encode($alt_source['id']) ?>" <?php echo $client_data['alt_source_id'] == $alt_source['id'] || ($client_data['alt_source_id'] == 0 && $client_data['ip'] == $alt_source['ip']) ? 'selected' : ''; ?>>
                              <?php echo $alt_source['full_name'] . " - " . $alt_source['ip'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="alternative-sources">
                        <?php echo lang('ALT SRC', 'pieces') ?>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- second column -->
              <div class="col-12">
                <div class="row row-cols-sm-1">
                  <!-- device type -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php
                      $dev_query = "SELECT `devices_info`.*, `manufacture_companies`.`company_id` FROM `devices_info` LEFT JOIN `manufacture_companies` ON `manufacture_companies`.`man_company_id` = `devices_info`.`device_company_id` WHERE `manufacture_companies`.`company_id` = ?;";
                      $stmt = $con->prepare($dev_query);
                      $stmt->execute(array(base64_decode($_SESSION['sys']['company_id'])));
                      $devices_count = $stmt->rowCount();
                      $devices_data = $stmt->fetchAll();
                      ?>
                      <select class="form-select" id="device-id" name="device-id" onchange="get_devices_models(this, '<?php echo $dev_models . $_SESSION['sys']['company_id'] ?>')">
                        <option value="default" disabled selected>
                          <?php echo lang('SELECT DEV TYPE', 'pieces') ?>
                        </option>
                        <?php if ($devices_count > 0) { ?>
                          <?php foreach ($devices_data as $device) { ?>
                            <option value="<?php echo base64_encode($device['device_id']) ?>" <?php echo $client_data['device_id'] == $device['device_id'] ? 'selected' : '' ?>>
                              <?php echo $device['device_name'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <?php if ($devices_count == 0) { ?>
                        <div id="emailHelp" class="form-text text-danger">
                          <?php echo lang('NO DATA') ?>
                        </div>
                      <?php } ?>
                      <label for="device-id">
                        <?php echo lang('DEV TYPE', 'pieces') ?>
                      </label>
                    </div>
                  </div>

                  <!-- device model -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php
                      // get all pieces devices_model
                      $model_query = "SELECT *FROM `devices_model` WHERE `device_id` = ?";
                      $stmt = $con->prepare($model_query);
                      $stmt->execute(array($client_data['device_id']));
                      $model_count = $stmt->rowCount();
                      $models_data = $stmt->fetchAll();
                      ?>
                      <select class="form-select" name="device-model" id="device-model">
                        <option value="default" disabled selected>
                          <?php echo lang('SELECT DEV MODEL', 'pieces') ?>
                        </option>
                        <?php if ($model_count > 0) { ?>
                          <?php foreach ($models_data as $model) { ?>
                            <option value="<?php echo base64_encode($model['model_id']) ?>" <?php echo $client_data['device_model'] == $model['model_id'] ? 'selected' : '' ?>>
                              <?php echo $model['model_name'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="device-model">
                        <?php echo lang('DEV MODEL', 'pieces') ?>
                      </label>
                      <?php if ($model_count == 0 && $client_data['device_model'] > 0) { ?>
                        <div id="emailHelp" class="form-text text-danger">
                          <?php echo lang('NO DATA') ?>
                        </div>
                      <?php } ?>
                    </div>
                  </div>


                  <!-- connection type -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php $conn_type_data = $db_obj->select_specific_column("*", "`connection_types`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
                      <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                        <option value="default" selected disabled>
                          <?php echo lang('SELECT CONN TYPE', 'pieces') ?>
                        </option>
                        <?php if (count($conn_type_data) > 0) { ?>
                          <?php foreach ($conn_type_data as $conn_type_row) { ?>
                            <option value="<?php echo base64_encode($conn_type_row['id']) ?>" <?php echo $client_data['connection_type'] == $conn_type_row['id'] ? 'selected' : '' ?>>
                              <?php echo $conn_type_row['connection_name'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="conn-type">
                        <?php echo lang('CONN TYPE', 'pieces') ?>
                      </label>
                      <?php if (count($conn_type_data) == 0) { ?>
                        <div id="emailHelp" class="form-text text-danger">
                          <?php echo lang('NO DATA') ?>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if (!empty($client_data['coordinates'])) { ?>
          <div class="col-12">
            <div class="section-block">
              <div class="section-header">
                <h5>
                  <?php echo lang('LOCATION', $lang_file) ?>
                </h5>
                <hr />
              </div>

              <div>
                <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                  <style>
                    gmp-map,
                    #map {
                      width: 100%;
                      height: 500px;
                    }

                    .gm-control-active.gm-fullscreen-control {
                      display: block;
                    }
                  </style>
                  <script src="<?php echo $treenet_js ?>map.js"></script>
                  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
                  <script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $conf['map_api_key'] ?>&callback=initMap&libraries=maps,marker&v=weekly"></script>

                  <!-- map -->
                  <div id="map"></div>
                  <script defer async type="text/javascript">
                    // array of markers
                    var markers = [];
                    // initial map
                    async function initMap() {
                      // Request needed libraries.
                      const {
                        Map
                      } = await google.maps.importLibrary("maps");
                      const {
                        AdvancedMarkerElement,
                        PinElement
                      } = await google.maps.importLibrary(
                        "marker",
                      );

                      // initialize map
                      const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 14,
                        center: getLatLong('<?php echo $client_data['coordinates'] ?>'),
                        mapId: '<?php echo $conf['map_id'] ?>',
                        mapTypeId: 'roadmap',
                        mapTypeControlOptions: {
                          mapTypeIds: ['roadmap', 'satellite'],
                        },
                        gestureHandling: "greedy",
                      });

                      // create new marker in the new position
                      let marker = new google.maps.marker.AdvancedMarkerElement({
                        position: getLatLong('<?php echo $client_data['coordinates'] ?>'),
                        map: map,
                        gmpDraggable: true,
                      });

                      // add event when marker draged
                      marker.addListener("dragend", (event) => {
                        const position = marker.position;
                        // put new coordinates into input
                        document.querySelector('#coordinates').value = `${position.lat}, ${position.lng}`;
                      })
                    }
                  </script>
                <?php } else { ?>
                  <p class="lead text-danger">
                    <?php echo lang('FEATURE NOT AVAILABLE') ?>
                  </p>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>

        <!-- second column -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('PCS INFO', 'pieces') ?>
              </h5>
              <hr />
            </div>
            <div class="row row-cols-sm-1 row-cols-md-2 align-items-stretch justify-content-start">
              <!-- first column -->
              <div class="col-12">
                <div class="row row-cols-sm-1 align-items-stretch justify-content-start">
                  <!-- IP -->
                  <div class="col-12">
                    <div class="mb-sm-2 mb-md-3 row">
                      <div class="col-sm-8">
                        <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                          <input type="text" class="form-control" id="ip" name="ip" placeholder="xxx.xxx.xxx.xxx" onblur="ip_validation(this, <?php echo base64_encode($client_data['id']) ?>)" onkeyup="ip_validation(this, <?php echo base64_encode($client_data['id']) ?>)" value="<?php echo $client_data['ip'] ?>" autocomplete="off" required />
                          <label for="ip"><span class="text-uppercase">
                              <?php echo lang('IP') ?>
                            </span></label>
                        </div>
                      </div>
                      <div class="col-sm-4 position-relative">
                        <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                          <input type="number" class="form-control" id="port" name="port" placeholder="port" value="<?php echo $client_data['port'] ?>" autocomplete="off" required />
                          <label for="port">Port</label>
                        </div>
                      </div>
                      <div id="ipHelp" class="form-text text-warning">
                        <span>
                          <?php echo lang('IP NOTE', 'pieces') ?>
                        </span>
                        <span>&nbsp;-&nbsp;</span>
                        <span>
                          <?php echo lang('PORT NOTE', 'pieces') ?>
                        </span>
                      </div>
                    </div>
                  </div>

                  <!-- MAC ADD -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="mac-add" name="mac-add" onblur="mac_validation(this, <?php echo base64_encode($client_data['id']) ?>)" onkeyup="mac_validation(this, <?php echo base64_encode($client_data['id']) ?>)" placeholder="<?php echo lang('MAC') ?>" value="<?php echo $client_data['mac_add'] ?>" />
                      <label for="mac-add">
                        <?php echo lang('MAC') ?>
                      </label>
                    </div>
                  </div>

                  <!-- user name -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="user-name" name="user-name" placeholder="<?php echo lang('USERNAME') ?>" value="<?php echo $client_data['username'] ?>" autocomplete="off" required />
                      <label for="user-name">
                        <?php echo lang('USERNAME') ?>
                      </label>
                    </div>
                  </div>

                  <!-- password -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo lang('PASSWORD') ?>" value="<?php echo $client_data['password'] ?>" autocomplete="off" required />
                      <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="show_pass(this)"></i>
                      <label for="password">
                        <?php echo lang('PASSWORD') ?>
                      </label>
                      <div id="passHelp" class="form-text text-warning ">
                        <?php echo lang('PASS NOTE') ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- second column -->
              <div class="col-12">
                <div class="row row-cols-sm-1">
                  <!-- password-connection -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="password" class="form-control" id="password-connection" name="password-connection" placeholder="<?php echo lang('PASS CONN', 'pieces') ?>" value="<?php echo $client_data['password_connection'] ?>" />
                      <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="show_pass(this)"></i>
                      <label for="password-connection">
                        <?php echo lang('PASS CONN', 'pieces') ?>
                      </label>
                      <div id="passHelp" class="form-text text-warning ">
                        <?php echo lang('PASS NOTE') ?>
                      </div>
                    </div>
                  </div>
                  <!-- ssid -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="ssid" name="ssid" placeholder="<?php echo lang('SSID', 'pieces') ?>" value="<?php echo $client_data['ssid'] ?>" />
                      <label for="ssid">
                        <?php echo lang('SSID', 'pieces') ?>
                      </label>
                    </div>
                  </div>
                  <!-- frequency -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="frequency" name="frequency" placeholder="<?php echo lang('FREQ', 'pieces') ?>" value="<?php echo $client_data['frequency'] ?>" onkeyup="integer_input_validation(this)" onblur="integer_input_validation(this)" />
                      <label for="frequency">
                        <?php echo lang('FREQ', 'pieces') ?>
                      </label>
                    </div>
                  </div>
                  <!-- wave -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="wave" name="wave" placeholder="<?php echo lang('WAVE', 'pieces') ?>" value="<?php echo $client_data['wave'] ?>" onkeyup="integer_input_validation(this)" onblur="integer_input_validation(this)" />
                      <label for="wave">
                        <?php echo lang('WAVE', 'pieces') ?>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- submit -->
      <div class="hstack gap-3">
        <?php if ($_SESSION['sys']['clients_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <button type="button" form="update-client-info" class="btn btn-primary text-capitalize bg-gradient fs-12 py-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="edit-client" onclick="form_validation(this.form, 'submit')">
            <i class="bi bi-check-all"></i>
            <?php echo lang('SAVE') ?>
          </button>
        <?php } ?>

        <?php if ($_SESSION['sys']['mikrotik']['status'] && 0) { ?>
          <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&address=<?php echo $client_data['ip'] ?>&port=<?php echo !empty($client_data['port']) || $client_data['port'] != 0 ? $client_data['port'] : '443' ?>" target='_blank'>
            <?php echo lang('VISIT DEVICE', 'pieces') ?>
          </a>
        <?php } ?>

        <?php if ($_SESSION['sys']['clients_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <!--  delete button -->
          <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteClientModal" data-client-id="<?php echo base64_encode($client_data['id']) ?>" data-client-name="<?php echo $client_data['full_name'] ?>" onclick="confirm_delete_client(this)">
            <i class="bi bi-trash"></i>
            <?php echo lang('DELETE'); ?>
          </button>
        <?php } ?>
      </div>
    </form>
    <!-- end form-->
  </div>
<?php } else {
  // include missing data modeule
  include_once $globmod . "missing-data-no-redirect.php";
}
