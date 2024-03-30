<?php $db_obj = new Database("localhost", "jsl_db") ?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="dashboard-content">
      <!-- system status -->
      <?php
      // fetch data from database
      $system_status = $db_obj->select_specific_column("*", "`settings`", "LIMIT 1");
      // get value of seystem status
      $system_status = !empty($system_status) && count($system_status) > 0 ? $system_status[0]['is_developing'] : null;
      ?>
      <div class="dashboard-card card card-white bg-gradient">
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "patch-question.svg" ?>" loading="lazy" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('SYSTEM STATUS'), 25, "<br>") ?>
          </h5>
          <form class="mt-5" action="?do=system-status" method="post">
            <div class="form-check form-switch <?php echo $page_dir == 'rtl' ? 'form-check-reverse' : '' ?>" style="width: fit-content;margin: auto;">
              <label class="form-check-label" for="system_status"><?php echo $system_status == '0' ? lang('ACTIVE', $lang_file) : lang('UNDER DEVELOPING') ?></label>
              <input class="form-check-input" style="width: 2rem; height: 1rem; cursor: pointer;" type="checkbox" name="system_status_switch" role="switch" id="system_status_switch" <?php echo $system_status == '0' ? 'checked' : '' ?> onclick="document.querySelector('#system_status').value = check_switch_value(this); this.form.submit()">
              <input type="hidden" id="system_status" name="system_status" value="<?php echo $system_status ?>">
              <script>
                function check_switch_value(switch_btn) {
                  return switch_btn.checked ? 0 : 1;
                }
              </script>
            </div>
          </form>
        </div>
      </div>

      <!-- number of companies -->
      <div class="dashboard-card card card-white bg-gradient">
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "building-exclamation.svg" ?>" loading="lazy" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('#REGISTERED COMPANIES', $lang_file), 25, "<br>") ?>
          </h5>
          <?php $num_of_companies = $db_obj->count_records("*", "`companies`", "WHERE `company_id` <> 1"); ?>
          <h5 class="card-text">
            <span class="nums">
              (<span class="num" data-goal="<?php echo $num_of_companies; ?>">0</span>)
            </span>
          </h5>
        </div>
      </div>

      <div class="dashboard-card card card-white bg-gradient">
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "complaints_2.png" ?>" style="scale: 1.5" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('THE COMPS & SUGGS', 'comp_sugg'), 20, "<br>") ?>
          </h5>
        </div>
        <a href="<?php echo $nav_up_level ?>comp-sugg/index.php" class="stretched-link text-capitalize"></a>
      </div>

    </div>
  </div>
  <!-- end stats -->
</div>
<!-- end dashboard page -->