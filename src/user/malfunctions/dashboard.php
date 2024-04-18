<?php
// technical man condition
$techCondition1 = "";
$techCondition2 = "";

// create an object of Malfunction class
$mal_obj = new Malfunction();

// check permissions
if ($_SESSION['sys']['mal_show'] == 1) {
  $techCondition1 = $_SESSION['sys']['is_tech'] == 1 ? "AND `tech_id` = " . base64_decode($_SESSION['sys']['UserID']) : "";
  $techCondition2 = $_SESSION['sys']['is_tech'] == 1 ? "WHERE `tech_id` = " . base64_decode($_SESSION['sys']['UserID']) : "";
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
    <?php if ($_SESSION['sys']['mal_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
      <div class="mb-3 hstack gap-3">
        <a href="?do=add-new-malfunction" class="btn btn-outline-primary py-1 fs-12 shadow-sm">
          <i class="bi bi-plus"></i>
          <?php echo lang('ADD NEW', $lang_file) ?>
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
        <!-- malfunction of today section -->
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('MALS TODAY', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang("TODAY NOTE", $lang_file) ?>
              </p>
              <hr>
            </header>
            <div class="row row-cols-sm-2 g-3">
              <div class="col-6">
                <div class="dashboard-card card card-stat card-primary bg-gradient">
                  <?php $all_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1") ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('TOTAL', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $all_mal_today; ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=today&malStatus=all&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-danger bg-gradient">
                  <?php $unrep_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1") ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('UNFINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $unrep_mal_today; ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=today&malStatus=unrepaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-success bg-gradient">
                  <?php $rep_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1") ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('FINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $rep_mal_today ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=today&malStatus=repaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-warning bg-gradient">
                  <?php $del_mal_today = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1") ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('DELAYED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $del_mal_today ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=today&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- malfunctions of this month -->
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang("MALS MONTH", $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang("MONTH NOTE", $lang_file) ?>
              </p>
              <hr>
            </header>
            <?php $start_date = Date('Y-m-1'); ?>
            <?php $end_date = Date('Y-m-30'); ?>
            <div class="row row-cols-sm-2 g-3">
              <div class="col-6">
                <div class="dashboard-card card card-stat card-primary bg-gradient">
                  <?php $all_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('TOTAL', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $all_mal_month ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=month&malStatus=all&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-danger bg-gradient">
                  <?php $unrep_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('UNFINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $unrep_mal_month ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=month&malStatus=unrepaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-success bg-gradient">
                  <?php $rep_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('FINISHED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $rep_mal_month ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=month&malStatus=repaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
              <div class="col-6">
                <div class="dashboard-card card card-stat bg-warning bg-gradient">
                  <?php $del_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                  <div class="card-body">
                    <h5 class="card-title text-capitalize">
                      <?php echo lang('DELAYED', $lang_file) ?>
                    </h5>
                    <h5>(<?php echo $del_mal_month ?>)</h5>
                  </div>
                  <a href="?do=show-malfunction-details&period=month&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php if (Date('m') > 1) { ?>
          <!-- malfunctions of previous month -->
          <div class="col-12">
            <div class="section-block">
              <header class="section-header">
                <h5 class="h5 text-capitalize">
                  <?php echo lang("MALS PREV MONTH", $lang_file) ?>
                </h5>
                <p class="text-muted ">
                  <?php echo lang("PREV MONTH NOTE", $lang_file) ?>
                </p>
                <hr>
              </header>
              <?php
              // date of today
              $start = Date("Y-m-1");
              $end = Date("Y-m-30");
              // license period
              $period = ' - 1 months';
              $start_date = Date("Y-m-d", strtotime($start . $period));
              $end_date = Date("Y-m-d", strtotime($end . $period));
              ?>
              <div class="row row-cols-sm-2 g-3">
                <div class="col-6">
                  <div class="dashboard-card card card-stat card-primary bg-gradient">
                    <?php $all_prev_mal_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                    <div class="card-body">
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('TOTAL', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $all_prev_mal_month ?>)</h5>
                    </div>
                    <a href="?do=show-malfunction-details&period=previous-month&malStatus=all&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
                <div class="col-6">
                  <div class="dashboard-card card card-stat bg-danger bg-gradient">
                    <?php $unrep_prev_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                    <div class="card-body">
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('UNFINISHED', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $unrep_prev_month ?>)</h5>
                    </div>
                    <a href="?do=show-malfunction-details&period=previous-month&malStatus=unrepaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
                <div class="col-6">
                  <div class="dashboard-card card card-stat bg-success bg-gradient">
                    <?php $rep_prev_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                    <div class="card-body">
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('FINISHED', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $rep_prev_month ?>)</h5>
                    </div>
                    <a href="?do=show-malfunction-details&period=previous-month&malStatus=repaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
                <div class="col-6">
                  <div class="dashboard-card card card-stat bg-warning bg-gradient">
                    <?php $del_prev_month = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND Date(`created_at`) BETWEEN '{$start_date}' AND '{$end_date}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1"); ?>
                    <div class="card-body">
                      <h5 class="card-title text-capitalize">
                        <?php echo lang('DELAYED', $lang_file) ?>
                      </h5>
                      <h5>(<?php echo $del_prev_month ?>)</h5>
                    </div>
                    <a href="?do=show-malfunction-details&period=previous-month&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
      <!-- total malfunctions -->
      <div class="col-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize">
              <?php echo lang("TOTAL MAL OF THE YEAR", $lang_file) . " {$target_year}" ?>
            </h5>
            <p class="text-muted ">
              <?php echo lang("TOTAL MAL NOTE", $lang_file) ?>
            </p>
            <hr>
          </header>
          <div class="row row-cols-sm-2 g-3">
            <div class="col-6">
              <div class="dashboard-card card card-stat card-primary bg-gradient">
                <?php $total_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "$techCondition2 " . (empty($techCondition2) ? "WHERE YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) : "AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']))) ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('TOTAL', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $total_mal ?>)</h5>
                </div>
                <a href="?do=show-malfunction-details&period=all&malStatus=all&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-6">
              <div class="dashboard-card card card-stat bg-danger bg-gradient">
                <?php $total_unrep_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 0 AND `isAccepted` <> 2) AND YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('UNFINISHED', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $total_unrep_mal ?>)</h5>
                </div>
                <a href="?do=show-malfunction-details&period=all&malStatus=unrepaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-6">
              <div class="dashboard-card card card-stat bg-success bg-gradient">
                <?php $total_rep_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE `mal_status` = 1 AND YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('FINISHED', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $total_rep_mal; ?>)</h5>
                </div>
                <a href="?do=show-malfunction-details&period=all&malStatus=repaired&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
            <div class="col-6">
              <div class="dashboard-card card card-stat bg-warning bg-gradient">
                <?php $total_del_mal = $mal_obj->count_records("`mal_id`", "`malfunctions`", "WHERE (`mal_status` = 2 OR `isAccepted` = 2) AND YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1") ?>
                <div class="card-body">
                  <h5 class="card-title text-capitalize">
                    <?php echo lang('DELAYED', $lang_file) ?>
                  </h5>
                  <h5>(<?php echo $total_del_mal; ?>)</h5>
                </div>
                <a href="?do=show-malfunction-details&period=all&accepted=delayed&year=<?php echo $target_year ?>" class="stretched-link"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($total_mal > 0) { ?>
      <div class="mb-3 row row-cols-sm-1 align-items-center-justify-content-center">
        <!-- total malfunctions -->
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang("MALS RATING OF THE YEAR", $lang_file) . " {$target_year}" ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang("MALS RATING NOTE", $lang_file) ?>
              </p>
              <hr>
            </header>
            <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
              <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 align-items-center justify-content-center g-5">
                <div class="col-12">
                  <?php $rep_rate = round(($total_rep_mal / $total_mal) * 100, 2); ?>
                  <h5 class="card-title text-capitalize text-center">
                    <?php echo lang('FINISHED', $lang_file) ?>
                    <div class="badge bg-success p-2 d-inline-block"></div>
                  </h5>
                  <div class="progress">
                    <?php if ($rep_rate < 15) { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>">
                      </div>
                      <div class="progress-value">
                        <?php echo $rep_rate ?>%
                      </div>
                    <?php } else { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $rep_rate ?>%" aria-valuenow="<?php echo $rep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>">
                        <?php echo $rep_rate ?>%
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-12">
                  <?php $unrep_rate = round(($total_unrep_mal / $total_mal) * 100, 2); ?>
                  <h5 class="card-title text-capitalize text-center">
                    <?php echo lang('UNFINISHED', $lang_file) ?>
                    <div class="badge bg-danger p-2 d-inline-block"></div>
                  </h5>
                  <div class="progress">
                    <?php if ($unrep_rate < 15) { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>">
                      </div>
                      <div class="progress-value">
                        <?php echo $unrep_rate ?>%
                      </div>
                    <?php } else { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $unrep_rate ?>%" aria-valuenow="<?php echo $unrep_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>">
                        <?php echo $unrep_rate ?>%
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-12">
                  <?php $del_rate = round(($total_del_mal / $total_mal) * 100, 2); ?>
                  <h5 class="card-title text-capitalize text-center">
                    <?php echo lang('DELAYED', $lang_file) ?>
                    <div class="badge bg-warning p-2 d-inline-block"></div>
                  </h5>
                  <div class="progress">
                    <?php if ($del_rate < 15) { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>">
                      </div>
                      <div class="progress-value">
                        <?php echo $del_rate ?>%
                      </div>
                    <?php } else { ?>
                      <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $del_rate ?>%" aria-valuenow="<?php echo $del_rate ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_mal ?>">
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

    <?php if (isset($all_mal_today) && $all_mal_today > 0) { ?>
      <div class="mb-3 row">
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('SOME MALS TODAY', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang("SOME MALS NOTE", $lang_file) ?>
              </p>
              <hr>
            </header>
            <?php
            // get malfunctions of today
            $today_mal = $mal_obj->select_specific_column("*", "`malfunctions`", "WHERE Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1 ORDER BY `created_at` DESC LIMIT 5", 'multiple');
            // check if array not empty
            if (!is_null($today_mal)) {
              $index = 0;
            ?>
              <div class="table-responsive-sm">
                <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" data-scroll-y="<?php echo count($today_mal) <= 10 ? 'auto' : 400 ?>" data-last-td=" [-1]" style="width:100%">
                  <thead class="primary text-capitalize">
                    <tr>
                      <th>
                        <?php echo lang('NAME', $lang_file) ?>
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
                    <?php
                    // loop on data
                    foreach ($today_mal as $index => $mal) {
                      $client_name = "";
                      $client_type = "";
                      $tech_name = "";
                      // get client info
                      if ($mal_obj->is_exist("`id`", "`pieces_info`", $mal['client_id'])) {
                        $client_info = $mal_obj->select_specific_column("`full_name`, `is_client`, `address`", "`pieces_info`", "WHERE `id` = " . $mal['client_id']);
                        $client_name = $client_info['full_name'];
                        $client_type = $client_info['is_client'];
                        $client_addr = $client_info['address'];
                      }

                      // client phone
                      $client_phone = $mal_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $mal['client_id']);

                      if ($mal_obj->is_exist("`UserID`", "`users`", $mal['tech_id'])) {
                        $tech_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $mal['tech_id'])['username'];
                      }
                    ?>
                      <tr class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                        <!-- name -->
                        <td>
                          <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
                            <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($mal['client_id']) ?>">
                              <?php echo !empty($client_name) ? wordwrap($client_name, 50, "<br>") : lang('NO DATA') ?>
                            </a>
                          <?php } else { ?>
                            <?php echo !empty($client_name) ? wordwrap($client_name, 50, "<br>") : lang('NO DATA') ?>
                          <?php } ?>
                        </td>
                        <!-- address -->
                        <td class="<?php echo is_null($client_addr) ? 'text-danger fw-bold fs-12' : '' ?>">
                          <?php if (!is_null($client_addr)) { ?>
                            <span>
                              <?php echo wordwrap($client_addr, 50, "<br>"); ?>
                            </span>
                          <?php } else { ?>
                            <span class="text danger">
                              <?php echo lang('NO DATA'); ?>
                            </span>
                          <?php } ?>
                        </td>
                        <!-- phone -->
                        <td class="<?php echo empty($client_phone) ? 'text-danger fw-bold fs-12' : '' ?>">
                          <?php if (!empty($client_phone)) { ?>
                            <span>
                              <?php echo $client_phone; ?>
                            </span>
                          <?php } else { ?>
                            <span class="text danger">
                              <?php echo lang('NO DATA'); ?>
                            </span>
                          <?php } ?>
                        </td>
                        <!-- technical name -->
                        <td>
                          <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($mal['tech_id']) ?>">
                            <?php echo !empty($tech_name) ? $tech_name : lang('NO DATA') ?>
                          </a>
                        </td>
                        <!-- malfunction status -->
                        <td class="text-center">
                          <?php
                          if ($mal['mal_status'] == 0) {
                            $iconStatus = "bi-x-circle-fill text-danger";
                            $titleStatus = lang('UNFINISHED', $lang_file);
                          } elseif ($mal['mal_status'] == 1) {
                            $iconStatus = "bi-check-circle-fill text-success";
                            $titleStatus = lang('FINISHED', $lang_file);
                          } elseif ($mal['mal_status'] == 2) {
                            $iconStatus = "bi-exclamation-circle-fill text-warning";
                            $titleStatus = lang('DELAYED', $lang_file);
                          } else {
                            $iconStatus = "bi-dash-circle-fill text-info";
                            $titleStatus = lang('NO STATUS', $lang_file);
                          }
                          ?>
                          <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                        </td>
                        <!-- malfunction media status -->
                        <td class="text-center">
                          <?php
                          $have_media = $mal_obj->count_records("`id`", "`malfunctions_media`", "WHERE `mal_id` = " . $mal['mal_id']);
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
                        <!-- control buttons -->
                        <td>
                          <div class="hstack gap-1">
                            <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
                              <a href="?do=edit-malfunction-info&malid=<?php echo base64_encode($mal['mal_id']) ?>" target="" class="btn btn-outline-primary me-1 fs-12">
                                <i class="bi bi-eye"></i>
                                <?php echo lang('SHOW DETAILS') ?>
                              </a>
                            <?php } ?>
                            <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                              <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo base64_encode($mal['mal_id']) ?>" onclick="put_mal_data_into_modal(this, true)">
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
            <?php } else { ?>
              <h5 class="h5 text-danger text-capitalize ">
                <?php echo lang('NO DATA') ?>
              </h5>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php $latest_mal = $mal_obj->select_specific_column("*", "`malfunctions`", "WHERE YEAR(`created_at`) = '{$target_year}' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `deleted_at` IS NULL $techCondition1 ORDER BY `created_at` DESC, `created_at` DESC LIMIT 5", 'multiple'); ?>
    <?php if (!is_null($latest_mal)) { ?>
      <div class="mb-3 row">
        <div class="col-12">
          <div class="section-block">
            <header class="section-header">
              <h5 class="h5 text-capitalize">
                <?php echo lang('LATEST MALS', $lang_file) ?>
              </h5>
              <p class="text-muted ">
                <?php echo lang("LATEST MALS NOTE", $lang_file) ?>
              </p>
              <hr>
            </header>
            <div class="table-responsive-sm">
              <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" data-scroll-y="<?php echo count($latest_mal) <= 10 ? 'auto' : 400 ?>" data-last-td="[-1]" style="width:100%" id="latest-mal">
                <thead class="primary text-capitalize">
                  <tr>
                    <th>
                      <?php echo lang('NAME', $lang_file) ?>
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
                  <?php
                  // loop on data
                  foreach ($latest_mal as $index => $mal) {
                    $client_name = "";
                    $client_type = "";
                    $tech_name = "";
                    // get client info
                    if ($mal_obj->is_exist("`id`", "`pieces_info`", $mal['client_id'])) {
                      $client_info = $mal_obj->select_specific_column("`full_name`, `is_client`, `address`", "`pieces_info`", "WHERE `id` = " . $mal['client_id']);
                      $client_name = $client_info['full_name'];
                      $client_type = $client_info['is_client'];
                      $client_addr = $client_info['address'];
                    }
                    // client phone
                    $client_phone = $mal_obj->select_specific_column("`phone`", "`pieces_phones`", "WHERE `id` = " . $mal['client_id']);

                    if ($mal_obj->is_exist("`UserID`", "`users`", $mal['tech_id'])) {
                      $tech_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $mal['tech_id'])['username'];
                    }
                  ?>
                    <tr class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <!-- name -->
                      <td>
                        <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
                          <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($mal['client_id']) ?>">
                            <?php echo !empty($client_name) ? wordwrap($client_name, 50, "<br>") : lang('NO DATA') ?>
                          </a>
                        <?php } else { ?>
                          <?php echo !empty($client_name) ? wordwrap($client_name, 50, "<br>") : lang('NO DATA') ?>
                        <?php } ?>
                      </td>
                      <!-- address -->
                      <td class="<?php echo is_null($client_addr) ? 'text-danger fw-bold fs-12' : '' ?>">
                        <?php if (!is_null($client_addr)) { ?>
                          <span>
                            <?php echo wordwrap($client_addr, 50, "<br>"); ?>
                          </span>
                        <?php } else { ?>
                          <span class="text danger">
                            <?php echo lang('NO DATA'); ?>
                          </span>
                        <?php } ?>
                      </td>
                      <!-- phone -->
                      <td class="<?php echo is_null($client_phone) && empty($client_phone) ? 'text-danger fw-bold fs-12' : '' ?>">
                        <?php if (!is_null($client_phone) && !empty($client_phone)) { ?>
                          <span>
                            <?php echo $client_phone['phone']; ?>
                          </span>
                        <?php } else { ?>
                          <span class="text danger">
                            <?php echo lang('NO DATA'); ?>
                          </span>
                        <?php } ?>
                      </td>
                      <!-- technical name -->
                      <td>
                        <?php if (!empty($tech_name)) { ?>
                          <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($mal['tech_id']) ?>">
                            <?php echo $tech_name ?>
                          </a>
                        <?php } else { ?>
                          <span class="text-danger">
                            <?php echo lang('NO DATA'); ?>
                          </span>
                        <?php } ?>
                      </td>
                      <!-- malfunction status -->
                      <td class="text-center">
                        <?php
                        if ($mal['mal_status'] == 0) {
                          $iconStatus = "bi-x-circle-fill text-danger";
                          $titleStatus = lang('UNFINISHED', $lang_file);
                        } elseif ($mal['mal_status'] == 1) {
                          $iconStatus = "bi-check-circle-fill text-success";
                          $titleStatus = lang('FINISHED', $lang_file);
                        } elseif ($mal['mal_status'] == 2) {
                          $iconStatus = "bi-exclamation-circle-fill text-warning";
                          $titleStatus = lang('DELAYED', $lang_file);
                        } else {
                          $iconStatus = "bi-dash-circle-fill text-info";
                          $titleStatus = lang('NO STATUS', $lang_file);
                        }
                        ?>
                        <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
                      </td>
                      <!-- malfunction media status -->
                      <td class="text-center">
                        <?php
                        $have_media = $mal_obj->count_records("`id`", "`malfunctions_media`", "WHERE `mal_id` = " . $mal['mal_id']);
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
                      <!-- control buttons -->
                      <td>
                        <div class="hstack gap-1">
                          <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
                            <a href="?do=edit-malfunction-info&malid=<?php echo base64_encode($mal['mal_id']) ?>" target="" class="btn btn-outline-primary me-1 fs-12">
                              <i class="bi bi-eye"></i>
                              <?php echo lang('SHOW DETAILS') ?>
                            </a>
                          <?php } ?>
                          <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                            <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo base64_encode($mal['mal_id']) ?>" onclick="put_mal_data_into_modal(this, true)">
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
      </div>
    <?php } ?>
    <!-- end new design -->
  </div>
  <!-- end stats -->
</div>
<!-- end home stats container -->
<?php
if ($_SESSION['sys']['mal_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
  // delete malfunction modal
  include_once 'delete-malfunction-modal.php';
}
?>