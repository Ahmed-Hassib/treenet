<?php
// get type
$type = isset($_GET['type']) && $_GET['type'] >= 0 ? $_GET['type'] : -1;
// get period
$period = isset($_GET['period']) && !empty($_GET['period']) ? $_GET['period'] : -1;

// array of errors
$errors = array();

// check type
if ($type < 0) {
  $errors[] = 'type must be selected';
}

// check period
if ($period == -1 || empty($period)) {
  $errors[] = 'period must be selected';
}

// check if array of errors is empty
if (empty($errors)) {
  // create an object of CompSUgg class
  if (!isset($comp_sugg_obj)) {
    $comp_sugg_obj = new CompSugg();
  }
  // switch case for period
  switch ($period) {
    case 'all':
      $condition = null;
      break;

    case 'today':
      $condition = "`added_date` = '" . get_date_now() . "'";
      break;

    case 'month':
      $start_date = Date('Y-m-1');
      $end_date   = Date('Y-m-31');
      $condition = "`added_date` BETWEEN '$start_date' AND '$end_date'";
      break;

    default:
      $condition = null;
      break;
  }

  // get data
  $data = $comp_sugg_obj->get_all_data($type, $_SESSION['sys']['UserID'], $_SESSION['sys']['company_id'], $condition);
  // check data count
  if ($data != null && count($data) > 0) {
?>
    <div class="container" dir="<?php echo $page_dir ?>">
      <!-- start table container -->
      <div class="table-responsive-sm">
        <!-- strst malfunctions table -->
        <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" style="width:100%">
          <thead class="primary text-capitalize">
            <tr>
              <th class="text-center" style="width: 20px">#</th>
              <th class="text-center"><?php echo lang('THE TYPE', @$_SESSION['sys']['lang']) ?></th>
              <th class="text-center"><?php echo lang('THE COMMENT', @$_SESSION['sys']['lang']) ?></th>
              <th class="text-center"><?php echo lang('ADDED DATE', @$_SESSION['sys']['lang']) ?></th>
              <th class="text-center"><?php echo lang('ADDED TIME', @$_SESSION['sys']['lang']) ?></th>
              <th class="text-center"><?php echo lang('CONTROL', @$_SESSION['sys']['lang']) ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $index => $row) { ?>
              <tr>
                <td><?php echo ++$index; ?></td>
                <td><?php echo $row['type'] == 0 ? lang('COMPLAINT', @$_SESSION['sys']['lang']) : lang('SUGGESTION', @$_SESSION['sys']['lang']) ?></td>
                <td><?php echo $row['message'] ?></td>
                <td><?php echo $row['added_date'] ?></td>
                <td><?php echo date_format(date_create($row['added_time']), 'h:i a') ?></td>
                <td><?php echo lang('CONTROL', @$_SESSION['sys']['lang']) ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
<?php
  } else {
    // include permission error module
    include_once $globmod . 'no-data-founded.php';
  }
} else {
  foreach ($errors as $key => $error) {
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} ?>