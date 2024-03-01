<?php
// check date
$date = isset($_POST['date']) && !empty($_POST['date']) ? trim($_POST['date'], " ") : null;
// check period start
$period_start = isset($_POST['period-start']) && !empty($_POST['period-start']) ? trim($_POST['period-start'], " ") : null;
// check period end
$period_end = isset($_POST['period-end']) && !empty($_POST['period-end']) ? trim($_POST['period-end'], " ") : Date('Y-m-d');
// create new object of User class
$user_obj = new User();
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
        <form action="?do=deletes" method="post" name="employees-year-form">
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
        <form action="?do=deletes" method="post" name="employees-year-form">
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
                // get all deleted employees of specific date
                $deleted_employees = $user_obj->get_all_users(base64_decode($_SESSION['sys']['company_id']), "AND DATE(`deleted_at`) = '{$date}'");
              } elseif ($period_start != null && $period_end != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A PERIOD') . "  " . lang('FROM') . " {$period_start} " . lang('TO') . " {$period_end}";
                // get all deleted employees of specific date
                $deleted_employees = $user_obj->get_all_users(base64_decode($_SESSION['sys']['company_id']), "AND DATE(`deleted_at`) BETWEEN '{$period_start}' AND '{$period_end}'");
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
          <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo !isset($deleted_employees) || count($deleted_employees) <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="[-1]" style="width:100%">
            <thead class="primary text-capitalize">
              <th>#</th>
              <th><?php echo lang('fullname', 'employees') ?></th>
              <th><?php echo lang('gender', 'employees') ?></th>
              <th><?php echo lang('address', 'employees') ?></th>
              <th><?php echo lang('phone', 'employees') ?></th>
              <th><?php echo lang('job title', 'employees') ?></th>
              <th><?php echo lang('control') ?></th>
            </thead>
            <tbody>
              <?php if (isset($deleted_employees)) { ?>
                <?php foreach ($deleted_employees as $key => $employee) { ?>
                  <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td>
                      <?php echo $employee['fullname'] ?>
                      <?php if ($employee['trust_status'] == 1) { ?>
                        <i class="bi bi-patch-check-fill text-primary"></i>
                      <?php } ?>
                    </td>
                    <td><?php echo $employee['gender'] == 0 ? lang('male', 'employees') : lang('female', 'employees') ?></td>
                    <td>
                      <span class="<?php echo !empty($employee['address']) ? 'text-black' : 'text-danger' ?>">
                        <?php echo !empty($employee['address']) ? $employee['address'] : lang('NO DATA') ?>
                      </span>
                    </td>
                    <td>
                      <span class="<?php echo !empty($employee['phone']) ? 'text-black' : 'text-danger' ?>">
                        <?php echo !empty($employee['phone']) ? $employee['phone'] : lang('NO DATA') ?>
                      </span>
                    </td>
                    <td>
                      <?php
                      if ($employee['job_title_id'] != 0) {
                        $job_title = $user_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $employee['job_title_id'])[0]['job_title_name'];
                        echo lang($job_title, 'employees');
                      } else {
                        echo lang('NOT JOB TITLE', 'employees');
                      }
                      ?>
                    </td>
                    <td>
                      <div class="hstack gap-1">
                        <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
                          <a class="btn btn-success text-capitalize fs-12 " href="?do=restore&id=<?php echo base64_encode($employee['UserID']); ?>">
                            <i class="bi bi-arrow-clockwise"></i>
                            <?php echo lang('RESTORE') ?>
                          </a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['user_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal" id="delete-employee-<?php echo ($index + 1) ?>" data-employee-id="<?php echo base64_encode($employee['UserID']) ?>" data-employee-name="<?php echo $employee['fullname'] ?>" onclick="confirm_delete_employee(this, true, true)" style="width: 80px"><i class="bi bi-trash"></i>
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


<?php if ($_SESSION['sys']['user_delete'] == 1 && isset($deleted_employees) && $deleted_employees != null) { ?>
  <?php include_once "delete-modal.php"; ?>
<?php } ?>