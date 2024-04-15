<?php
// get piece id from $_GET variable
$piece_id = isset($_GET['piece-id']) && !empty($_GET['piece-id']) ? base64_decode($_GET['piece-id']) : 0;
// create an object of Piece Class
$pcs_obj =  new Pieces();
// check piece id 
$is_exist_id = $pcs_obj->is_exist("`id`", "`pieces_info`", $piece_id);
// condition
if ($piece_id != 0 && $is_exist_id) {
  // get piece or client info
  $piece_data = $pcs_obj->get_pieces("WHERE `pieces_info`.`id` = {$piece_id}", 1);

  // check type
  if ($piece_data['is_client'] == 1) {
    // redirect to clients page
    redirect_home(null, $nav_up_level . 'clients/index.php?do=edit-client&client-id=' . base64_encode($piece_id), 0);
  }
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start form -->
    <form class="custom-form need-validation" action="?do=update-piece-info" method="POST" id="update-piece-info" onchange="form_validation(this)">
      <div class="hstack gap-3">
        <?php if ($_SESSION['sys']['pcs_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <!-- submit -->
          <button type="button" form="update-piece-info" class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="edit-piece-1" onclick="form_validation(this.form, 'submit')">
            <i class="bi bi-check-all"></i>
            <?php echo lang('SAVE') ?>
          </button>
        <?php } ?>

        <?php if ($_SESSION['sys']['mikrotik']['status'] && 0 && !is_null($piece_data['ip'])) { ?>
          <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&address=<?php echo $piece_data['ip'] ?>&port=<?php echo !empty($piece_data['port']) ? $piece_data['port'] : '' ?>" target='_blank'>
            <?php echo lang('VISIT DEVICE', $lang_file) ?>
          </a>
        <?php } ?>

        <?php if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <!-- delete button -->
          <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal" data-piece-id="<?php echo base64_encode($piece_data['id']) ?>" data-piece-name="<?php echo $piece_data['full_name'] ?>" data-page-title="<?php echo $page_title ?>" onclick="confirm_delete_piece(this)">
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
      <!-- start piece info -->
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
        <!-- first column -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('PCS INFO', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <!-- piece id -->
            <input type="hidden" name="piece-id" id="piece-id" value="<?php echo base64_encode($piece_data['id']) ?>">
            <!-- full name -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" id="full-name" name="full-name" placeholder="<?php echo lang('PCS NAME', $lang_file) ?>" onblur="fullname_validation(this, '<?php echo base64_encode($piece_data['id']) ?>')" onblur="fullname_validation(this, '<?php echo base64_encode($piece_data['id']) ?>')" value="<?php echo $piece_data['full_name'] ?>" autocomplete="off" required />
              <label for="full-name">
                <?php echo lang('PCS NAME', $lang_file) ?>
              </label>
            </div>
            <!-- address -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="address" id="address" class="form-control w-100" value="<?php echo $piece_data['address'] ?>" placeholder="<?php echo lang('PROP ADDR', $lang_file) ?>" />
              <label for="address">
                <?php echo lang('PROP ADDR', $lang_file) ?>
              </label>
            </div>
            <!-- phone -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="phone-number" id="phone-number" class="form-control w-100" placeholder="<?php echo lang('AGENT PHONE', $lang_file) ?>" value="<?php echo $piece_data['phone'] ?>" />
              <label for="phone-number">
                <?php echo lang('AGENT PHONE', $lang_file) ?>
              </label>
            </div>

            <!-- is client -->
            <div class="mb-3 row">
              <label for="is-client" class="col-sm-12 col-md-4 col-form-label text-capitalize">
                <?php echo lang('TYPE', $lang_file) ?>
              </label>
              <div class="mt-2 col-sm-12 col-md-8 position-relative">
                <!-- TRANSMITTER -->
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="is-client" id="transmitter" value="1" <?php echo $piece_data['is_client'] == 0 && $piece_data['device_type'] == 1 ? 'checked' : '' ?>>
                  <label class="form-check-label text-capitalize" for="transmitter">
                    <?php echo lang('TRANSMITTER', $lang_file) ?>
                  </label>
                </div>
                <!-- RECEIVER -->
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="is-client" id="receiver" value="2" <?php echo $piece_data['is_client'] == 0 && $piece_data['device_type'] == 2 ? 'checked' : '' ?>>
                  <label class="form-check-label text-capitalize" for="receiver">
                    <?php echo lang('RECEIVER', $lang_file) ?>
                  </label>
                </div>
                <?php if ($piece_data['is_client'] == -1) { ?>
                  <!-- CLIENT -->
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is-client" id="client" value="0">
                    <label class="form-check-label text-capitalize" for="client">
                      <?php echo lang('CLT', 'clients') ?>
                    </label>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <!-- additional info -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('ADD INFO', $lang_file) ?>
              </h5>
              <hr />
            </div>

            <!-- coordinates -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="coordinates" id="coordinates" class="form-control" placeholder="<?php echo lang('COORDINATES', $lang_file) ?>" value="<?php echo $piece_data['coordinates'] ?>" />
              <label for="coordinates">
                <?php echo lang('COORDINATES', $lang_file); ?>
              </label>
            </div>

            <!-- notes -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100" style="height: 8rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo lang('NOTE') ?>"><?php echo $piece_data['notes'] ?></textarea>
              <label for="notes">
                <?php echo lang('NOTE') ?>
              </label>
            </div>
            <!-- visit time -->
            <div class="mb-3 row">
              <label for="visit-time" class="col-sm-12 col-md-4 col-form-label text-capitalize">
                <?php echo lang('VISIT TIME', $lang_file) ?>
              </label>
              <div class="mt-2 col-sm-12 col-md-8">
                <!-- ANY TIME -->
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="visit-time" id="visit-time-piece" value="1" <?php echo $piece_data['visit_time'] == 1 ? 'checked' : '' ?>>
                  <label class="form-check-label text-capitalize" for="visit-time-piece">
                    <?php echo lang('ANY TIME', $lang_file) ?>
                  </label>
                </div>
                <!-- ADVANCE CONNECTION -->
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="visit-time" id="visit-time-client" value="2" <?php echo $piece_data['visit_time'] == 2 ? 'checked' : '' ?>>
                  <label class="form-check-label text-capitalize" for="visit-time-client">
                    <?php echo lang('ADV CONN', $lang_file) ?>
                  </label>
                </div>
              </div>
            </div>
            <!-- malfunctions counter -->
            <?php $malCounter = $pcs_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `client_id` = " . $piece_data['id']) ?>
            <?php if ($malCounter > 0) { ?>
              <div class="mb-3 row align-items-center">
                <label for="malfunction-counter" class="col-sm-12 col-md-4 col-form-label text-capitalize">
                  <?php echo lang('PCS MALS', $lang_file); ?>
                </label>
                <div class="col-sm-12 col-md-8 position-relative">
                  <span class="me-5 text-start" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
                    <?php echo $malCounter . " " . ($malCounter > 2 ? lang("MALS", 'malfunctions') : lang("MAL", 'malfunctions')) ?>
                  </span>
                  <?php if ($_SESSION['sys']['mal_show']) { ?>
                    <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=show-malfunctions&pieceid=<?php echo base64_encode($piece_data['id']) ?>" class="mt-2 text-start" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
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
                <?php echo lang('CONN INFO', $lang_file) ?>
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
                      <select class="form-select" id="direction" name="direction" required onchange="get_sources(this, <?php echo base64_decode($_SESSION['sys']['company_id']) ?>, '<?php echo $dirs . $_SESSION['sys']['company_id'] ?>', ['sources', 'alternative-sources']);">
                        <option value="default" disabled>
                          <?php echo lang('SELECT DIRECTION', 'directions') ?>
                        </option>
                        <?php
                        // get all directions
                        $dirs_data = $pcs_obj->select_specific_column("*", "`direction`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " ORDER BY `direction_name` ASC", 'multiple');
                        // check the row dirs_count
                        if (!is_null($dirs_data)) { ?>
                          <?php foreach ($dirs_data as $dir) { ?>
                            <option value="<?php echo base64_encode($dir['direction_id']) ?>" data-dir-company="<?php echo base64_decode($_SESSION['sys']['company_id']) ?>" <?php echo $piece_data['direction_id'] == $dir['direction_id'] ? 'selected' : '' ?>>
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
                          <?php echo lang('SELECT SRC', $lang_file) ?>
                        </option>
                        <?php
                        $condition = is_null($piece_data['direction_id']) ? "WHERE `pieces_info`.`is_client` = 0 AND `pieces_info`.`company_id` = " . base64_decode($_SESSION['sys']['company_id']) : "LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id` WHERE `pieces_info`.`direction_id` = " . $piece_data['direction_id'] . " AND `pieces_info`.`is_client` = 0 AND `pieces_info`.`company_id` = " . base64_decode($_SESSION['sys']['company_id']);
                        $sources_data = is_null($piece_data['direction_id']) ? null : $pcs_obj->select_specific_column("`pieces_info`.`id`, `pieces_info`.`full_name`, `pieces_info`.`ip`", "`pieces_info`", $condition, 'multiple');
                        // check the row sources_count
                        if (!is_null($sources_data)) { ?>
                          <?php foreach ($sources_data as $source) { ?>
                            <option value="<?php echo base64_encode($source['id']) ?>" <?php echo $piece_data['source_id'] == $source['id'] || ($piece_data['source_id'] == 0 && $piece_data['ip'] == $source['ip']) ? 'selected' : '' ?>>
                              <?php echo $source['full_name'] . " - " . $source['ip'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="sources">
                        <?php echo lang('THE SRC', $lang_file) ?>
                      </label>
                    </div>
                  </div>

                  <!-- alternative source -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <select class="form-select" id="alternative-sources" name="alt-source-id">
                        <option value="default" selected disabled>
                          <?php echo lang('SELECT ALT SRC', $lang_file) ?>
                        </option>
                        <?php if (!is_null($sources_data)) { ?>
                          <?php foreach ($sources_data as $alt_source) { ?>
                            <option value="<?php echo base64_encode($alt_source['id']) ?>" <?php echo $piece_data['alt_source_id'] == $alt_source['id'] || ($piece_data['alt_source_id'] == 0 && $piece_data['ip'] == $alt_source['ip']) ? 'selected' : ''; ?>>
                              <?php echo $alt_source['full_name'] . (!is_null($alt_source['ip']) ? " - " . $alt_source['ip'] : null) ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="alternative-sources">
                        <?php echo lang('ALT SRC', $lang_file) ?>
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
                          <?php echo lang('SELECT DEV TYPE', $lang_file) ?>
                        </option>
                        <?php if ($devices_count > 0) { ?>
                          <?php foreach ($devices_data as $device) { ?>
                            <option value="<?php echo base64_encode($device['device_id']) ?>" <?php echo $piece_data['device_id'] == $device['device_id'] ? 'selected' : '' ?>>
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
                        <?php echo lang('DEV TYPE', $lang_file) ?>
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
                      $stmt->execute(array($piece_data['device_id']));
                      $model_count = $stmt->rowCount();
                      $models_data = $stmt->fetchAll();
                      ?>
                      <select class="form-select" name="device-model" id="device-model">
                        <option value="default" disabled selected>
                          <?php echo lang('SELECT DEV MODEL', $lang_file) ?>
                        </option>
                        <?php if ($model_count > 0) { ?>
                          <?php foreach ($models_data as $model) { ?>
                            <option value="<?php echo base64_encode($model['model_id']) ?>" <?php echo $piece_data['device_model'] == $model['model_id'] ? 'selected' : '' ?>>
                              <?php echo $model['model_name'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="device-model">
                        <?php echo lang('DEV MODEL', $lang_file) ?>
                      </label>
                      <?php if ($model_count == 0 && $piece_data['device_model'] > 0) { ?>
                        <div id="emailHelp" class="form-text text-danger">
                          <?php echo lang('NO DATA') ?>
                        </div>
                      <?php } ?>
                    </div>
                  </div>

                  <!-- connection type -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php $conn_type_data = $db_obj->select_specific_column("*", "`connection_types`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']), 'multiple'); ?>
                      <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                        <option value="default" selected disabled>
                          <?php echo lang('SELECT CONN TYPE', $lang_file) ?>
                        </option>
                        <?php if (!is_null($conn_type_data)) { ?>
                          <?php foreach ($conn_type_data as $conn_type_row) { ?>
                            <option value="<?php echo base64_encode($conn_type_row['id']) ?>" <?php echo $piece_data['connection_type'] == $conn_type_row['id'] ? 'selected' : '' ?>>
                              <?php echo $conn_type_row['connection_name'] ?>
                            </option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                      <label for="conn-type">
                        <?php echo lang('CONN TYPE', $lang_file) ?>
                      </label>
                      <?php if (is_null($conn_type_data)) { ?>
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

        <?php if (!empty($piece_data['coordinates'])) { ?>
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
                  <script src="<?php echo $js ?>map.js"></script>
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
                        center: getLatLong('<?php echo $piece_data['coordinates'] ?>'),
                        mapId: '<?php echo $conf['map_id'] ?>',
                        mapTypeId: 'roadmap',
                        mapTypeControlOptions: {
                          mapTypeIds: ['roadmap', 'satellite'],
                        },
                        gestureHandling: "greedy",
                      });

                      // create new marker in the new position
                      let marker = new google.maps.marker.AdvancedMarkerElement({
                        position: getLatLong('<?php echo $piece_data['coordinates'] ?>'),
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

        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('ADD INFO', $lang_file) ?>
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
                          <input type="text" class="form-control" id="ip" name="ip" placeholder="xxx.xxx.xxx.xxx" onblur="ip_validation(this, <?php echo base64_encode($piece_data['id']) ?>)" onkeyup="ip_validation(this, <?php echo base64_encode($piece_data['id']) ?>)" value="<?php echo $piece_data['ip'] ?>" autocomplete="off" required />
                          <label for="ip"><span class="text-uppercase">
                              <?php echo lang('IP') ?>
                            </span></label>
                        </div>
                      </div>
                      <div class="col-sm-4 position-relative">
                        <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                          <input type="number" class="form-control" id="port" name="port" placeholder="port" value="<?php echo $piece_data['port'] ?>" autocomplete="off" required />
                          <label for="port">Port</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- MAC ADD -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="mac-add" name="mac-add" onblur="mac_validation(this, <?php echo base64_encode($piece_data['id']) ?>)" onkeyup="mac_validation(this, <?php echo base64_encode($piece_data['id']) ?>)" placeholder="<?php echo lang('MAC') ?>" value="<?php echo $piece_data['mac_add'] ?>" />
                      <label for="mac-add">
                        <?php echo lang('MAC') ?>
                      </label>
                    </div>
                  </div>

                  <!-- user name -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="user-name" name="user-name" placeholder="<?php echo lang('USERNAME') ?>" value="<?php echo $piece_data['username'] ?>" autocomplete="off" required />
                      <label for="user-name">
                        <?php echo lang('USERNAME') ?>
                      </label>
                    </div>
                  </div>

                  <!-- password -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo lang('PASSWORD') ?>" value="<?php echo $piece_data['password'] ?>" autocomplete="off" required />
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
                      <input type="password" class="form-control" id="password-connection" name="password-connection" placeholder="<?php echo lang('PASS CONN', $lang_file) ?>" value="<?php echo $piece_data['password_connection'] ?>" />
                      <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="show_pass(this)"></i>
                      <label for="password-connection">
                        <?php echo lang('PASS CONN', $lang_file) ?>
                      </label>
                    </div>
                  </div>
                  <!-- ssid -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="ssid" name="ssid" placeholder="<?php echo lang('SSID', $lang_file) ?>" value="<?php echo $piece_data['ssid'] ?>" />
                      <label for="ssid">
                        <?php echo lang('SSID', $lang_file) ?>
                      </label>
                    </div>
                  </div>
                  <!-- frequency -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="frequency" name="frequency" placeholder="<?php echo lang('FREQ', $lang_file) ?>" value="<?php echo $piece_data['frequency'] ?>" onkeyup="integer_input_validation(this)" onblur="integer_input_validation(this)" />
                      <label for="frequency">
                        <?php echo lang('FREQ', $lang_file) ?>
                      </label>
                    </div>
                  </div>
                  <!-- wave -->
                  <div class="col-12">
                    <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" class="form-control" id="wave" name="wave" placeholder="<?php echo lang('WAVE', $lang_file) ?>" value="<?php echo $piece_data['wave'] ?>" onkeyup="integer_input_validation(this)" onblur="integer_input_validation(this)" />
                      <label for="wave">
                        <?php echo lang('WAVE', $lang_file) ?>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="hstack gap-3">
        <?php if ($_SESSION['sys']['pcs_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <!-- submit -->
          <button type="button" form="update-piece-info" class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="edit-piece-2" onclick="form_validation(this.form, 'submit')">
            <i class="bi bi-check-all"></i>
            <?php echo lang('SAVE') ?>
          </button>
        <?php } ?>

        <?php if ($_SESSION['sys']['mikrotik']['status'] && 0) { ?>
          <a class="btn btn-outline-primary fs-12 w-auto py-1 px-2" href="?do=prepare-ip&address=<?php echo $piece_data['ip'] ?>&port=<?php echo $piece_data['port'] != 0 || !empty($piece_data['port']) ? $piece_data['port'] : '443' ?>" target='_blank'>
            <?php echo lang('VISIT DEVICE', $lang_file) ?>
          </a>
        <?php } ?>

        <?php if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <!-- delete button -->
          <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deletePieceModal" data-piece-id="<?php echo base64_encode($piece_data['id']) ?>" data-piece-name="<?php echo $piece_data['full_name'] ?>" data-page-title="<?php echo $page_title ?>" onclick="confirm_delete_piece(this)">
            <i class="bi bi-trash"></i>
            <?php echo lang('DELETE'); ?>
          </button>
        <?php } ?>
      </div>
    </form>
    <!-- end form -->
  </div>
<?php } else {
  // include missing data modeule
  include_once $globmod . "missing-data-no-redirect.php";
}
