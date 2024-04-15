<?php
$is_contain_table = true;

$techCondition1 = "";
$techCondition2 = "";

// create an object of Combination
$comb_obj = new Combination();

if ($_SESSION['sys']['comb_show'] == 1 && $_SESSION['sys']['is_tech'] == 1) {
  $techCondition1 = "AND `UserID` = " . base64_decode($_SESSION['sys']['UserID']);
  $techCondition2 = "WHERE `UserID` = " . base64_decode($_SESSION['sys']['UserID']);
} else {
  $techCondition1 = "";
  $techCondition2 = "";
}

// check year was set or no
if (isset($_GET['year']) && !empty($_GET['year']) && filter_var(trim($_GET['year'], ""), FILTER_VALIDATE_INT) !== false && trim($_GET['year'], "") >= 2020) {
  $target_year = trim($_GET['year'], "");
} else {
  $target_year = Date('Y');
}
?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <?php if ($_SESSION['sys']['comb_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
      <div class="mb-3">
        <a href="?do=add-new-combination" class="btn btn-outline-primary py-1 shadow-sm fs-12">
          <i class="bi bi-plus"></i>
          <?php echo lang("ADD NEW", $lang_file) ?>
        </a>
      </div>
    <?php } ?>
    <!-- start new design -->
    <div class="mb-3 row g-3">
      <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize">
              <?php echo lang('YOU ARE SHOWING DATA FOR THE YEAR') . " {$target_year}" ?>
            </h5>
            <hr>
          </header>
          <form action="" method="get" name="malfunction-year-form">
            <input type="hidden" name="do" value="manage">
            <div class="row g-3 align-items-baseline">
              <div class="col-7">
                <div class="form-floating mb-3">
                  <select class="form-select" id="year" name="year">
                    <option disabled <?php echo !in_array($target_year, $conf['data_years']) ? 'selected' : '' ?>>
                      <?php echo lang('SELECT YEAR', $lang_file) ?>
                    </option>
                    <?php foreach ($conf['data_years'] as $key => $year) { ?>
                      <option value="<?php echo $year ?>" <?php echo $target_year == $year ? 'selected' : '' ?>>
                        <?php echo $year ?>
                      </option>
                    <?php } ?>
                  </select>
                  <label for="year">
                    <?php echo lang('THE YEAR') ?>
                  </label>
                </div>
              </div>
              <div class="col-5">
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-check-all"></i>
                  <?php echo lang('APPLY') ?>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
      <?php if ($target_year == Date('Y')) { ?>
        <!-- combinations of today -->
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('COMBS TODAY', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang('TODAY NOTE', $lang_file) ?>
              </p>
              <hr>
            </header>
            <div class="row row-cols-sm-2 gx-3 gy-5">
              <div class="col-6">
                <div class="dashboard-card card card-stat card-primary bg-gradient">
                  <div class="card-body">
                    <?php $all_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}") ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('TOTAL', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $all_comb_today ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=today&combStatus=-1&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-danger bg-gradient">
                  <div class="card-body">
                    <?php $unfinished_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE (`isFinished` = 0 AND `isAccepted` <> 2) AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}") ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('UNFINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $unfinished_comb_today ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=today&combStatus=unfinished&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-success bg-gradient">
                  <div class="card-body">
                    <?php $finished_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `isFinished` = 1 AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}") ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('FINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $finished_comb_today ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=today&combStatus=finished&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-warning bg-gradient">
                  <div class="card-body">
                    <?php $delayed_comb_today = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE (`isAccepted` = 2 OR `isFinished` = 2) AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}") ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('DELAYED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $delayed_comb_today ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=today&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- combinations of this month -->
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('COMBS MONTH', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang('MONTH NOTE', $lang_file) ?>
              </p>
              <hr>
            </header>
            <?php $startDate = Date('Y-m-1'); ?>
            <?php $endDate = Date('Y-m-31'); ?>
            <div class="row row-cols-sm-2 gx-3 gy-5">
              <div class="col-6">
                <div class="dashboard-card card card-stat card-primary bg-gradient">
                  <div class="card-body">
                    <?php $all_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('TOTAL', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $all_comb_month ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=month&combStatus=-1&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-danger bg-gradient">
                  <div class="card-body">
                    <?php $unfinished_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND `isFinished` = 0 AND `isAccepted` <> 2 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('UNFINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $unfinished_comb_month ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=month&combStatus=unfinished&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-success bg-gradient">
                  <div class="card-body">
                    <?php $finished_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND `isFinished` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('FINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $finished_comb_month ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=month&combStatus=finished&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-warning bg-gradient">
                  <div class="card-body">
                    <?php $delayed_comb_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND (`isAccepted` = 2 OR `isFinished` = 2) AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('DELAYED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $delayed_comb_month ?>)</h5>
                  </div>
                  <a href="?do=show-combination-details&period=month&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php if (Date('m') > 1) { ?>
          <!-- combinations of previous month -->
          <div class="col-12">
            <div class="section-block">
              <header class="section-header">
                <h5 class="h5 text-capitalize">
                  <?php echo lang('COMBS PREV MONTH', $lang_file) ?>
                </h5>
                <p class="text-muted ">
                  <?php echo lang('PREV MONTH NOTE', $lang_file) ?>
                </p>
                <hr>
              </header>
              <?php
              // date of today
              $start = Date("Y-m-1");
              $end = Date("Y-m-30");
              // license period
              $period = ' - 1 months';
              $startDate = Date("Y-m-d", strtotime($start . $period));
              $endDate = Date("Y-m-d", strtotime($end . $period));
              ?>
              <div class="row row-cols-sm-2 gx-3 gy-5">
                <div class="col-6">
                  <div class="dashboard-card card card-stat card-primary bg-gradient">
                    <div class="card-body">
                      <?php $all_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('TOTAL', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $all_comb_prev_month ?>)</h5>
                    </div>
                    <a href="?do=show-combination-details&period=previous-month&combStatus=-1&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
                <div class="col-6">
                  <div class="dashboard-card card card-stat bg-danger bg-gradient">
                    <div class="card-body">
                      <?php $unfinished_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND `isFinished` = 0 AND `isAccepted` <> 2 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('UNFINISHED', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $unfinished_comb_prev_month ?>)</h5>
                    </div>
                    <a href="?do=show-combination-details&period=previous-month&combStatus=unfinished&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
                <div class="col-6">
                  <div class="dashboard-card card card-stat bg-success bg-gradient">
                    <div class="card-body">
                      <?php $finished_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND `isFinished` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('FINISHED', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $finished_comb_prev_month ?>)</h5>
                    </div>
                    <a href="?do=show-combination-details&period=previous-month&combStatus=finished&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
                <div class="col-6">
                  <div class="dashboard-card card card-stat bg-warning bg-gradient">
                    <div class="card-body">
                      <?php $delayed_comb_prev_month = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) BETWEEN '{$startDate}' AND '{$endDate}' AND (`isAccepted` = 2 OR `isFinished` = 2) AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('DELAYED', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $delayed_comb_prev_month ?>)</h5>
                    </div>
                    <a href="?do=show-combination-details&period=previous-month&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
      <!-- total combinations -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize">
              <?php echo lang('TOTAL COMBS', $lang_file) ?>
            </h5>
            <p class="text-muted ">
              <?php echo lang('TOTAL COMBS NOTE', $lang_file) ?>
            </p>
            <hr>
          </header>
          <div class="row row-cols-sm-2 gx-3 gy-5">
            <div class="col-6">
              <div class="dashboard-card card card-stat card-primary bg-gradient">
                <div class="card-body">
                  <?php $all_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "$techCondition2 " . (empty($techCondition2) ? "WHERE YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) : "AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])) . " AND `deleted_at` IS NULL"); ?>
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('TOTAL', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $all_comb ?>)</h5>
                </div>
                <a href="?do=show-combination-details&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-6">
              <div class="dashboard-card card card-stat bg-danger bg-gradient">
                <div class="card-body">
                  <?php $all_unfinished_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `isFinished` = 0 AND `isAccepted` <> 2 AND YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('UNFINISHED', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $all_unfinished_comb ?>)</h5>
                </div>
                <a href="?do=show-combination-details&combStatus=unfinished&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-6">
              <div class="dashboard-card card card-stat bg-success bg-gradient">
                <div class="card-body">
                  <?php $all_finished_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE `isFinished` = 1 AND YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('FINISHED', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $all_finished_comb ?>)</h5>
                </div>
                <a href="?do=show-combination-details&combStatus=finished&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-6">
              <div class="dashboard-card card card-stat bg-warning bg-gradient">
                <div class="card-body">
                  <?php $all_delayed_comb = $comb_obj->count_records("`comb_id`", "`combinations`", "WHERE (`isAccepted` = 2 OR `isFinished` = 2) AND YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL {$techCondition1}"); ?>
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('DELAYED', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $all_delayed_comb ?>)</h5>
                </div>
                <a href="?do=show-combination-details&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($all_comb > 0) { ?>
      <div class="mb-3 row row-cols-sm-1 align-items-center justify-content-center">
        <!-- combinations rating -->
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang("COMBS RATING", $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang("COMBS RATING NOTE", $lang_file) ?>
              </p>
              <hr>
            </header>
            <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
              <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3 align-items-center justify-content-center g-5">
                <div class="col-12">
                  <?php $rep_rate = round(($all_finished_comb / $all_comb) * 100, 2); ?>
                  <h5 class="card-title text-capitalize text-center">
                    <?php echo lang('FINISHED', $lang_file) ?>
                    <div class="badge bg-success p-2 d-inline-block"></div>
                  </h5>
                  <div class="progress">
                    <?php if ($rep_rate < 15) { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>">
                      </div>
                      <div class="progress-value">
                        <?php echo $rep_rate ?>%
                      </div>
                    <?php } else { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>">
                        <?php echo $rep_rate ?>%
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-12">
                  <?php $unrep_rate = round(($all_unfinished_comb / $all_comb) * 100, 2); ?>
                  <h5 class="card-title text-capitalize text-center">
                    <?php echo lang('UNFINISHED', $lang_file) ?>
                    <div class="badge bg-danger p-2 d-inline-block"></div>
                  </h5>
                  <div class="progress">
                    <?php if ($unrep_rate < 15) { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>">
                      </div>
                      <div class="progress-value">
                        <?php echo $unrep_rate ?>%
                      </div>
                    <?php } else { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>">
                        <?php echo $unrep_rate ?>%
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-12">
                  <?php $del_rate = round(($all_delayed_comb / $all_comb) * 100, 2); ?>
                  <h5 class="card-title text-capitalize text-center">
                    <?php echo lang('DELAYED', $lang_file) ?>
                    <div class="badge bg-warning p-2 d-inline-block"></div>
                  </h5>
                  <div class="progress">
                    <?php if ($del_rate < 15) { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>">
                      </div>
                      <div class="progress-value">
                        <?php echo $del_rate ?>%
                      </div>
                    <?php } else { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_comb ?>">
                        <?php echo $del_rate ?>%
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <p class="lead text-danger">
                <?php echo lang('FEATURE NOT AVAILABLE') ?>
              </p>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if (isset($all_comb_today) && $all_comb_today > 0) { ?>
      <!-- some combinations of today -->
      <div class="mb-3 row row-cols-sm-1 align-items-center-justify-content-center">
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('COMBS TODAY', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang('SOME COMBS NOTE', $lang_file) ?>
              </p>
              <hr>
            </header>
            <?php
            // get `combinations` of today of the cureent employee
            $today_comb = $comb_obj->select_specific_column("*", "`combinations`", "WHERE Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL " . $techCondition1 ." ORDER BY `created_at` DESC LIMIT 5", 'multiple');
            ?>
            <div class="table-responsive-sm">
              <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" data-scroll-y="<?php echo $all_comb_today <= 5 ? 'auto' : 400 ?>" data-last-td=" null" style="width:100%">
                <thead class="primary text-capitalize">
                  <tr>
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
                      <?php echo lang('TECH NAME', $lang_file) ?>
                    </th>
                    <th>
                      <?php echo lang('STATUS', $lang_file) ?>
                    </th>
                    <th>
                      <?php echo lang('MEDIA', $lang_file) ?>
                    </th>
                    <th>
                      <?php echo lang('CONTROL') ?>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($today_comb as $index => $comb) { ?>
                    <tr class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <td>
                        <?php echo wordwrap($comb['client_name'], 50, "<br>") ?>
                      </td>
                      <td>
                        <?php echo wordwrap($comb['address'], 50, "<br>") ?>
                      </td>
                      <td>
                        <?php echo $comb['phone'] ?>
                      </td>
                      <td>
                        <?php $techName = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $comb['UserID'])['username']; ?>
                        <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($comb['UserID']); ?>">
                          <?php echo $techName ?>
                        </a>
                      </td>
                      <td>
                        <?php
                        if ($comb['isFinished'] == 0) {
                          $icon = "bi-x-circle-fill text-danger";
                          $title = lang('UNFINISHED', $lang_file);
                        } elseif ($comb['isFinished'] == 1) {
                          $icon = "bi-check-circle-fill text-success";
                          $title = lang('FINISHED', $lang_file);
                        } else {
                          $icon = "bi-dash-circle-fill text-info";
                          $title = lang('NOT ASSIGNED');
                        }
                        ?>
                        <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                      </td>
                      <td>
                        <?php
                        $have_media = $comb_obj->count_records("`id`", "`combinations_media`", "WHERE `comb_id` = " . $comb['comb_id']);
                        if ($have_media > 0) {
                          $icon = "bi-check-circle-fill text-success";
                          $title = lang('HAVE MEDIA', $lang_file);
                        } else {
                          $icon = "bi-x-circle-fill text-danger";
                          $title = lang('NO MEDIA', $lang_file);
                        }
                        ?>
                        <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                      </td>
                      <td>
                        <?php if ($_SESSION['sys']['comb_show'] == 1 || $_SESSION['sys']['comb_delete'] == 1) { ?>
                          <div class="hstack gap-1">
                            <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
                              <a href="?do=edit-combination&combid=<?php echo base64_encode($comb['comb_id']) ?>" target="" class="btn btn-outline-primary me-1 fs-12">
                                <i class="bi bi-eye"></i>
                                <?php echo lang('SHOW DETAILS') ?>
                              </a>
                            <?php } ?>
                            <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                              <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-combination-id="<?php echo base64_encode($comb['comb_id']) ?>" onclick="confirm_delete_combination(this, true)">
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
          </div>
        </div>
      </div>
    <?php } ?>


    <?php $latest_comb = $comb_obj->get_latest_records("*", "`combinations`", "$techCondition2 " . (empty($techCondition2) ? "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']) : "AND `company_id` = " . base64_decode($_SESSION['sys']['company_id'])) . " AND YEAR(`created_at`) = '{$target_year}' AND `deleted_at` IS NULL", "`created_at`"); ?>
    <?php if (!empty($latest_comb)) { ?>
      <div class="mb-3 row row-cols-sm-1 align-items-center-justify-content-center">
        <!-- latest added combinations -->
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('LATEST COMBS', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang("LATEST COMBS NOTE", $lang_file) ?>
              </p>
              <hr>
            </header>
            <div class="table-responsive-sm">
              <table class="table table-bordered table-striped display compact" data-scroll-x="true" data-scroll-y="<?php echo count($latest_comb) <= 5 ? 'auto' : 400 ?>" data-last-td=" null" style="width:100%">
                <thead class="primary text-capitalize">
                  <tr>
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
                      <?php echo lang('TECH NAME', $lang_file) ?>
                    </th>
                    <th>
                      <?php echo lang('STATUS', $lang_file) ?>
                    </th>
                    <th>
                      <?php echo lang('ADDED DATE') ?>
                    </th>
                    <th>
                      <?php echo lang('MEDIA', $lang_file) ?>
                    </th>
                    <th>
                      <?php echo lang('CONTROL') ?>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($latest_comb as $index => $comb) { ?>
                    <tr class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <td>
                        <?php echo wordwrap($comb['client_name'], 50, "<br>") ?>
                      </td>
                      <td>
                        <?php echo wordwrap($comb['address'], 50, "<br>") ?>
                      </td>
                      <td>
                        <?php echo $comb['phone'] ?>
                      </td>
                      <td>
                        <?php
                        $tech_name = "";
                        if ($comb_obj->is_exist("`UserID`", "`users`", $comb['UserID'])) {
                          $tech_name = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $comb['UserID'])['username'];
                        }
                        ?>
                        <?php if (!empty($tech_name)) { ?>
                          <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($comb['UserID']) ?>">
                            <?php echo $tech_name ?>
                          </a>
                        <?php } else { ?>
                          <span class="text-danger fs-12">
                            <?php echo lang('NO DATA'); ?>
                          </span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        if ($comb['isFinished'] == 0) {
                          $icon = "bi-x-circle-fill text-danger";
                          $title = lang('UNFINISHED', $lang_file);
                        } elseif ($comb['isFinished'] == 1) {
                          $icon = "bi-check-circle-fill text-success";
                          $title = lang('FINISHED', $lang_file);
                        } else {
                          $icon = "bi-dash-circle-fill text-info";
                          $title = lang('NOT ASSIGNED');
                        }
                        ?>
                        <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                      </td>
                      <td>
                        <?php echo !is_null($comb['created_at']) ? date_format(date_create($comb['created_at']), 'h:i:sa d-m-Y') : '-'  ?>
                      </td>
                      <td>
                        <?php
                        $have_media = $comb_obj->count_records("`id`", "`combinations_media`", "WHERE `comb_id` = " . $comb['comb_id']);
                        if ($have_media > 0) {
                          $icon = "bi-check-circle-fill text-success";
                          $title = lang('HAVE MEDIA', $lang_file);
                        } else {
                          $icon = "bi-x-circle-fill text-danger";
                          $title = lang('NO MEDIA', $lang_file);
                        }
                        ?>
                        <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                      </td>
                      <td>
                        <?php if ($_SESSION['sys']['comb_show'] == 1 || $_SESSION['sys']['comb_delete'] == 1) { ?>
                          <div class="hstack gap-1">
                            <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
                              <a href="?do=edit-combination&combid=<?php echo base64_encode($comb['comb_id']) ?>" target="" class="btn btn-outline-primary m-1 fs-12" style="width: 150px">
                                <i class="bi bi-eye"></i>
                                <?php echo lang('SHOW DETAILS') ?>
                              </a>
                            <?php } ?>
                            <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                              <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-comb" data-combination-id="<?php echo base64_encode($comb['comb_id']) ?>" onclick="confirm_delete_combination(this, true)" style="width: 80px">
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
          </div>
        </div>
      </div>
    <?php } ?>
    <!-- end new design -->
  </div>
  <!-- end stats -->
</div>
<!-- end home stats container -->

<?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
  include_once 'delete-modal.php';
} ?>