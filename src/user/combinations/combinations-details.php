<?php
// create an object of Combin class
$comb_obj = !isset($comb_obj) ? new Combination() : $comb_obj;
// period value
$period = isset($_GET['period']) && !empty($_GET['period']) ? $_GET['period'] : 'all';
// combStatus of combination
$combStatus = isset($_GET['combStatus']) && !empty($_GET['combStatus']) ? $_GET['combStatus'] : '-1';
// is accept status of combination
$accepted = isset($_GET['accepted']) && !empty($_GET['accepted']) ? $_GET['accepted'] : '-1';
// get target year
$target_year = isset($_GET['year']) && !empty($_GET['year']) && filter_var(trim($_GET['year'], ""), FILTER_VALIDATE_INT) !== false ? trim($_GET['year'], "") : Date('Y');

// title
$title = "COMBS";

// base query
$baseQuery = "SELECT *FROM `combinations`";

// switch case to prepare the condition of the cobination
switch ($combStatus) {
  case 'unfinished':
    $title .= " UNFINISHED";
    $conditionStatus = "`isFinished` = 0 AND `isAccepted` <> 2";
    break;
  case 'finished':
    $title .= " FINISHED";
    $conditionStatus = "`isFinished` = 1";
    break;
  case 'delayed':
    $title .= " DELAYED";
    $conditionStatus = "`isAccepted` = 2 OR `isFinished` = 2";
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
    $acceptedStatus = "(`isAccepted` = 2 OR `isFinished` = 2)";
    break;
  default:
    $acceptedStatus = "";
}

// switch case to prepare period of the query
switch ($period) {
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

// switch case for the logged user is tech or not
$userCondition = $_SESSION['sys']['is_tech'] == 1 ? "`UserID` = " . base64_decode($_SESSION['sys']['UserID']) : "";

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
$combination_query = $baseQuery . $company_condition;

// prepaire the query
$stmt = $con->prepare($combination_query);
$stmt->execute(); // execute query
$rows = $stmt->fetchAll(); // fetch data
$count = $stmt->rowCount(); // get row count

?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if ($_SESSION['sys']['comb_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
    <div class="mb-3">
      <a href="?do=add-new-combination" class="btn btn-outline-primary py-1 shadow-sm fs-12">
        <i class="bi bi-plus"></i>
        <?php echo lang("ADD NEW", $lang_file) ?>
      </a>
    </div>
  <?php } ?>

</div>
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
      <table class="table table-bordered table-striped display compact" data-scroll-x="true" data-scroll-y="<?php echo $count <= 5 ? 'auto' : 500 ?>" data-last-td="[-1]" style="width:100%">
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
              <?php echo lang('BENEFICIARY NAME', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('ADDR', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('PHONE', $lang_file) ?>
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
              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php echo ($index + 1) ?>
              </td>
              <!-- admin username -->
              <td>
                <?php
                // check if exist
                $is_exist_admin = $comb_obj->is_exist("`UserID`", "`users`", $row['addedBy']);
                // if exist
                if ($is_exist_admin) {
                  $admin_name = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $row['addedBy'])[0]['username'];
                ?>
                  <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['addedBy']); ?>">
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
                $is_exist_tech = $comb_obj->is_exist("`UserID`", "`users`", $row['UserID']);
                // if exist
                if ($is_exist_tech) {
                  $tech_name = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $row['UserID'])[0]['username']; ?>
                  <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($row['UserID']); ?>">
                    <?php echo $tech_name ?>
                  </a>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('WAS DELETED', $lang_file) ?>
                  </span>
                <?php } ?>
              </td>

              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php echo wordwrap($row['client_name'], 50, "<br>") ?>
              </td>
              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php if (!empty($row['address'])) { ?>
                  <span>
                    <?php echo wordwrap($row['address'], 50, "<br>") ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <?php if (!empty($row['phone'])) { ?>
                  <span>
                    <?php echo $row['phone'] ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?> <?php echo empty($row['tech_comment']) ? 'text-danger ' : '' ?>">
                <?php if (!empty($row['tech_comment'])) { ?>
                  <span>
                    <?php echo wordwrap($row['tech_comment'], 50, "<br>") ?>
                  </span>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- added date -->
              <td>
                <?php echo date_format(date_create($row['created_at']), "h:i:sa d/m/Y") ?>
              </td>
              <td>
                <?php
                if ($row['isFinished'] == 0) {
                  $icon = "bi-x-circle-fill text-danger";
                  $titleStatus = lang('UNFINISHED', $lang_file);
                } elseif ($row['isFinished'] == 1) {
                  $icon = "bi-check-circle-fill text-success";
                  $titleStatus = lang('FINISHED', $lang_file);
                } else {
                  $icon = "bi-exclamation-circle-fill text-warning";
                  $titleStatus = lang('DELAYED');
                }
                ?>
                <span>
                  <i class="bi <?php echo $icon ?>" title="<?php echo $titleStatus ?>"></i>
                  <span><?php echo $titleStatus ?></span>
                </span>
                <br>
                <?php
                $have_media = $comb_obj->count_records("`id`", "`combinations_media`", "WHERE `comb_id` = " . $row['comb_id']);
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
              <td>
                <?php if ($_SESSION['sys']['comb_show'] == 1 || $_SESSION['sys']['comb_delete'] == 1) { ?>
                  <div class="mt-1 hstack gap-1 ">
                    <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
                      <a href="?do=edit-combination&combid=<?php echo base64_encode($row['comb_id']) ?>" class="btn btn-outline-primary fs-12" style="width: 110px">
                        <i class="bi bi-eye"></i>
                        <?php echo lang('SHOW DETAILS') ?>
                      </a>
                    <?php } ?>
                    <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                      <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-comb-id="<?php echo base64_encode($row['comb_id']) ?>" onclick="put_comb_data_into_modal(this, true)" style="width: 80px">
                        <i class="bi bi-trash"></i>
                        <?php echo lang('DELETE') ?>
                      </button>
                    <?php } ?>
                  </div>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <!-- delete combination modal -->
    <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
      include_once 'delete-combination-modal.php';
    } ?>
  </div>
<?php } else {
  // include no data founded module
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>