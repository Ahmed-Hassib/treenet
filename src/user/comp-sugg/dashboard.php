<?php $comp_sugg_obj = new CompSugg(); ?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 hstack gap-3">
    <a href="?do=add" class="btn btn-outline-primary py-1">
      <i class="bi bi-plus"></i>
      <?php echo lang('add', $lang_file) ?>
    </a>
  </div>
  <div class="dashboard-content">
    <!-- start new design -->
    <div class="dashboard-card card card-stat bg-gradient">
      <?php $complaints = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 'comp' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `added_by` = " . base64_decode($_SESSION['sys']['UserID'])); ?>
      <div class="card-body">
        <h5 class="h5 card-title"><?php echo ucfirst(lang('the comps', $lang_file)) ?></h5>
        <div class="nums">
          <span><?php echo lang('total') ?> </span>
          <span class="num" data-goal="0"><?php echo $complaints ?></span>
        </div>
      </div>
      <a href="?do=list&type=comp" class="stretched-link"></a>
    </div>
    <div class="dashboard-card card card-stat bg-gradient">
      <?php $suggestions = $comp_sugg_obj->count_records("`id`", "`comp_sugg`", "WHERE `type` = 'sugg' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `added_by` = " . base64_decode($_SESSION['sys']['UserID'])); ?>
      <div class="card-body">
        <h5 class="h5 card-title text-uppercase"><?php echo lang('the suggs', $lang_file) ?></h5>
        <div class="nums">
          <span><?php echo lang('total', $lang_file) ?> </span>
          <span class="num" data-goal="0"><?php echo $suggestions ?></span>
        </div>
      </div>
      <a href="?do=list&type=sugg" class="stretched-link text-capitalize"></a>
    </div>
  </div>
</div>