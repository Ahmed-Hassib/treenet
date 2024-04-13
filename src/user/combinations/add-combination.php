<?php
// create an object of Database class
$users_obj = new User();
// get counter of employees, clients and pieces
$emp_counter = $users_obj->count_records("`UserID`", "`users`", "WHERE `is_tech` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
// check the permission
if ($_SESSION['sys']['comb_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
  // check technical counter
  if ($emp_counter > 0) {
?>
    <!-- start add new user page -->
    <div class="container" dir="<?php echo $page_dir ?>">
      <!-- start form -->
      <form class="mb-3 custom-form" action="?do=insert-combination-info" method="POST" id="add-new-combination" onchange="form_validation(this)">
        <!-- horzontal stack -->
        <div class="vstack gap-1">
          <!-- note for required inputs -->
          <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
            <span>
              <?php echo lang('*REQUIRED') ?>
            </span>
          </h6>
        </div>
        <div class="add-combination-container">
          <div class="row g-3">
            <!-- responsible for combination -->
            <div class="col-sm-12">
              <div class="section-block">
                <div class="section-header">
                  <h5>
                    <?php echo lang('RESP COMB', $lang_file) ?>
                  </h5>
                  <hr />
                </div>
                <!-- Administrator name -->
                <div class="mb-3 form-floating">
                  <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $_SESSION['sys']['UserID'] ?>" autocomplete="off" required />
                  <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="<?php echo lang('ADMIN NAME', $lang_file) ?>" value="<?php echo $_SESSION['sys']['username'] ?>" autocomplete="off" required readonly />
                  <label for="admin-name">
                    <?php echo lang('ADMIN NAME', $lang_file) ?>
                  </label>
                </div>
                <!-- Technical name -->
                <div class="mb-3 form-floating">
                  <select class="form-select" id="technical-id" name="technical-id">
                    <option value="default" disabled selected>
                      <?php echo lang('SELECT TECH NAME', $lang_file) ?>
                    </option>
                    <?php
                    // get Employees ID and Names
                    $usersRows = $users_obj->get_all_users(base64_decode($_SESSION['sys']['company_id']), "AND `is_tech` = 1 AND `job_title_id` = 2 ");
                    // check the length of result
                    if (count($usersRows) > 0) {
                      // loop on result ..
                      foreach ($usersRows as $userRow) { ?>
                        <option value="<?php echo base64_encode($userRow['UserID']) ?>" <?php echo isset($_SESSION['request_data']) && base64_decode($_SESSION['request_data']['technical-id']) == $userRow['UserID'] ? 'selected' : '' ?>>
                          <?php echo $userRow['fullname'] . " (" . $userRow['username'] . ")"; ?>
                        </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                  <label for="technical-id">
                    <?php echo lang('TECH NAME', $lang_file) ?>
                  </label>
                </div>
              </div>
            </div>
            <!-- client coordinates -->
            <div class="col-sm-12">
              <div class="section-block">
                <div class="section-header">
                  <h5>
                    <?php echo lang('COORDINATES', 'pieces') ?>
                  </h5>
                  <hr />
                </div>
                <div class="mb-3 form-floating">
                  <input type="text" class="form-control" id="coordinates" name="coordinates" placeholder="<?php echo lang('COORDINATES', 'pieces') ?>" required />
                  <label for="coordinates">
                    <?php echo lang('COORDINATES', 'pieces') ?>
                  </label>
                </div>

                <!-- <div class="<?php echo $page_dir == 'rtl' ? 'text-start' : 'text-end' ?>">
                <button type="button" class="btn btn-outline-primary" onclick="check_devices_destance('coordinates')">
                  <i class="bi bi-bullseye"></i>
                  <?php echo lang('NEARBY DEVICES', 'pieces') ?>
                </button>
              </div> -->
              </div>
            </div>
          </div>

          <!-- beneficiary info -->
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('BENEFICIARY INFO', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <!-- client-nameme -->
            <div class="mb-3 form-floating">
              <input type="text" class="form-control" name="client-name" placeholder="<?php echo lang('BENEFICIARY NAME', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-name'] : '' ?>" required onkeyup="fullname_validation(this, null, true);">
              <label for="client-name">
                <?php echo lang('BENEFICIARY NAME', $lang_file) ?>
              </label>
            </div>
            <!-- phone -->
            <div class="mb-3 form-floating">
              <input type="text" name="client-phone" id="client-phone" class="form-control w-100" placeholder="<?php echo lang('PHONE', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-phone'] : '' ?>" required />
              <label for="client-phone">
                <?php echo lang('PHONE', $lang_file) ?>
              </label>
            </div>
            <!-- address -->
            <div class="mb-3 form-floating">
              <input type="text" name="client-address" id="client-address" class="form-control w-100" placeholder="<?php echo lang('ADDR', $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-address'] : '' ?>" required />
              <label for="client-address">
                <?php echo lang('ADDR', $lang_file) ?>
              </label>
            </div>
            <!-- notes -->
            <div class="mb-3 form-floating">
              <textarea type="text" name="client-notes" id="client-notes" class="form-control w-100" style="resize: none;height:120px;" placeholder="<?php echo lang('NOTE') ?>" style="resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" required><?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['client-notes'] : '' ?></textarea>
              <label for="client-notes">
                <?php echo lang('NOTE') ?>
              </label>
            </div>
          </div>
        </div>

        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize"><?php echo lang('LOCATION') ?></h5>
            <hr>
          </header>
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
                // coordinates
                var coordinates_input = document.querySelector('#coordinates');
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
                    center: {
                      lat: <?php echo $conf['map']['lat'] ?>,
                      lng: <?php echo $conf['map']['lng'] ?>
                    },
                    mapId: '<?php echo $conf['map_id'] ?>',
                    mapTypeId: 'roadmap',
                    mapTypeControlOptions: {
                      mapTypeIds: ['roadmap', 'satellite'],
                    },
                    gestureHandling: "greedy",
                  });

                  map.addListener("click", (e) => {
                    placeMarkerAndPanTo(e.latLng, map);
                  });

                  coordinates_input.addEventListener('change', (e) => {
                    // get value
                    let value = e.target.value;
                    // check value
                    if (value == '') {
                      // remove all markers
                      setMapOnAll(null);
                    } else {
                      placeMarkerAndPanTo(getLatLong(e.target.value), map);
                    }
                  })
                }

                function placeMarkerAndPanTo(latLng, map) {
                  // remove all markers
                  setMapOnAll(null);

                  // create new marker in the new position
                  let marker = new google.maps.marker.AdvancedMarkerElement({
                    position: latLng,
                    map: map,
                    gmpDraggable: true,
                  });

                  marker.addListener("dragend", (event) => {
                    const position = marker.position;
                    // put new coordinates into input
                    coordinates_input.value = `${position.lat}, ${position.lng}`;
                  })

                  // push marker into an array
                  markers.push(marker)

                  // put new coordinates into input
                  coordinates_input.value = typeof latLng.lat == 'function' ? `${latLng.lat()}, ${latLng.lng()}` : `${latLng.lat}, ${latLng.lng}`;

                  // recenter map
                  map.panTo(latLng);
                }
              </script>
            <?php } else { ?>
              <p class="lead text-danger">
                <?php echo lang('FEATURE NOT AVAILABLE') ?>
              </p>
            <?php } ?>
          </div>
        </div>
        <!-- submit -->
        <div class="mt-3 hstack gap-2">
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="button" form="add-new-combination" style="min-width: 150px" class="btn btn-primary text-capitalize form-control bg-gradient fs-12" id="add-combination" onclick="form_validation(this.form, 'submit')">
              <?php echo lang('ADD') ?>
            </button>
          </div>
        </div>
      </form>
      <!-- end form -->
    </div>

    <!-- <script>
      async function check_devices_destance(input_id) {
        // get input
        let input = document.querySelector(`#${input_id}`);
        distance = []
        // check input value
        if (input.value != '') {
          return new Promise((resolve, reject) => {
            // request fro get encoded id
            $.post('devices-distance.php', {
              company_id: '<?php echo $_SESSION['sys']['company_id'] ?>',
              coordinates: getLatLong(input.value)
            }, (result) => {
              // converted result
              let converted_res = JSON.parse(result);
              // check result
              if (converted_res != null && converted_res.length > 0) {

                let origin_coordinates = getLatLong(input.value)
                // loop on data
                converted_res.forEach((element, key_) => {
                  // console.log(element, origin_coordinates, haversine_distance(origin_coordinates, element.coordinates))

                  element.distance = Math.floor(haversine_distance(origin_coordinates, element.coordinates))
                });
              }

              // 
              distance = converted_res
            })

            resolve("promise kept")
            reject("promise rejected")
          })
          console.log(distance)
        }
      }

      function haversine_distance(origin, distenation) {
        var R = 6371071.0272; // Radius of the Earth in meters
        var rlat1 = origin.lat * (Math.PI / 180); // Convert degrees to radians
        var rlat2 = distenation.lat * (Math.PI / 180); // Convert degrees to radians
        var difflat = rlat2 - rlat1; // Radian difference (latitudes)
        var difflon = (distenation.lng - origin.lng) * (Math.PI / 180); // Radian difference (longitudes)

        var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat / 2) * Math.sin(difflat / 2) + Math.cos(rlat1) * Math.cos(rlat2) * Math.sin(difflon / 2) * Math.sin(difflon / 2)));
        return d;
      }
    </script> -->
<?php
  } else {
    // prepare flash session variables
    $_SESSION['flash_message'] = '*TECH REQUIRED';
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = false;
    $_SESSION['flash_message_lang_file'] = 'global_';
    // redirect to the previous page
    redirect_home(null, 'back', 0);
  }
} else {
  // prepare flash session variables
  $_SESSION['flash_message'][0] = 'FEATURE NOT AVAILABLE';
  $_SESSION['flash_message_icon'][0] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'][0] = 'danger';
  $_SESSION['flash_message_status'][0] = false;
  $_SESSION['flash_message_lang_file'][0] = 'global_';
  // prepare flash session variables
  $_SESSION['flash_message'][1] = 'PERMISSION ERROR';
  $_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'][1] = 'danger';
  $_SESSION['flash_message_status'][1] = false;
  $_SESSION['flash_message_lang_file'][1] = 'global_';
  // redirect to the previous page
  redirect_home(null, 'back', 0);
}

// remove previous data
if (isset($_SESSION['request_data']) && !empty($_SESSION['request_data'])) {
  unset($_SESSION['request_data']);
}
?>