<?php

// create an object of DIRECTION class
$dir_obj = new Direction();
// count all directions
$all_dirs_counter = $dir_obj->count_records("*", "`direction`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
// get all job titles
$all_dirs = $dir_obj->get_all_directions(base64_decode($_SESSION['sys']['company_id']));
// main statement
$main_statement = lang('YOUR NETWORK CONTAINS', $lang_file) . " " . $all_dirs_counter . " " . lang('DIRECTIONS', $lang_file) . ":";
?>

<!-- employees reports -->
<p class="lead">
  <!-- display main statement -->
  <span>
    <?php echo $main_statement; ?>
  </span>
</p>

<?php
// check direction counter
if ($all_dirs_counter > 0 && !is_null($all_dirs)) {
  // assign all directions data
  $all_dirs_data = $all_dirs;

  $all_data = [];
  $all_data_labels = [];
  ?>
  <ol class="direction-list">
    <?php foreach ($all_dirs_data as $key => $dir) { ?>
      <li>
        <a href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($dir['direction_id']) ?>"
          target="_blank">
          <h4>
            <?php echo $dir['direction_name'] ?>
            <i class="bi bi-box-arrow-up-left fs-16"></i>
          </h4>
        </a>

        <?php
        // get number of devices
        $num_devices = $dir_obj->count_records("*", "`pieces_info`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `direction_id` = " . $dir['direction_id'] . " AND `is_client` = 0");
        // get number of transmitter devices
        $num_trans_devices = $dir_obj->count_records("*", "`pieces_info`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `direction_id` = " . $dir['direction_id'] . " AND `is_client` = 0 AND `device_type` = 1");
        // get number of receiver devices
        $num_rece_devices = $dir_obj->count_records("*", "`pieces_info`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `direction_id` = " . $dir['direction_id'] . " AND `is_client` = 0 AND `device_type` = 2");
        // get number of clients
        $num_clients = $dir_obj->count_records("*", "`pieces_info`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `direction_id` = " . $dir['direction_id'] . " AND `is_client` = 1");

        $all_data[] = [$num_devices, $num_trans_devices, $num_rece_devices, $num_clients];

        array_push($all_data_labels, $dir['direction_name']);
        ?>

        <!-- <section>
          <p class="lead">
            <?php
            echo lang('THIS DIR CONTAINS', $lang_file) . " " . $num_devices . " " . lang($num_devices > 1 ? 'DEVICES' : 'DEVICES', $lang_file) . " " . lang('AND') . " " . $num_clients . " " . lang('CLIENTS', $lang_file);
            ?>
          </p>
        </section> -->

        <div>
          <canvas class="dir_charts_canvas"></canvas>
        </div>

      </li>
    <?php } ?>
  </ol>
<?php } ?>

<script>
  // get all charts canvas
  const all_chart = document.querySelectorAll('.dir_charts_canvas');

  // put charts label
  const labels = [
    '<?php echo lang('DEVICES', $lang_file) ?>',
    '<?php echo lang('TRANS DEV', 'pieces') ?>',
    '<?php echo lang('RECE DEV', 'pieces') ?>',
    '<?php echo lang('CLT', 'clients') ?>',
  ];

  // background colors
  const bg_colors = [
    'rgba(255, 99, 132, 0.2)',
    'rgba(255, 159, 64, 0.2)',
    'rgba(255, 205, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(201, 203, 207, 0.2)'
  ];

  // border colors
  const br_colors = [
    'rgb(255, 99, 132)',
    'rgb(255, 159, 64)',
    'rgb(255, 205, 86)',
    'rgb(75, 192, 192)',
    'rgb(54, 162, 235)',
    'rgb(153, 102, 255)',
    'rgb(201, 203, 207)'
  ];

  // get charts data
  const data = <?php echo json_encode($all_data) ?>;
  // get all charts labels
  const all_charts_labels = <?php echo json_encode($all_data_labels) ?>;

  // loop on charts canvas
  all_chart.forEach((element, key) => {
    // create chart image
    const chart_image = null;
    // create chart data
    const chart_data = create_chart_data(labels, all_charts_labels[key], data[key], bg_colors, br_colors);
    // chart config
    const chart_conf = chart_config(chart_data, 'bar', chart_image);
    // initiat chart
    chart_init(element, chart_conf)

    console.log(data[key])
    console.log(all_charts_labels[key])
  });
</script>




<!-- <section>
          <span class="pr around css1" data-val="<?php echo $num_devices ?>">
            <span class="outer"><span class="value">
                <?php echo $num_devices == 0 ? '0' : $num_devices ?>
              </span>
              <?php echo lang($num_devices > 1 ? 'DEVICES' : 'DEVICES', $lang_file) ?>
            </span>
          </span>
          <span class="pr around css1" data-val="<?php echo $num_trans_devices ?>">
            <span class="outer"><span class="value">
                <?php echo $num_trans_devices == 0 ? '0' : $num_trans_devices ?>
              </span>
              <?php echo lang('TRANS DEV', 'pieces') ?>
            </span>
          </span>
          <span class="pr around css1" data-val="<?php echo $num_rece_devices ?>">
            <span class="outer"><span class="value">
                <?php echo $num_rece_devices == 0 ? '0' : $num_rece_devices ?>
              </span>
              <?php echo lang('RECE DEV', 'pieces') ?>
            </span>
          </span>
          <span class="pr around css1" data-val="<?php echo $num_clients ?>">
            <span class="outer"><span class="value">
                <?php echo $num_clients == 0 ? '0' : $num_clients ?>
              </span>
              <?php echo lang('CLIENT', 'clients') ?>
            </span>
          </span>
        </section> -->
<!-- Transfor PHP array to JavaScript two dimensional array  -->
<!-- <script>
  var my_2d = <?php echo json_encode($all_data) ?>;
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  // // Load the Visualization API and the corechart package.
  // google.charts.load('current', { packages: ['corechart'] });
  // google.charts.setOnLoadCallback(drawChart);

  // function drawChart() {
  //   // get all charts containers
  //   const charts_containers = document.querySelectorAll('.curve_chart');

  //   if (charts_containers.length > 0) {
  //     // loop on charts container
  //     charts_containers.forEach((chart, key) => {
  //       // get specific chart
  //       var chart = new google.visualization.LineChart(chart);

  //       // Create the data table.
  //       var data = new google.visualization.DataTable();


  //       data.addColumn('number', '<?php echo lang("DEVICES", $lang_file) ?>');
  //       data.addColumn('number', '<?php echo lang("TRANS DEV", "pieces") ?>');
  //       data.addColumn('number', '<?php echo lang("RECE DEV", "pieces") ?>');
  //       data.addColumn('number', '<?php echo lang("CLIENT", "clients") ?>');


  //       data.addRow([parseInt(my_2d[key]['devices']), parseInt(my_2d[key]['trans_dev']), parseInt(my_2d[key]['rece_dev']), parseInt(my_2d[key]['clients'])]);


  //       var options = {
  //         curveType: 'function',
  //         width: 800,
  //         height: 500,
  //         legend: { position: 'bottom' }
  //       };

  //       chart.draw(data, options);
  //     });

  //   }
  // }
  // ///////////////////////////////
</script> -->