<?php
// create an object of Malfunction class
$mal_obj = !isset($mal_obj) ? new Malfunction() : $mal_obj;
// period value
$action = isset($_GET['period']) && !empty($_GET['period']) ? $_GET['period'] : 'all';
// malStatus of combination
$malStatus = isset($_GET['malStatus']) && !empty($_GET['malStatus']) ? $_GET['malStatus'] : '-1';
// is accept status of combination
$accepted = isset($_GET['accepted']) && !empty($_GET['accepted']) ? $_GET['accepted'] : '-1';
// get target year
$target_year = isset($_GET['year']) && !empty($_GET['year']) && filter_var(trim($_GET['year'], ""), FILTER_VALIDATE_INT) !== false ? trim($_GET['year'], "") : Date('Y');

// title
$title = "MALS";

// base query
$baseQuery = "SELECT *FROM `malfunctions`";

// switch case to prepare the condition of the cobination
switch ($malStatus) {
  case 'unrepaired':
    $title .= " UNFINISHED";
    $conditionStatus = "`mal_status` = 0 AND `isAccepted` <> 2";
    break;
  case 'repaired':
    $title .= " FINISHED";
    $conditionStatus = "`mal_status` = 1";
    break;
  case 'delayed':
    $title .= " DELAYED";
    $conditionStatus = "(`mal_status` = 2 OR `isAccepted` = 2)";
    break;
  default:
    $conditionStatus = "";
}

// switch case to prepare the condition of the cobination
switch ($accepted) {
  case 'notAccepted':
    $title .= " NOT ACCEPTED";
    $acceptedStatus = "`isAccepted` = 0";
    break;
  case 'accepted':
    $title .= " ACCEPTED";
    $acceptedStatus = "`isAccepted` = 1";
    break;
  case 'delayed':
    $title .= " DELAYED";
    $acceptedStatus = "(`mal_status` = 2 OR `isAccepted` = 2)";
    break;
  default:
    $acceptedStatus = "";
}

// switch case to prepare period of the query
switch ($action) {
  case 'today':
    $title .= " TODAY";
    $conditionPeriod = " `created_at` = '" . get_date_now() . "'";
    break;
  case 'month':
    $title .= " MONTH";
    $conditionPeriod = " `created_at` BETWEEN '" . Date('Y-m-1') . "' AND '" . Date('Y-m-30') . "'";
    break;
  case 'previous-month':
    $title .= " PREV MONTH";
    // date of today
    $start = Date("Y-m-1");
    $end = Date("Y-m-30");
    // license period
    $period = ' - 1 months';
    $startDate = Date("Y-m-d", strtotime($start . $period));
    $endDate = Date("Y-m-d", strtotime($end . $period));
    // period condition
    $conditionPeriod = " `created_at` BETWEEN '$startDate' AND '$endDate'";
    break;
  default:
    $title = $target_year != Date('Y') ? "{$title}" : "TOTAL {$title}";
    $conditionPeriod = " YEAR(`created_at`) = '{$target_year}'";
}

// check the logged user is tech or not
$userCondition = $_SESSION['sys']['is_tech'] == 1 ? "`tech_id` = " . base64_decode($_SESSION['sys']['UserID']) : "";
// check the combination status condition
if (!empty($conditionStatus)) {
  // append combination status condition
  $baseQuery .= ' WHERE ' . $conditionStatus;
  // check type of combinations
  if (!empty($acceptedStatus)) {
    $baseQuery .= ' AND ' . $acceptedStatus;
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' AND ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    }
  } else {
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' AND ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    }
  }
} else {
  // check type of combinations
  if (!empty($acceptedStatus)) {
    $baseQuery .= ' WHERE ' . $acceptedStatus;
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' AND ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    }
  } else {
    // check the condition period
    if (!empty($conditionPeriod)) {
      $baseQuery .= ' WHERE ' . $conditionPeriod;
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' AND ' . $userCondition;
      }
    } else {
      // check user condition
      if (!empty($userCondition)) {
        $baseQuery .= ' WHERE ' . $userCondition;
      }
    }
  }
}

// company condition
$company_condition = empty($conditionStatus) && empty($acceptedStatus) && empty($conditionPeriod) && empty($userCondition) ? ' WHERE `company_id` = ' . base64_decode($_SESSION['sys']['company_id']) . ' AND `deleted_at` IS NULL ORDER BY `created_at` ASC' : ' AND `company_id` = ' . base64_decode($_SESSION['sys']['company_id']) . ' AND `deleted_at` IS NULL ORDER BY `created_at` ASC';

// query
$malfunction_query = $baseQuery . $company_condition;

// prepaire the query
$stmt = $con->prepare($malfunction_query);
$stmt->execute(); // execute query
$rows = $stmt->fetchAll(); // fetch data
$count = $stmt->rowCount(); // get row count
?>
<div class="container mb-0" dir="<?php echo $page_dir ?>">
  <?php if ($_SESSION['sys']['mal_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
    <div class="mb-3">
      <a href="?do=add-new-malfunction" class="btn btn-outline-primary py-1 fs-12 shadow-sm">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD NEW', $lang_file) ?>
      </a>
    </div>
  <?php } ?>

</div>
<!-- start edit profile page -->
<?php if ($count > 0) { ?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start table container -->
    <div class="section-block">
      <!-- start header -->
      <header class="section-header mb-3">
        <h2 class="h2 text-capitalize">
          <?php $title = $target_year != Date('Y') ? lang($title . " OF THE YEAR", $lang_file) . " {$target_year}" : lang($title, $lang_file) ?>
          <?php echo $title; ?>
          <hr>
        </h2>
      </header>
      <div class="table-responsive-sm">
        <!-- strst malfunctions table -->
        <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo $count <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="[-1]" style="width:100%">
          <thead class="primary text-capitalize">
            <tr>
              <th style="width: 20px">#</th>
              <th>
                <?php echo lang('ADMIN NAME', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('TECH NAME', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('NAME', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('MAL DESC', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('TECH COMMENT', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('ADDED DATE') ?>
              </th>
              <th>
                <?php echo lang('STATUS', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('CONTROL') ?>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $index => $row) { ?>
              <tr>
                <!-- row index -->
                <td>
                  <?php echo ($index + 1) ?>
                </td>
                <!-- admin username -->
                <td>
                  <?php
                  // check if exist
                  $is_exist_admin = $mal_obj->is_exist("`UserID`", "`users`", $row['mng_id']);
                  // if exist
                  if ($is_exist_admin) {
                    $admin_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $row['mng_id'])[0]['username'];
                  ?>
                    <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['mng_id']); ?>">
                      <?php echo $admin_name ?>
                    </a>
                  <?php } else { ?>
                    <span class="text-danger">
                      <?php echo lang('WAS DELETED', $lang_file) ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- technical username -->
                <td>
                  <?php
                  // check if exist
                  $is_exist_tech = $mal_obj->is_exist("`UserID`", "`users`", $row['tech_id']);
                  // if exist
                  if ($is_exist_tech) {
                    $tech_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $row['tech_id'])[0]['username']; ?>
                    <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['tech_id']); ?>">
                      <?php echo $tech_name ?>
                    </a>
                  <?php } else { ?>
                    <span class="text-danger">
                      <?php echo lang('WAS DELETED', $lang_file) ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- piece/client name -->
                <td>
                  <?php
                  // check if exist
                  $is_exist_device = $mal_obj->is_exist("`id`", "`pieces_info`", $row['client_id']);
                  // if exist
                  if ($is_exist_device) {
                    // get info
                    $info = $mal_obj->select_specific_column("`full_name`, `is_client`", "`pieces_info`", "WHERE `id` = " . $row['client_id'] . " LIMIT 1")[0];
                    // get name
                    $name = $info['full_name'];
                    // get type
                    $is_client = $info['is_client'];
                    // prepare url
                    if ($is_client == 1) {
                      $url = $nav_up_level . "clients/index.php?do=edit-client&client-id=" . base64_encode($row['client_id']);
                    } else {
                      $url = "?do=edit-piece&piece-id=" . base64_encode($row['client_id']);
                    }
                  ?>
                    <a href="<?php echo $url ?>">
                      <?php echo wordwrap($name, 50, "<br>") ?>
                    </a>
                  <?php } else { ?>
                    <span class="text-danger fs-12">
                      <?php echo lang('WAS DELETED', $lang_file) ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- malfunction description -->
                <td>
                  <?php
                  if (strlen($row['descreption']) > 0 && !empty($row['descreption'])) {
                    echo wordwrap($row['descreption'], 50, "<br>");
                  } else { ?>
                    <span class="text-danger fs-12">
                      <?php echo lang('NO DATA') ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- technical man comment -->
                <td>
                  <?php if (!empty($row['tech_comment'])) { ?>
                    <?php echo wordwrap($row['tech_comment'], 50, "<br>"); ?>
                  <?php } else { ?>
                    <span class="text-danger fs-12">
                      <?php echo lang('NOT ASSIGNED'); ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- added date -->
                <td>
                  <?php echo wordwrap(date_format(date_create($row['created_at']), "h:i:sa d/m/Y"), 11, "<br>") ?>
                </td>
                <!-- malfunction status -->
                <td>
                  <?php
                  if ($row['mal_status'] == 0) {
                    $iconStatus = "bi-x-circle-fill text-danger";
                    $titleStatus = lang('UNFINISHED', $lang_file);
                  } elseif ($row['mal_status'] == 1) {
                    $iconStatus = "bi-check-circle-fill text-success";
                    $titleStatus = lang('FINISHED', $lang_file);
                  } elseif ($row['mal_status'] == 2) {
                    $iconStatus = "bi-exclamation-circle-fill text-warning";
                    $titleStatus = lang('DELAYED', $lang_file);
                  } else {
                    $iconStatus = "bi-dash-circle-fill text-info";
                    $titleStatus = lang('NOT ASSIGNED');
                  }
                  ?>
                  <span>
                    <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                    <span><?php echo $titleStatus ?></span>
                  </span>
                  <br>
                  <?php
                  $have_media = $mal_obj->count_records("`id`", "`malfunctions_media`", "WHERE `mal_id` = " . $row['mal_id']);
                  if ($have_media > 0) {
                    $icon = "bi-check-circle-fill text-success";
                    $title = lang('HAVE MEDIA', $lang_file);
                  } else {
                    $icon = "bi-x-circle-fill text-danger";
                    $title = lang('NO MEDIA', $lang_file);
                  }
                  ?>
                  <span>
                    <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                    <span><?php echo $title ?></span>
                  </span>
                </td>
                <!-- control buttons -->
                <td>
                  <div class="mt-1 hstack gap-1">
                    <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
                      <a href="?do=edit-malfunction-info&malid=<?php echo base64_encode($row['mal_id']) ?>" target="" class="btn btn-outline-primary m-1 fs-12" style="width: 110px">
                        <i class="bi bi-eye"></i>
                        <?php echo lang('SHOW DETAILS') ?>
                      </a>
                    <?php } ?>
                    <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                      <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo base64_encode($row['mal_id']) ?>" onclick="put_mal_data_into_modal(this, true)" style="width: 80px">
                        <i class="bi bi-trash"></i>
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
  </div>
  <!-- delete malfunction modal -->
  <?php if ($count > 0 && $_SESSION['sys']['mal_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
    include_once 'delete-malfunction-modal.php';
  } ?>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>