<?php
// get malfunction id 
$comb_id = isset($_GET['combid']) && !empty($_GET['combid']) ? base64_decode($_GET['combid']) : 0;
// create an object of Combination
$comb_obj = new Combination();
// check if combid exist
$is_exist = $comb_obj->is_exist("`comb_id`", "`combinations`", $comb_id);
// check
if ($is_exist == true) {
  // get combination info
  $comb_info = $comb_obj->get_combinations("`comb_id` = {$comb_id} AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL");
  // update comb status
  if ($comb_info['isShowed'] == 0) {
    if (base64_decode($_SESSION['sys']['UserID']) == $comb_info['UserID']) {
      $updateQ = "UPDATE `combinations` SET `isShowed` = 1, `showed_at` = now() WHERE `comb_id` = ?";
      $stmtUp = $con->prepare($updateQ); // select all directions
      $stmtUp->execute(array($comb_id)); // execute data
    }
  }
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start form -->
    <form class="custom-form" action="?do=update-combination-info" method="POST" enctype="multipart/form-data" id="edit-combination-info">
      <!-- submit -->
      <div class="mb-3 hstack gap-2">
        <?php if ($_SESSION['sys']['comb_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <div class="<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="button" class="btn btn-primary text-capitalize form-control bg-gradient py-1 fs-12" id="" onclick="form_validation(this.form, 'submit')">
              <i class="bi bi-check-all"></i>
              <?php echo lang('SAVE') ?>
            </button>
          </div>
        <?php } ?>
        <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <div>
            <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-combination-id="<?php echo base64_encode($comb_info['comb_id']) ?>" onclick="confirm_delete_combination(this, null, false)">
              <i class="bi bi-trash"></i>
              <?php echo lang('DELETE') ?>
            </button>
          </div>
        <?php } ?>
      </div>

      <div class="edit-comb-content">
        <!-- resbonsible for combination -->
        <div class="edit-comb-content__subinfo">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('RESP COMB', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <input type="hidden" class="form-control" id="comb-id" name="comb-id" value="<?php echo base64_encode($comb_info['comb_id']) ?>" autocomplete="off" required data-no-astrisk="true" />
            <!-- Administrator name -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <!-- admin name -->
              <?php $admin_name = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $comb_info['addedBy'])['username'] ?>
              <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo base64_encode($comb_info['addedBy']) ?>" autocomplete="off" required data-no-astrisk="true" />
              <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="administrator name" value="<?php echo $admin_name ?>" autocomplete="off" required disabled />
              <label for="admin-name">
                <?php echo lang('ADMIN NAME', $lang_file) ?>
              </label>
            </div>
            <!-- Technical name -->
            <div class="mb-3">
              <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <select class="form-select" id="technical-id" name="technical-id" required <?php echo $_SESSION['sys']['is_tech'] == 1 || $_SESSION['sys']['comb_update'] == 0 || $comb_info['isFinished'] == 1 ? 'disabled' : '' ?>>
                  <option value="default" disabled selected>
                    <?php echo lang('SELECT TECH NAME', $lang_file) ?>
                  </option>
                  <?php $emp_info = $comb_obj->select_specific_column("`UserID`, `username`", "users", "WHERE `is_tech` = 1 AND `job_title_id` = 2 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])); ?>
                  <?php if (!is_null($emp_info) > 0) { ?>
                    <?php foreach ($emp_info as $uer_row) { ?>
                      <option value="<?php echo base64_encode($uer_row['UserID']) ?>" <?php echo $comb_info['UserID'] == $uer_row['UserID'] ? 'selected' : '' ?>>
                        <?php echo $uer_row['username']; ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                  <?php if (is_null($emp_info) <= 0) { ?>
                    <div class="text-danger fw-bold">
                      <i class="bi bi-exclamation-triangle-fill"></i>
                      <?php echo lang("NO DATA") ?>
                    </div>
                  <?php } ?>
                </select>
                <label for="technical-id">
                  <?php echo lang('TECH NAME', $lang_file) ?>
                </label>
                <input type="hidden" name="technical-id" id="technical-id-value" value="" required>
              </div>
            </div>
          </div>

          <!-- combination status -->
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('STATUS', $lang_file) ?>
              </h5>
              <hr />
            </div>

            <!-- combination status -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select class="form-select" name="comb-status" id="comb-status" required <?php echo $_SESSION['sys']['comb_update'] != 1 || $_SESSION['sys']['is_tech'] != 1 || $comb_info['isFinished'] == 1 ? 'disabled' : ''; ?> <?php echo $_SESSION['sys']['is_tech'] == 0 ? 'disabled' : ''; ?>>
                <option value="default" disabled>
                  <?php echo lang("SELECT STATUS", $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(0) ?>" <?php echo $comb_info['isFinished'] == 0 ? 'selected' : '' ?>>
                  <?php echo lang("UNFINISHED", $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isFinished'] == 1 ? 'selected' : '' ?>>
                  <?php echo lang("FINISHED", $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isFinished'] == 2 ? 'selected' : '' ?>>
                  <?php echo lang("DELAYED", $lang_file) ?>
                </option>
              </select>
              <label for="comb-status" class="col-sm-12 col-form-label text-capitalize pt-0">
                <?php echo lang('STATUS', $lang_file) ?>
              </label>
            </div>
          </div>
        </div>

        <!-- client info -->
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('BENEFICIARY INFO', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <?php if ($_SESSION['sys']['comb_update'] == 1) { ?>
            <!-- client-nameme -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" name="client-name" placeholder="<?php echo lang('BENEFICIARY NAME', $lang_file) ?>" value="<?php echo $comb_info['client_name'] ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : ''; ?> required />
              <label for="client-name">
                <?php echo lang('BENEFICIARY NAME', $lang_file) ?>
              </label>
            </div>
            <!-- phone -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="client-phone" id="client-phone" class="form-control w-100" placeholder="<?php echo lang('PHONE', $lang_file) ?>" value="<?php echo $comb_info['phone'] ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : ''; ?> required />
              <label for="client-phone">
                <?php echo lang('PHONE', $lang_file) ?>
              </label>
            </div>
            <!-- address -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" name="client-address" id="client-address" class="form-control w-100" placeholder="<?php echo lang('ADDR', $lang_file) ?>" value="<?php echo $comb_info['address'] ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : '' ?> required />
              <label for="client-address">
                <?php echo lang('ADDR', $lang_file) ?>
              </label>
            </div>
            <!-- notes -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <textarea type="text" name="client-notes" id="client-notes" class="form-control w-100" placeholder="<?php echo lang('NOTE') ?>" style="<?php echo strlen($comb_info['comment']) < 250 ? 'height: auto !important; overflow: hidden;' : 'height: 180px !important;' ?> resize: none; direction: <?php echo $page_dir ?>" <?php echo $comb_info['isFinished'] == 1 ? 'disabled' : '' ?> required><?php echo $comb_info['comment'] ?></textarea>
              <label for="client-notes">
                <?php echo lang('NOTE') ?>
              </label>
            </div>
          <?php } else { ?>
            <div class="benef-info-container">
              <!-- client-nameme -->
              <div class="benef-info__row">
                <span>
                  <?php echo lang('BENEFICIARY NAME', $lang_file) ?>
                </span>
                <span class="text-primary">
                  <?php echo $comb_info['client_name'] ?>
                </span>
              </div>
              <!-- phone -->
              <div class="benef-info__row">
                <span>
                  <?php echo lang('PHONE', $lang_file) ?>
                </span>
                <span class="text-primary">
                  <?php echo $comb_info['phone'] ?>
                </span>
              </div>
              <!-- address -->
              <div class="benef-info__row">
                <span>
                  <?php echo lang('ADDR', $lang_file) ?>
                </span>
                <span class="text-primary">
                  <?php echo $comb_info['address'] ?>
                </span>
              </div>
              <!-- notes -->
              <div class="benef-info__row">
                <span>
                  <?php echo lang('NOTE') ?>
                </span>
                <span class="text-primary">
                  <?php echo $comb_info['comment'] ?>
                </span>
              </div>
            </div>
          <?php } ?>

          <!-- coordinates -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" name="coordinates" id="coordinates" class="form-control w-100" placeholder="<?php echo lang('COORDINATES', 'pieces') ?>" required value="<?php echo $comb_info['coordinates'] ?>">
            <label for="coordinates">
              <?php echo lang('COORDINATES', 'pieces') ?>
            </label>
          </div>
        </div>


        <?php if (!empty($comb_info['coordinates'])) { ?>
          <div class="section-block section-block_row">
            <div class="section-header">
              <h5>
                <?php echo lang('LOCATION', $lang_file) ?>
              </h5>
              <hr />
            </div>

            <div>
              <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                <?php
                // create an object of Direction class
                $dir_obj = new Direction();
                // get all pieces coordinates
                $all_pcs_data = $dir_obj->get_all_dir_coordinates(null, 0, base64_decode($_SESSION['sys']['company_id']));
                ?>
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
                <script src="<?php echo $js; ?>map.js" defer></script>
                <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
                <script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $conf['map_api_key'] ?>&callback=initMap&libraries=maps,marker&v=weekly"></script>

                <!-- map -->
                <div id="map"></div>
                <script defer async type="text/javascript">
                  // array of markers
                  var markers = [];
                  // initial map
                  async function initMap() {
                    // all map points
                    const points = <?php echo json_encode($all_pcs_data) ?>;
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
                      center: getLatLong('<?php echo $comb_info['coordinates'] ?>'),
                      mapId: '<?php echo $conf['map_id'] ?>',
                      mapTypeId: 'roadmap',
                      mapTypeControlOptions: {
                        mapTypeIds: ['roadmap', 'satellite'],
                      },
                      gestureHandling: "greedy",
                    });

                    // create new marker in the new position
                    let marker = new google.maps.marker.AdvancedMarkerElement({
                      position: getLatLong('<?php echo $comb_info['coordinates'] ?>'),
                      map: map,
                      gmpDraggable: true,
                    });

                    // add event when marker draged
                    marker.addListener("dragend", (event) => {
                      const position = marker.position;
                      // put new coordinates into input
                      document.querySelector('#coordinates').value = `${position.lat}, ${position.lng}`;
                    })
                    // add all pieces markers
                    create_point_marker(map, points, false, '<?php echo $nav_up_level ?>');
                  }
                </script>
              <?php } else { ?>
                <p class="lead text-danger">
                  <?php echo lang('FEATURE NOT AVAILABLE') ?>
                </p>
              <?php } ?>
            </div>
          </div>
        <?php } ?>

        <!-- Combination date and time -->
        <div class="section-block section-block_row">
          <div class="section-header">
            <h5>
              <?php echo lang('DATE & TIME INFO', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <div class="date-time-content">
            <!-- added date -->
            <div class="date-time-content__row">
              <label for="added-date">
                <?php echo lang('ADDED DATE') ?>
              </label>
              <div class="position-relative">
                <span class="text-primary" dir='ltr'>
                  <?php echo wordwrap(date_format(date_create($comb_info['created_at']), 'h:i:sa d/m/Y'), 11, "<br>") ?>
                </span>
              </div>
            </div>
            <!-- showed date -->
            <div class="date-time-content__row">
              <label for="showed-date">
                <?php echo lang('SHOWED DATE') ?>
              </label>
              <div class="position-relative">
                <?php if ($comb_info['isShowed']) { ?>
                  <span class="text-primary" dir='ltr'>
                    <?php echo wordwrap(date_format(date_create($comb_info['showed_at']), 'h:i:sa d/m/Y'), 11, "<br>") ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NOT SHOWED', $lang_file) ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <!-- repaired date -->
            <div class="date-time-content__row">
              <label for="repaired-date">
                <?php echo $comb_info['isFinished'] == 1 && $comb_info['isAccepted'] != 2 ? lang('FINISHED DATE') : lang('DELAYED DATE'); ?>
              </label>
              <div class="position-relative">
                <?php if ($comb_info['isFinished']) { ?>
                  <span class="text-primary" dir='ltr'>
                    <?php echo wordwrap(date_format(date_create($comb_info['finished_at']), 'h:i:sa d/m/Y'), 11, "<br>") ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger fw-bold">
                    <?php echo lang('NOT ASSIGNED') ?>
                  </span>
                <?php } ?>
              </div>
            </div>
            <?php if ($comb_info['isFinished'] == 1) { ?>
              <!-- diff time -->
              <div class="date-time-content__row period">
                <label for="showed-time">
                  <?php echo lang('FINISHED PERIOD') ?>
                </label>
                <div class="position-relative">
                  <?php
                  $diff = [];
                  if (!is_null($comb_info['showed_at']) && !is_null($comb_info['finished_at'])) {
                    $showed_date = date_create($comb_info['created_at']); // added date
                    $finished_date = date_create($comb_info['finished_at']); // repaired date
                    // get the diffrence of days
                    $diff_date = date_diff($showed_date, $finished_date, true);

                    $days = $diff_date->d;
                    $hours = $diff_date->h;
                    $minutes = $diff_date->i;
                    $seconds = $diff_date->s;
                  ?>
                    <span class="text-primary">
                      <?php echo ($days > 0 ? "$days " . lang($days > 1 ? 'DAYS' : 'DAY') . ", " : '') . ($hours > 0 ? " $hours " . lang($hours > 1 ? 'HOURS' : 'HOUR') . ", " : '') . ($minutes > 0 ? " $minutes " . lang($minutes > 1 ? 'MINUTES' : 'MINUTE') . ", " : '') . ($seconds > 0 ? " $seconds " . lang($seconds > 1 ? 'SECONDS' : 'SECOND') . ". " : '') ?>
                    </span>
                  <?php } else { ?>
                    <span class="text-danger">
                      <?php echo lang('PERIOD NOTE', $lang_file) ?>
                    </span>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <!-- additional info -->
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('ADD INFO', 'pieces') ?>
            </h5>
            <hr />
          </div>
          <!-- technical man comment -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <textarea name="comment" id="comment" title="describe the combination" class="form-control w-100" style="<?php echo strlen($comb_info['tech_comment']) < 250 ? 'height: auto !important; overflow: hidden;' : 'height: 180px !important;' ?> resize: none; direction: <?php echo $page_dir ?>" <?php echo $_SESSION['sys']['comb_update'] == 0 || $_SESSION['sys']['is_tech'] == 0 || $comb_info['isFinished'] == 1 ? 'disabled' : '' ?>><?php echo empty($comb_info['tech_comment']) && $comb_info['isFinished'] ? "لا يوجد تعليق من الفني" : $comb_info['tech_comment']; ?></textarea>
            <label for="comment">
              <?php echo lang('TECH COMMENT', $lang_file) ?>
            </label>
          </div>
        </div>

        <!-- cost receipt -->
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('COST RECEIPT', $lang_file) ?>
            </h5>
            <hr />
          </div>

          <!-- cost -->
          <div class="mb-3">
            <div class="input-group" dir="ltr">
              <span class=" input-group-text">
                <?php echo lang('L.E') ?>
              </span>
              <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" name="cost" id="cost" class="form-control " placeholder="<?php echo lang('COMB COST', $lang_file) ?>" value="<?php echo $comb_info['cost'] ?>" <?php echo $_SESSION['sys']['comb_update'] == 0 || $_SESSION['sys']['is_tech'] == 0 || $comb_info['isFinished'] == 1 ? 'disabled' : '' ?> onblur="arabic_to_english_nums(this)" onkeyup="arabic_to_english_nums(this)">
                <label for="cost">
                  <?php echo lang('COMB COST', $lang_file) ?>
                </label>
              </div>
            </div>
            <div id="costHelp" class="form-text text-info">
              <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
              <?php echo lang('ENG NUM') ?>
            </div>
          </div>

          <?php if ($_SESSION['sys']['is_tech'] == 1 && $_SESSION['sys']['comb_update'] == 1) { ?>
            <!-- cost receipt -->
            <!-- cost receipt -->
            <label for="cost-receipt" class="custum-file-upload">
              <div class="icon">
                <img src="<?php echo $treenet_assets ?>file-cloud.svg" alt="">
              </div>
              <div class="text">
                <span>
                  <?php echo lang('UPLOAD COST RECEIPT', 'malfunctions') ?>
                </span>
              </div>
              <input type="file" id="cost-receipt" name="cost-receipt" accept="image/*" onchange="change_cost_receipt_img(this, 'cost-image-preview')">
            </label>

            <?php $cost_media_path = $uploads . "combinations/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $comb_info['cost_receipt']; ?>
            <div id="cost-image-preview" class="cost-image-preview w-100 <?php echo empty($comb_info['cost_receipt']) || !file_exists($cost_media_path) ? "d-none" : '' ?>">
              <?php if (!empty($comb_info['cost_receipt']) && file_exists($cost_media_path)) { ?>
                <img loading="lazy" src="<?php echo $cost_media_path ?>" alt="<?php echo lang('COST RECEIPT', $lang_file) ?>" style="border: 5px solid #5fcca4; border-radius: 1rem; max-width: 100%; cursor: pointer;" onclick="open_media(this.src, 'jpg')">
              <?php } ?>
            </div>
          <?php } ?>
        </div>

        <?php if ($comb_info['isFinished'] == 1) { ?>
          <!-- combination review -->
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('COMB REVIEW', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <!-- quality of employee -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select name="technical-qty" id="technical-qty" class="form-select" <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['is_tech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled <?php echo $comb_info['isReviewed'] == 0 ? "selected" : '' ?>>
                  <?php echo lang('SELECT QTY', $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 1 ? "selected" : '' ?>>
                  <?php echo lang('BAD') ?>
                </option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 2 ? "selected" : '' ?>>
                  <?php echo lang('GOOD') ?>
                </option>
                <option value="<?php echo base64_encode(3) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_emp'] == 3 ? "selected" : '' ?>>
                  <?php echo lang('VERY GOOD') ?>
                </option>
              </select>
              <label for="technical-qty">
                <?php echo lang('TECH QTY', $lang_file) ?>
              </label>
            </div>
            <!-- quality of service -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select name="service-qty" id="service-qty" class="form-select" <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['is_tech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled <?php echo $comb_info['isReviewed'] == 0 ? "selected" : '' ?>>
                  <?php echo lang('SELECT QTY', $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 1 ? "selected" : '' ?>>
                  <?php echo lang('BAD') ?>
                </option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 2 ? "selected" : '' ?>>
                  <?php echo lang('GOOD') ?>
                </option>
                <option value="<?php echo base64_encode(3) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['qty_service'] == 3 ? "selected" : '' ?>>
                  <?php echo lang('VERY GOOD') ?>
                </option>
              </select>
              <label for="service-qty">
                <?php echo lang('SERVICE QTY', $lang_file) ?>
              </label>
            </div>
            <!-- money review -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <select name="money-review" id="money-review" class="form-select" <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['is_tech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>>
                <option value="default" disabled <?php echo $comb_info['isReviewed'] == 0 ? "selected" : '' ?>>
                  <?php echo lang('SELECT QTY', $lang_file) ?>
                </option>
                <option value="<?php echo base64_encode(1) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['money_review'] == 1 ? "selected" : '' ?>>
                  <?php echo lang('RIGHT') ?>
                </option>
                <option value="<?php echo base64_encode(2) ?>" <?php echo $comb_info['isReviewed'] == 1 && $comb_info['money_review'] == 2 ? "selected" : '' ?>>
                  <?php echo lang('WRONG') ?>
                </option>
              </select>
              <label for="money-review">
                <?php echo lang('COST REVIEW', $lang_file) ?>
              </label>
            </div>
            <!-- employee review comment -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <label for="review-comment">
                <?php echo lang('NOTE') ?>
              </label>
              <textarea name="review-comment" id="review-comment" title="review comment" class="form-control w-100" style="height: 5rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo lang('NOTE') ?>" required <?php echo $_SESSION['sys']['comb_review'] == 0 || ($comb_info['isFinished'] == 0 && $_SESSION['sys']['is_tech'] == 0) || $comb_info['isReviewed'] == 1 ? 'disabled' : '' ?>><?php echo $comb_info['qty_comment'] ?></textarea>
            </div>
            <?php if ($comb_info['isReviewed'] == 1) { ?>
              <!-- reviewed date -->
              <div class="mb-1 row align-items-center">
                <label for="reviewed-date">
                  <?php echo lang('REVIEWED DATE') ?>
                </label>
                <div class="col-sm-12 col-md-8">
                  <span class="text-primary" dir='ltr'>
                    <?php echo date_format(date_create($comb_info['reviewed_date']), 'd/m/Y') ?>
                  </span>
                </div>
              </div>
              <!-- reviewed time -->
              <div class="mb-1 row align-items-center">
                <label for="reviewed-time">
                  <?php echo lang('REVIEWED TIME') ?>
                </label>
                <div class="col-sm-12 col-md-8">
                  <span class="text-primary" dir='ltr'>
                    <?php echo date_format(date_create($comb_info['reviewed_time']), 'h:i:s a') ?>
                  </span>
                </div>
              </div>
            <?php } ?>
            <?php if ($comb_info['isFinished'] == 0 && $_SESSION['sys']['is_tech'] == 0) { ?>
              <div class="mb-1 row align-items-center">
                <span class="text-warning" dir="<?php echo @$_SESSION['sys']['lang'] == 0 ? 'rtl' : 'ltr' ?>" style="text-align: <?php echo @$_SESSION['sys']['lang'] == 0 ? 'right' : 'left' ?>">
                  <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
                  <span>
                    <?php echo lang('REVIEW ERROR', $lang_file) ?>
                  </span>
                </span>
              </div>
            <?php } ?>
          </div>
        <?php } ?>

        <!-- the malfunctions media -->
        <div class="section-block section-block_row">
          <div class="section-header media-section">
            <h5 style="<?php echo $_SESSION['sys']['is_tech'] == 0 ? 'padding-bottom: 0!important' : ''; ?>">
              <?php echo lang('MEDIA', $lang_file) ?>
            </h5>
            <!-- add new malfunction -->
            <?php if ($_SESSION['sys']['is_tech'] == 1 && $_SESSION['sys']['comb_update'] == 1) { ?>
              <button type="button" role="button" class="btn btn-outline-primary py-1 fs-12 media-button" onclick="add_new_media('media-container', 'file-inputs')">
                <i class="bi bi-card-image"></i>
                <?php echo lang('ADD MEDIA', $lang_file) ?>
              </button>
            <?php } ?>
            <hr />
          </div>
          <!-- combination media -->
          <?php $comb_media = $comb_obj->get_combination_media($comb_id); ?>
          <div class="media-container" id="media-container">
            <?php if ($comb_media != null && count($comb_media) > 0) { ?>
              <?php foreach ($comb_media as $key => $media) { ?>
                <?php $media_source = $uploads . "combinations/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $media['media'] ?>
                <?php if (file_exists($media_source)) { ?>
                  <div class="media-content">
                    <?php if ($media['type'] == 'img') { ?>
                      <img loading="lazy" src="<?php echo $media_source ?>" alt="">
                    <?php } else { ?>
                      <video src="<?php echo $media_source ?>" controls muted>
                        <source src="<?php echo $media_source ?>" type="video/*">
                      </video>
                    <?php } ?>
                    <div class="control-btn">
                      <?php if ($_SESSION['sys']['comb_media_download'] == 1) { ?>
                        <button type="button" class="btn btn-primary py-1 ms-1" onclick="download_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')" src="<?php echo $media_source ?>"><i class='bi bi-download'></i></a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['comb_media_delete'] == 1) { ?>
                          <button type="button" class="btn btn-danger py-1 ms-1" onclick="delete_media(this)" data-media-id="<?php echo base64_encode($media['id']); ?>" data-media-name="<?php echo $media['media']; ?>"><i class="bi bi-trash"></i></button>
                        <?php } ?>
                        <button type="button" class="btn btn-primary" onclick="open_media('<?php echo $media_source ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')"><i class="bi bi-eye"></i></button>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="alert alert-danger">
                    <h6 class="h6 text-danger fw-bold">
                      <i class="bi bi-exclamation-triangle-fill"></i>
                      <?php echo lang('MEDIA FAILED') ?>
                    </h6>
                  </div>
                <?php } ?>
              <?php } ?>
            <?php } else { ?>
              <div class="alert alert-danger">
                <h6 class="h6 text-danger fw-bold">
                  <i class="bi bi-exclamation-triangle-fill"></i>
                  <?php echo lang('NO DATA') ?>
                </h6>
              </div>
            <?php } ?>
          </div>
          <!-- malfunction media file info -->
          <div class="d-none" id="file-inputs"></div>
        </div>

        <?php
        // get combination updates info
        $comb_updates = $comb_obj->get_combination_updates($comb_id);
        // check combinations updates details
        if ($comb_updates != null && count($comb_updates) > 0) {
        ?>
          <div class="section-block section-block_row">
            <div class="section-header">
              <h5>
                <?php echo lang('COMB UPDATES', $lang_file) ?>
              </h5>
              <hr />
            </div>
            <div class="table-responsive-sm">
              <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo count($comb_updates) <= 10 ? 'data-scroll-y="auto"' : null ?> style="width:100%">
                <thead class="primary text-capitalize">
                  <tr>
                    <td>#</td>
                    <td>
                      <?php echo lang('UPDATED BY', $lang_file) ?>
                    </td>
                    <td>
                      <?php echo lang('UPDATED AT', $lang_file) ?>
                    </td>
                    <td style="min-width: 300px">
                      <?php echo lang('UPDATES', $lang_file) ?>
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($comb_updates as $key => $update) { ?>
                    <tr>
                      <td>
                        <?php echo ++$key ?>
                      </td>
                      <td>
                        <?php if ($update['updated_by'] == 0) {
                          echo lang('TREE NET SYSTEM');
                        } else { ?>
                          <?php $username = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $update['updated_by'])['username']; ?>
                          <?php if ($_SESSION['sys']['user_show']) { ?>
                            <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($update['updated_by']); ?>">
                              <?php echo $username ?>
                            </a>
                          <?php } else { ?>
                            <?php echo $username ?>
                          <?php } ?>
                        <?php } ?>
                      </td>
                      <td>
                        <?php echo date('d/m/Y h:ia', strtotime($update['updated_at'])) ?>
                      </td>
                      <td>
                        <?php echo lang(strtoupper($update['updates']), $lang_file) ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php } ?>
      </div>


      <!-- submit -->
      <div class="hstack gap-2">
        <?php if ($_SESSION['sys']['comb_update'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="button" class="btn btn-primary text-capitalize form-control bg-gradient py-1 fs-12" id="" onclick="form_validation(this.form, 'submit')">
              <i class="bi bi-check-all"></i>
              <?php echo lang('SAVE') ?>
            </button>
          </div>
        <?php } ?>
        <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <div>
            <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-combination-id="<?php echo base64_encode($comb_info['comb_id']) ?>" onclick="confirm_delete_combination(this, null, false)">
              <i class="bi bi-trash"></i>
              <?php echo lang('DELETE') ?>
            </button>
          </div>
        <?php } ?>
      </div>
    </form>
    <!-- end form -->
    <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      include_once 'delete-modal.php';
    } ?>

    <!-- media modal -->
    <div id="media-modal" class="media-modal">
      <span class="close" id="media-modal-close">
        <i class="bi bi-x-lg"></i>
      </span>
      <div id="media-modal-content"></div>
    </div>
  </div>
<?php } else {
  // prepare flash session variables
  $_SESSION['flash_message'] = 'NO DATA';
  $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
  $_SESSION['flash_message_class'] = 'danger';
  $_SESSION['flash_message_status'] = false;
  $_SESSION['flash_message_lang_file'] = 'global_';
  // redirect to the previous page 
  redirect_home(null, 'back', 0);
}
