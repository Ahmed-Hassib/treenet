<?php
// check date
$date = isset($_GET['date']) && !empty($_GET['date']) ? trim($_GET['date'], " ") : null;
// check period start
$period_start = isset($_GET['period-start']) && !empty($_GET['period-start']) ? trim($_GET['period-start'], " ") : null;
// check period end
$period_end = isset($_GET['period-end']) && !empty($_GET['period-end']) ? trim($_GET['period-end'], " ") : Date('Y-m-d');
// create new object of Malfunction class
$mal_obj = new Malfunction();
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
        <form action="" method="get" name="malfunction-year-form">
          <input type="hidden" name="do" value="malfunctions">
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
        <form action="" method="get" name="malfunction-year-form">
          <input type="hidden" name="do" value="malfunctions">
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
                $deleted_mals = $mal_obj->get_malfunctions("`company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND DATE(`deleted_at`) = '$date'");
              } elseif ($period_start != null && $period_end != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A PERIOD') . "  " . lang('FROM') . " {$period_start} " . lang('TO') . " {$period_end}";
                // get all deleted coms of specific date
                $deleted_mals = $mal_obj->get_malfunctions("`company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND DATE(`deleted_at`) BETWEEN '$period_start' AND '$period_end'");
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
          <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo !isset($deleted_mals) || count($deleted_mals) <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="[-1]" style="width:100%">
            <thead class="primary text-capitalize">
              <tr>
                <th style="width: 20px">#</th>
                <th>
                  <?php echo lang('ADMIN NAME', 'malfunctions') ?>
                </th>
                <th>
                  <?php echo lang('TECH NAME', 'malfunctions') ?>
                </th>
                <th>
                  <?php echo lang('NAME', 'malfunctions') ?>
                </th>
                <th>
                  <?php echo lang('MAL DESC', 'malfunctions') ?>
                </th>
                <th>
                  <?php echo lang('TECH COMMENT', 'malfunctions') ?>
                </th>
                <th>
                  <?php echo lang('ADDED DATE') ?>
                </th>
                <th>
                  <?php echo lang('STATUS', 'malfunctions') ?>
                </th>
                <th>
                  <?php echo lang('CONTROL') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($deleted_mals)) { ?>
                <?php foreach ($deleted_mals as $key => $mal) { ?>
                  <!-- row index -->
                  <td>
                    <?php echo ($key + 1) ?>
                  </td>
                  <!-- admin username -->
                  <td>
                    <?php
                    // check if exist
                    $is_exist_admin = $mal_obj->is_exist("`UserID`", "`users`", $mal['mng_id']);
                    // if exist
                    if ($is_exist_admin) {
                      $admin_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $mal['mng_id'])['username'];
                    ?>
                      <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($mal['mng_id']); ?>">
                        <?php echo $admin_name ?>
                      </a>
                    <?php } else { ?>
                      <span class="text-danger">
                        <?php echo lang('WAS DELETED', 'malfunctions') ?>
                      </span>
                    <?php } ?>
                  </td>
                  <!-- technical username -->
                  <td>
                    <?php
                    // check if exist
                    $is_exist_tech = $mal_obj->is_exist("`UserID`", "`users`", $mal['tech_id']);
                    // if exist
                    if ($is_exist_tech) {
                      $tech_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $mal['tech_id'])['username']; ?>
                      <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($mal['tech_id']); ?>">
                        <?php echo $tech_name ?>
                      </a>
                    <?php } else { ?>
                      <span class="text-danger">
                        <?php echo lang('WAS DELETED', 'malfunctions') ?>
                      </span>
                    <?php } ?>
                  </td>
                  <!-- piece/client name -->
                  <td>
                    <?php
                    // check if exist
                    $is_exist_device = $mal_obj->is_exist("`id`", "`pieces_info`", $mal['client_id']);
                    // if exist
                    if ($is_exist_device) {
                      // get info
                      $info = $mal_obj->select_specific_column("`full_name`, `is_client`", "`pieces_info`", "WHERE `id` = " . $mal['client_id'] . " LIMIT 1");
                      // get name
                      $name = $info['full_name'];
                      // get type
                      $is_client = $info['is_client'];
                      // prepare url
                      if ($is_client == 1) {
                        $url = $nav_up_level . "clients/index.php?do=edit-client&client-id=" . base64_encode($mal['client_id']);
                      } else {
                        $url = "?do=edit-piece&piece-id=" . base64_encode($mal['client_id']);
                      }
                    ?>
                      <a href="<?php echo $url ?>">
                        <?php echo wordwrap($name, 50, "<br>") ?>
                      </a>
                    <?php } else { ?>
                      <span class="text-danger fs-12">
                        <?php echo lang('WAS DELETED', 'malfunctions') ?>
                      </span>
                    <?php } ?>
                  </td>
                  <!-- malfunction description -->
                  <td>
                    <?php
                    if (strlen($mal['descreption']) > 0 && !empty($mal['descreption'])) {
                      echo wordwrap($mal['descreption'], 50, "<br>");
                    } else { ?>
                      <span class="text-danger fs-12">
                        <?php echo lang('NO DATA') ?>
                      </span>
                    <?php } ?>
                  </td>
                  <!-- technical man comment -->
                  <td>
                    <?php if (!empty($mal['tech_comment'])) { ?>
                      <?php echo wordwrap($mal['tech_comment'], 50, "<br>"); ?>
                    <?php } else { ?>
                      <span class="text-danger fs-12">
                        <?php echo lang('NOT ASSIGNED'); ?>
                      </span>
                    <?php } ?>
                  </td>
                  <!-- added date -->
                  <td>
                    <?php echo wordwrap(date_format(date_create($mal['created_at']), "h:i:sa d/m/Y"), 11, "<br>") ?>
                  </td>
                  <!-- malfunction status -->
                  <td>
                    <?php
                    if ($mal['mal_status'] == 0) {
                      $iconStatus = "bi-x-circle-fill text-danger";
                      $titleStatus = lang('UNFINISHED', 'malfunctions');
                    } elseif ($mal['mal_status'] == 1) {
                      $iconStatus = "bi-check-circle-fill text-success";
                      $titleStatus = lang('FINISHED', 'malfunctions');
                    } elseif ($mal['mal_status'] == 2) {
                      $iconStatus = "bi-exclamation-circle-fill text-warning";
                      $titleStatus = lang('DELAYED', 'malfunctions');
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
                    $have_media = $mal_obj->count_records("`id`", "`malfunctions_media`", "WHERE `mal_id` = " . $mal['mal_id']);
                    if ($have_media > 0) {
                      $icon = "bi-check-circle-fill text-success";
                      $title = lang('HAVE MEDIA', 'malfunctions');
                    } else {
                      $icon = "bi-x-circle-fill text-danger";
                      $title = lang('NO MEDIA', 'malfunctions');
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
                        <a class="btn btn-success text-capitalize fs-12 " href="?do=malfunctions&action=restore&id=<?php echo base64_encode($mal['mal_id']); ?>">
                          <i class="bi bi-arrow-clockwise"></i>
                          <?php echo lang('RESTORE') ?>
                        </a>
                      <?php } ?>
                      <?php if ($_SESSION['sys']['user_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                        <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteMalModal" id="delete-malfunction-<?php echo ($index + 1) ?>" data-malfunction-id="<?php echo base64_encode($mal['mal_id']) ?>" onclick="confirm_delete_malfunction(this, true)" style="width: 80px"><i class="bi bi-trash"></i>
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


<?php if ($_SESSION['sys']['mal_delete'] == 1 && isset($deleted_mals) && $deleted_mals != null) { ?>
  <?php include_once "delete-modal.php"; ?>

  <script>
    let deleted_malfunction_url_in_modal = document.querySelector('#deleted-malfunction-url');

    function confirm_delete_malfunction(btn, will_back = null) {
      // get malfunction info
      let malfunction_id = btn.dataset.malfunctionId;
      // prepare url
      let url = `../malfunctions/index.php?do=delete&malid=${malfunction_id}&back=true`;
      // put it into the modal
      deleted_malfunction_url_in_modal.href = url;
    }
  </script>
<?php } ?>