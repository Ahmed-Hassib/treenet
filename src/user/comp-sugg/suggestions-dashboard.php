<?php 
// check if CompSugg class object is created
if (!isset($comp_sugg_obj)) {
  $comp_sugg_obj = new CompSugg();
}
// get all suggestions
$all_suggestions = $comp_sugg_obj->get_all_suggestions($_SESSION['sys']['UserID'], $_SESSION['sys']['company_id']);
?>
<div class="container mb-0" dir="<?php echo $page_dir ?>">
  <div class="mb-3">
    <a href="?do=add-comp-sugg&type=1" class="btn btn-outline-primary py-1 fs-12 shadow-sm">
      <i class="bi bi-plus"></i>
      <?php echo lang('ADD NEW SUGGESTION', @$_SESSION['sys']['lang']) ?>
    </a>
  </div>
</div>
<!-- start new design -->
<div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start" dir="<?php echo $page_dir ?>">
  <div class="stats">
    <div class="col-12">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize"><?php echo lang('TOTAL SUGGESTIONS', @$_SESSION['sys']['lang']) ?></h5>
          <hr>
        </header>
        <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-4 gx-3 gy-5">
          <div class="col-6">
            <div class="card card-stat card card-stat shadow-sm border border-1">
              <div class="card-body">
                <h5 class="card-title text-capitalize"><?php echo lang('TOTAL', @$_SESSION['sys']['lang']) ?></h5>
                <span class="bg-info icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
                  <span class="nums">
                    <?php $all_suggestions = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `company_id` = " . $_SESSION['sys']['company_id'] . " AND `added_by` = " . $_SESSION['sys']['UserID']); ?>
                    <span class="num" data-goal="<?php echo $all_suggestions; ?>">0</span>
                  </span>
                </span>
                <a href="?do=show-comp-sugg&type=1&period=all" class="stretched-link"></a>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card card-stat card card-stat shadow-sm border border-1">
              <div class="card-body">
                <h5 class="card-title text-capitalize"><?php echo lang('TODAY', @$_SESSION['sys']['lang']) ?></h5>
                <span class="bg-info icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
                  <span class="nums">
                    <?php $today_suggestions = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `company_id` = " . $_SESSION['sys']['company_id'] . " AND `added_by` = " . $_SESSION['sys']['UserID']. " AND `added_date` = '".get_date_now()."'"); ?>
                    <span class="num" data-goal="<?php echo $today_suggestions; ?>">0</span>
                  </span>
                </span>
                <a href="?do=show-comp-sugg&type=1&period=today" class="stretched-link"></a>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card card-stat card card-stat shadow-sm border border-1">
              <div class="card-body">
                <h5 class="card-title text-capitalize"><?php echo lang('OF THIS MONTH', @$_SESSION['sys']['lang']) ?></h5>
                <span class="bg-info icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
                  <span class="nums">
                    <?php $start_date = Date('Y-m-1'); ?>
                    <?php $end_date   = Date('Y-m-30'); ?>
                    <?php $month_suggestions = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 1 AND `company_id` = " . $_SESSION['sys']['company_id'] . " AND `added_by` = " . $_SESSION['sys']['UserID']. " AND `added_date` BETWEEN '$start_date' AND '$end_date' "); ?>
                    <span class="num" data-goal="<?php echo $month_suggestions ?>">0</span>
                  </span>
                </span>
                <a href="?do=show-comp-sugg&type=1&period=month" class="stretched-link"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
