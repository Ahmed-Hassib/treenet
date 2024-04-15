<!-- start add new user page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start form -->
  <form class="custom-form" action="?do=insert-client-info" method="POST" id="addClient" onchange="form_validation(this)">
    <!-- submit -->
    <div class="hstack gap-3">
      <?php if ($_SESSION['sys']['clients_add'] == 1) { ?>
        <button type="button" form="addClient" class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="add-clt-1" onclick="form_validation(this.form, 'submit')">
          <i class="bi bi-plus"></i>
          <?php echo lang('ADD NEW', $lang_file); ?>
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
              <?php echo lang('CLT INFO', $lang_file); ?>
            </h5>
            <hr />
          </div>
          <!-- full name -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" class="form-control" id="full-name" name="full-name" placeholder="<?php echo lang('CLT NAME', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['full-name'] : null ?>" onblur="fullname_validation(this)" autocomplete="off" required />
            <label for="full-name">
              <?php echo lang('CLT NAME', $lang_file); ?>
            </label>
          </div>

          <!-- address -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" name="address" id="address" class="form-control w-100" placeholder="<?php echo lang('ADDR', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['address'] : null ?>" />
            <label for="address">
              <?php echo lang('ADDR', $lang_file); ?>
            </label>
          </div>

          <!-- phone -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" name="phone-number" id="phone-number" class="form-control w-100" placeholder="<?php echo lang('PHONE', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['phone-number'] : null ?>" />
            <label for="phone-number">
              <?php echo lang('PHONE', $lang_file); ?>
            </label>
          </div>

          <!-- is client -->
          <div class="mb-3 row">
            <label for="is-client" class="col-sm-4 col-form-label text-capitalize">
              <?php echo lang('TYPE', 'pieces') ?>
            </label>
            <div class="mt-2 col-sm-8">
              <!-- CLIENT -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is-client" id="client" value="0" checked>
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
          <div class="mb-3">
            <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="coordinates" id="coordinates" class="form-control w-100" placeholder="<?php echo lang('COORDINATES', 'pieces') ?>" />
              <label for="coordinates" class="col-sm-12 col-form-label text-capitalize">
                <?php echo lang('COORDINATES', 'pieces'); ?>
              </label>
            </div>
          </div>

          <!-- notes -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <textarea name="notes" id="notes" title="put some notes hete if exist" class="form-control w-100" style="height: 10rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo lang('NOTE') ?>">
              <?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['notes'] : null ?>
            </textarea>
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
                <input class="form-check-input" type="radio" name="visit-time" id="visit-time-piece" value="1" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['visit-time'] == 1 ? 'checked' : null ?>>
                <label class="form-check-label text-capitalize" for="visit-time-piece">
                  <?php echo lang('ANY TIME', 'pieces') ?>
                </label>
              </div>
              <!-- ADVANCE CONNECTION -->
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="visit-time" id="visit-time-client" value="2" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['visit-time'] == 2 ? 'checked' : null ?>>
                <label class="form-check-label text-capitalize" for="visit-time-client">
                  <?php echo lang('ADV CONN', 'pieces') ?>
                </label>
              </div>
            </div>
          </div>
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
                    <select class="form-select" id="direction" name="direction" required onchange="get_sources(this, '<?php echo $_SESSION['sys']['company_id'] ?>', '<?php echo $dirs . $_SESSION['sys']['company_id'] ?>', ['sources', 'alternative-sources']);">
                      <?php
                      // create an object of Direction class
                      $dir_obj = !isset($dir_obj) ? new Direction() : $dir_obj;
                      // get all directions
                      $dirs = $dir_obj->get_all_directions(base64_decode($_SESSION['sys']['company_id']));
                      // check the row dirs_count
                      if (!is_null($dirs)) {
                        // counter
                        $dirs_count = count($dirs);
                        // directions data
                        $dir_data = $dirs;
                      ?>
                        <option value="default" disabled selected>
                          <?php echo lang('SELECT DIRECTION', 'directions') ?>
                        </option>
                        <?php foreach ($dir_data as $dir) { ?>
                          <option value="<?php echo base64_encode($dir['direction_id']) ?>" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['direction'] == base64_encode($dir['direction_id']) ? 'selected' : null ?> data-dir-company="<?php echo $_SESSION['sys']['company_id'] ?>">
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
                </div>

                <!-- source -->
                <div class="col-12">
                  <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <select class="form-select" id="sources" name="source-id" required>
                      <option value="default" selected disabled>
                        <?php echo lang('SELECT SRC', 'pieces') ?>
                      </option>
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
                      <?php if ($devices_count > 0) { ?>
                        <option value="default" disabled selected>
                          <?php echo lang('SELECT DEV TYPE', 'pieces') ?>
                        </option>
                        <?php foreach ($devices_data as $device) { ?>
                          <option value="<?php echo base64_encode($device['device_id']) ?>" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['device-id'] == base64_encode($device['device_id']) ? 'selected' : null ?>>
                            <?php echo $device['device_name'] ?>
                          </option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <label for="device-id">
                      <?php echo lang('DEV TYPE', 'pieces') ?>
                    </label>
                    <?php if ($devices_count == 0) { ?>
                      <span class="text-danger fs-12">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?php echo lang('NO DATA') ?>
                      </span>
                    <?php } ?>
                  </div>
                </div>

                <!-- device model -->
                <div class="col-12">
                  <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <select class="form-select" name="device-model" id="device-model">
                      <option value="default" disabled selected>
                        <?php echo lang('SELECT DEV MODEL', 'pieces') ?>
                      </option>
                    </select>
                    <label for="device-model">
                      <?php echo lang('DEV MODEL', 'pieces') ?>
                    </label>
                  </div>
                </div>

                <!-- connection type -->
                <div class="col-12">
                  <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <?php $conn_type_data = $db_obj->select_specific_column("*", "`connection_types`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']), 'multiple'); ?>
                    <select class="form-select text-uppercase" name="conn-type" id="conn-type">
                      <option value="default" selected disabled>
                        <?php echo lang('SELECT CONN TYPE', 'pieces') ?>
                      </option>
                      <?php if (!is_null($conn_type_data)) { ?>
                        <?php foreach ($conn_type_data as $conn_type_row) { ?>
                          <option value='<?php echo $conn_type_row['id'] ?>'>
                            <?php echo $conn_type_row['connection_name'] ?>
                          </option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <label for="conn-type">
                      <?php echo lang('CONN TYPE', 'pieces') ?>
                    </label>
                    <?php if (is_null($conn_type_data)) { ?>
                      <span class="text-danger fs-12">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?php echo lang('NO DATA') ?>
                      </span>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- second column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('PCS CLT INFO', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <div class="row row-cols-sm-1 row-cols-md-2 align-items-stretch justify-content-start">
            <!-- first column -->
            <div class="col-12">
              <div class="row row-cols-sm-1 align-items-stretch justify-content-start">
                <!-- IP -->
                <div class="col-12">
                  <div class="mb-3 row g-3">
                    <div class="col-sm-8">
                      <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                        <input type="text" class="form-control" id="ip" name="ip" placeholder="xxx.xxx.xxx.xxx" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['ip'] : null ?>" autocomplete="off" required />
                        <label for="ip"><span class="text-uppercase">
                            <?php echo lang('IP') ?>
                          </span></label>
                      </div>
                    </div>
                    <div class="col-sm-4 position-relative">
                      <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                        <input type="text" class="form-control" id="port" name="port" placeholder="port" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['port'] : null ?>" autocomplete="off" required />
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
                    <input type="text" class="form-control" id="mac-add" name="mac-add" onblur="mac_validation(this)" placeholder="<?php echo lang('MAC') ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['mac-add'] : null ?>" />
                    <label for="mac-add">
                      <?php echo lang('MAC') ?>
                    </label>
                  </div>
                </div>

                <!-- user name -->
                <div class="col-12">
                  <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="text" class="form-control" id="user-name" name="user-name" placeholder="<?php echo lang('USERNAME') ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['user-name'] : null ?>" autocomplete="off" required />
                    <label for="user-name">
                      <?php echo lang('USERNAME') ?>
                    </label>
                  </div>
                </div>

                <!-- password -->
                <div class="col-12">
                  <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo lang('PASSWORD') ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['password'] : null ?>" autocomplete="off" required />
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
                    <input type="password" class="form-control" id="password-connection" name="password-connection" placeholder="<?php echo lang('PASS CONN', 'pieces') ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['password-connection'] : null ?>" />
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
                    <input type="text" class="form-control" id="ssid" name="ssid" placeholder="<?php echo lang('SSID', 'pieces') ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['ssid'] : null ?>" />
                    <label for="ssid">
                      <?php echo lang('SSID', 'pieces') ?>
                    </label>
                  </div>
                </div>
                <!-- frequency -->
                <div class="col-12">
                  <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="text" class="form-control" id="frequency" name="frequency" placeholder="<?php echo lang('FREQ', 'pieces') ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['frequency'] : null ?>" onkeyup="integer_input_validation(this)" />
                    <label for="frequency">
                      <?php echo lang('FREQ', 'pieces') ?>
                    </label>
                  </div>
                </div>
                <!-- wave -->
                <div class="col-12">
                  <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="text" class="form-control" id="wave" name="wave" placeholder="<?php echo lang('WAVE', 'pieces') ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['wave'] : null ?>" onkeyup="integer_input_validation(this)" />
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
        <button type="button" form="addClient" class="btn btn-primary text-capitalize bg-gradient fs-12 p-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="add-clt-2" onclick="form_validation(this.form, 'submit')">
          <i class="bi bi-plus"></i>
          <?php echo lang('ADD NEW', $lang_file); ?>
        </button>
      <?php } ?>
    </div>
  </form>
  <!-- end form -->
</div>

<?php
if (isset($_SESSION['request_data']) && !empty($_SESSION['request_data'])) {
  unset($_SESSION['request_data']);
}
?>