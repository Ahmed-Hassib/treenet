<?php
// create an object of Direction class
$dir_obj = new Direction();
// company id
$company_id = base64_decode($_SESSION['sys']['company_id']);
// get direction id
$dir_id = isset($_GET['dir-id']) && !empty($_GET['dir-id']) ? base64_decode(trim($_GET['dir-id'], '\n\r\t\v\x')) : null;
// check dir id if not null
if ($dir_id !== null && $dir_obj->is_exist("`direction_id`", "`direction`", $dir_id)) {
  // get direction data
  $all_dir_data = $dir_obj->get_all_dir_coordinates($dir_id, 0, $company_id);
} elseif ($dir_id == 'all') {
  // get direction data
  $all_dir_data = $dir_obj->get_all_dir_coordinates(null, 0, $company_id);
}
// get all directions
$all_dirs = $dir_obj->get_all_directions($company_id);
?>

<div class="container" dir="<?php echo $page_dir ?>">
  <div class="row g-3 mb-3 row-cols-sm-1 row-cols-md-2">
    <div class="col-auto">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('THE DIRECTIONS', $lang_file) ?>
          </h5>
          <p class="text-muted">
            <?php echo lang('SELECT DIR MAP NOTE', $lang_file) ?>
          </p>
          <hr>
        </header>
        <form action="" method="get" name="direction-map-form">
          <input type="hidden" name="do" value="direction-map">
          <div class="form-floating mb-3">
            <select class="form-select" id="dir-id" name="dir-id">
              <option disabled <?php echo $dir_id == null ? 'selected' : '' ?>>
                <?php echo lang('SELECT DIRECTION', $lang_file) ?>
              </option>
              <?php foreach ($all_dirs as $key => $dir) { ?>
                <option value="<?php echo base64_encode($dir['direction_id']) ?>" <?php echo $dir['direction_id'] == $dir_id ? 'selected' : '' ?>>
                  <?php echo $dir['direction_name'] ?>
                </option>
              <?php } ?>
              <option value="<?php echo base64_encode('all') ?>" <?php echo $dir_id == 'all' ? 'selected' : '' ?>>
                <?php echo lang('SHOW ALL') ?>
              </option>
            </select>
            <label for="dir-id">
              <?php echo lang('THE DIRECTION', $lang_file) ?>
            </label>
          </div>
          <div class="<?php echo $page_dir == 'ltr' ? 'text-end' : 'text-start' ?>">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-all"></i>
              <?php echo lang('APPLY') ?>
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-auto">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('MAP KEY') ?>
          </h5>
          <p class="text-muted">
            <?php echo lang('MAP KEY NOTE') ?>
          </p>
          <hr>
        </header>
        <ul>
          <li style="color: #ff942e">
            <i class="bi bi-wifi" style="font-size:20px!important"></i>&nbsp;
            <?php echo lang('REFERE TO') . " " . lang('SENDER POINT', 'pieces') ?>
          </li>
          <li style="color: #0061c7">
            <i class="bi bi-modem-fill" style="font-size:20px!important"></i>&nbsp;
            <?php echo lang('REFERE TO') . " " . lang('RECEIVER POINT', 'pieces') ?>
          </li>
          <li style="color: #00c200">
            <i class="bi bi-person-fill" style="font-size:20px!important"></i>&nbsp;
            <?php echo lang('REFERE TO') . " " . lang('CLT', 'clients') ?>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <?php if (isset($all_dir_data)) { ?>
    <div class="section-block">
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
      <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
      <script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $conf['map_api_key'] ?>&callback=initMap&libraries=maps,marker&v=weekly"></script>

      <!-- map -->
      <div id="map"></div>

      <script defer async type="text/javascript">
        // initial map
        async function initMap() {
          // all map points
          const points = <?php echo json_encode($all_dir_data) ?>;
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

          const target_dir_id_status = Boolean('<?php echo $dir_id == 'all' ?>');
          // loop on points
          points.forEach((point, _key) => {
            // create current point marker
            create_point_marker(map, [point]);
            // get point`s children
            $.ajax({
              url: 'get-point-children.php',
              dataType: 'json',
              cache: false,
              type: 'post',
              data: {
                dir_id: target_dir_id_status ? point['direction_id'] : '<?php echo base64_encode($dir_id) ?>',
                src_id: `${point['id']}`,
                company_id: '<?php echo base64_encode($company_id) ?>',
              },
              success: function(result_data, status) {
                // check result data
                if (result_data != null) {
                  // create points marker
                  create_point_marker(map, result_data, '<?php echo $nav_up_level ?>');
                  // create path between points
                  create_points_path(map, point['coordinates'], result_data);
                }
              },
              error: function(xhr, textStatus, err) {}
            })
          });
        }
      </script>
    </div>


    <div class="mt-3 hstack gap-3 justify-content-end" id="edit-coordinates-form-container">
      <form action="?do=update-coordinates" method="POST" class="d-none" id="edit-coordinates-form"></form>

      <button type="button" class="d-none btn btn-primary" id="edit-coordinates-submit-form" form="edit-coordinates-form">
        <i class="bi bi-check-all"></i>
        <?php echo lang('save') ?>
      </button>
    </div>
  <?php } ?>
</div>