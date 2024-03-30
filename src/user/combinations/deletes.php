<?php
// check date
$date = isset($_POST['date']) && !empty($_POST['date']) ? trim($_POST['date'], " ") : null;
// check period start
$period_start = isset($_POST['period-start']) && !empty($_POST['period-start']) ? trim($_POST['period-start'], " ") : null;
// check period end
$period_end = isset($_POST['period-end']) && !empty($_POST['period-end']) ? trim($_POST['period-end'], " ") : Date('Y-m-d');
// create new object of Combination class
$comb_obj = new Combination();
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 row g-3">
    <div class="col-sm-12 col-lg-4">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('SELECT DAY'); ?>
          </h5>
          <hr>
        </header>
        <form action="?do=deletes" method="post" name="combination-year-form">
          <div class="row g-3 align-items-baseline">
            <div class="col-7">
              <div class="form-floating">
                <input type="date" class="form-control" name="date" id="date" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $date ?>" required>
                <label for="date">
                  <?php echo lang('THE DATE') ?>
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
    <div class="col-sm-12 col-lg-8">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('SELECT PERIOD'); ?>
          </h5>
          <hr>
        </header>
        <form action="?do=deletes" method="post" name="combination-year-form">
          <div class="row g-3 align-items-baseline">
            <div class="col-sm-6 col-md-4">
              <div class="form-floating">
                <input type="date" class="form-control" name="period-start" id="period-start" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $period_start ?>" required>
                <label for="date">
                  <?php echo lang('PERIOD START') ?>
                </label>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="form-floating">
                <input type="date" class="form-control" name="period-end" id="period-end" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $period_end ?>" required>
                <label for="date">
                  <?php echo lang('PERIOD END') ?>
                </label>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
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

  <?php if ($date != null || ($period_start != null && $period_end != null)) { ?>
    <div class="row g-3">
      <div class="col-sm-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize">
              <?php
              if ($date != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A DAY') . " {$date}";
                // get all deleted coms of specific date
                $deleted_combs = $comb_obj->get_combinations("`company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND DATE(`deleted_at`) = '$date'");
              } elseif ($period_start != null && $period_end != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A PERIOD') . "  " . lang('FROM') . " {$period_start} " . lang('TO') . " {$period_end}";
                // get all deleted coms of specific date
                $deleted_combs = $comb_obj->get_combinations("`company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND DATE(`deleted_at`) BETWEEN '$period_start' AND '$period_end'");
              } else {
                $title = lang('NOT ASSIGNED');
              }
              // display title
              echo $title;
              ?>
            </h5>
            <hr>
          </header>

          <!-- strst clients table -->
          <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo !isset($deleted_combs) || count($deleted_combs) <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="[-1]" style="width:100%">
            <thead class="primary text-capitalize">
              <tr>
                <th style="width: 20px">#</th>
                <th>
                  <?php echo lang('ADMIN NAME', 'combinations') ?>
                </th>
                <th>
                  <?php echo lang('TECH NAME', 'combinations') ?>
                </th>
                <th>
                  <?php echo lang('BENEFICIARY NAME', 'combinations') ?>
                </th>
                <th>
                  <?php echo lang('ADDR', 'combinations') ?>
                </th>
                <th>
                  <?php echo lang('PHONE', 'combinations') ?>
                </th>
                <th>
                  <?php echo lang('TECH COMMENT', 'combinations') ?>
                </th>
                <th>
                  <?php echo lang('ADDED DATE') ?>
                </th>
                <th>
                  <?php echo lang('STATUS', 'combinations') ?>
                </th>
                <th>
                  <?php echo lang('CONTROL') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($deleted_combs)) { ?>
                <?php foreach ($deleted_combs as $key => $comb) { ?>
                  <tr>
                    <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php echo ($key + 1) ?>
                    </td>
                    <!-- admin username -->
                    <td>
                      <?php
                      // check if exist
                      $is_exist_admin = $comb_obj->is_exist("`UserID`", "`users`", $comb['addedBy']);
                      // if exist
                      if ($is_exist_admin) {
                        $admin_name = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $comb['addedBy'])[0]['username'];
                      ?>
                        <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($comb['addedBy']); ?>">
                          <?php echo $admin_name ?>
                        </a>
                      <?php } else { ?>
                        <span class="text-danger">
                          <?php echo lang('WAS DELETED', 'combinations') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- technical username -->
                    <td>
                      <?php
                      // check if exist
                      $is_exist_tech = $comb_obj->is_exist("`UserID`", "`users`", $comb['UserID']);
                      // if exist
                      if ($is_exist_tech) {
                        $tech_name = $comb_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $comb['UserID'])[0]['username']; ?>
                        <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($comb['UserID']); ?>">
                          <?php echo $tech_name ?>
                        </a>
                      <?php } else { ?>
                        <span class="text-danger">
                          <?php echo lang('WAS DELETED', 'combinations') ?>
                        </span>
                      <?php } ?>
                    </td>

                    <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php echo wordwrap($comb['client_name'], 50, "<br>") ?>
                    </td>
                    <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php if (!empty($comb['address'])) { ?>
                        <span>
                          <?php echo wordwrap($comb['address'], 50, "<br>") ?>
                        </span>
                      <?php } else { ?>
                        <span class="text-danger">
                          <?php echo lang('NO DATA') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <?php if (!empty($comb['phone'])) { ?>
                        <span>
                          <?php echo $comb['phone'] ?>
                        </span>
                      <?php } else { ?>
                        <span class="text-danger">
                          <?php echo lang('NO DATA') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <td class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?> <?php echo empty($comb['tech_comment']) ? 'text-danger ' : '' ?>">
                      <?php if (!empty($comb['tech_comment'])) { ?>
                        <span>
                          <?php echo wordwrap($comb['tech_comment'], 50, "<br>") ?>
                        </span>
                      <?php } else { ?>
                        <span class="text-danger">
                          <?php echo lang('NO DATA') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- added date -->
                    <td>
                      <?php echo date_format(date_create($comb['created_at']), "h:i:sa d/m/Y") ?>
                    </td>
                    <td>
                      <?php
                      if ($comb['isFinished'] == 0) {
                        $icon = "bi-x-circle-fill text-danger";
                        $titleStatus = lang('UNFINISHED', 'combinations');
                      } elseif ($comb['isFinished'] == 1) {
                        $icon = "bi-check-circle-fill text-success";
                        $titleStatus = lang('FINISHED', 'combinations');
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
                      $have_media = $comb_obj->count_records("`id`", "`combinations_media`", "WHERE `comb_id` = " . $comb['comb_id']);
                      if ($have_media > 0) {
                        $icon = "bi-check-circle-fill text-success";
                        $title = lang('HAVE MEDIA', 'combinations');
                      } else {
                        $icon = "bi-x-circle-fill text-danger";
                        $title = lang('NO MEDIA', 'combinations');
                      }
                      ?>
                      <span>
                        <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
                        <span><?php echo $title ?></span>
                      </span>
                    </td>
                    <td>
                      <div class="hstack gap-1">
                        <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
                          <a class="btn btn-success text-capitalize fs-12 " href="?do=restore&id=<?php echo base64_encode($comb['comb_id']); ?>">
                            <i class="bi bi-arrow-clockwise"></i>
                            <?php echo lang('RESTORE') ?>
                          </a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['user_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteCombModal" id="delete-combination-<?php echo ($index + 1) ?>" data-combination-id="<?php echo base64_encode($comb['comb_id']) ?>" onclick="confirm_delete_combination(this, true, true)" style="width: 80px"><i class="bi bi-trash"></i>
                            <?php echo lang('PERMANENT DELETE') ?>
                          </button>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>
</div>


<?php if ($_SESSION['sys']['comb_delete'] == 1 && isset($deleted_combs) && $deleted_combs != null) { ?>
  <?php include_once "delete-modal.php"; ?>
<?php } ?>