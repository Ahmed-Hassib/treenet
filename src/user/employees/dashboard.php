<?php
$user_obj = new User();
// check system theme
if ($_SESSION['sys']['system_theme'] == 2) {
  $card_class = 'card-effect';
  $card_position = @$_SESSION['sys']['lang'] == "ar" ? "card-effect-right" : "card-effect-left";
}
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- add new user page -->
  <?php if ($_SESSION['sys']['user_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
    <!-- first row -->
    <div class="mb-3">
      <a href="?do=add-new-user" class="btn btn-outline-primary py-1 fs-12">
        <i class="bi bi-person-plus"></i>
        <?php echo lang('ADD NEW', $lang_file) ?>
      </a>
    </div>
  <?php } ?>
  <!-- second row -->
  <div class="mb-3">
    <?php
    // call get_all_users function
    $users_data = $user_obj->get_all_users(base64_decode($_SESSION['sys']['company_id']));

    // check if empty data
    if (empty($users_data) || count($users_data) == 0) { ?>
      <h5 class='h5 text-center text-danger '>
        <?php echo lang('NO EMPLOYEES', $lang_file) ?>
      </h5>
    <?php } else { ?>
      <!-- display all employees -->
      <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-4 g-4 align-items-stretch justify-content-start">
        <?php foreach ($users_data as $index => $user) { ?>
          <div class="col-12">
            <div class="card card-fw <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?>">
              <div class="edit-icon">
                <a href="?do=edit-user-info&userid=<?php echo base64_encode($user['UserID']) ?>">
                  <i class="bi bi-pencil-square"></i>
                </a>
              </div>
              <!-- employee image -->
              <?php $profile_img_name = empty($user['profile_img']) || !file_exists($uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $user['profile_img']) ? "male-avatar.svg" : base64_decode($_SESSION['sys']['company_id']) . "/" . $user['profile_img']; ?>
              <?php $profile_img_path = $uploads . "employees-img/" . $profile_img_name; ?>
              <img loading="lazy" src="<?php echo $profile_img_path ?>" class="card-img-top shadow" alt="profile image">
              <!-- employee details -->
              <div class="card-body">
                <!-- vstack for employee info -->
                <div class="vstack gap-1">
                  <!-- card title -->
                  <h5 class="mb-0 card-title">
                    <!-- username -->
                    <?php echo $user['fullname'] ?>
                    <!-- trusted mark -->
                    <?php if ($user['trust_status'] == 1) { ?>
                      <i class="bi bi-patch-check-fill text-primary"></i>
                    <?php } ?>

                    <?php if (date_format(date_create($user['joined_at']), 'Y-m-d') == get_date_now()) { ?>
                      <span class="badge bg-danger">
                        <?php echo lang('NEW') ?>
                      </span>
                    <?php } ?>
                  </h5>
                  <!-- job title -->
                  <p class="card-text text-secondary">
                    <?php
                    if ($user['job_title_id'] != 0) {
                      $job_title = $user_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $user['job_title_id'])[0]['job_title_name'];
                      echo lang($job_title, $lang_file);
                    } else {
                      echo lang('NOT JOB TITLE', $lang_file);
                    }
                    ?>
                  </p>
                  <!-- horizontal rule -->
                  <hr>
                </div>
                <!-- vstack for some statistics -->
                <div class="vstack gap-1 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'text-end' : 'text-start' ?>">
                  <p class="mb-0 card-text">
                    <i class="bi bi-whatsapp"></i>
                    <span class="<?php echo !empty($user['phone']) ? 'text-black' : 'text-secondary' ?>">
                      <?php echo !empty($user['phone']) ? $user['phone'] : lang('NO DATA') ?>
                    </span>
                  </p>
                  <p class="mb-0 card-text text-black"></p>
                  <!-- horizontal rule -->
                  <hr>
                </div>
                <!-- hstack for buttons -->
                <div class="row g-1 align-items-center">
                  <div class="col-sm-12 col-md-12 col-lg-6">
                    <p class="col-12 card-text text-secondary mb-0 fs-12 fs-10-sm">
                      <?php echo lang('JOINED') ?><br>
                      <?php echo date_format(date_create($user['joined_at']), 'h:i:sa d/m/Y') ?>
                    </p>
                  </div>
                  <?php if (!is_null($user['updated_at'])) { ?>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                      <p class="col-12 card-text text-secondary mb-0 fs-12 fs-10-sm">
                        <?php echo lang('last update') ?><br>
                        <?php echo date_format(date_create($user['updated_at']), 'h:i:sa d/m/Y') ?>
                      </p>
                    </div>
                  <?php } ?>
                  <div class="col-sm-12">
                    <div class="row g-1 justify-content-center align-items-start <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
                      <?php if ($_SESSION['sys']['UserID'] == base64_encode($user['UserID']) || $_SESSION['sys']['user_update'] == 1) { ?>
                        <!-- user profile button -->
                        <div class="col-8">
                          <a href='?do=show-profile&userid=<?php echo base64_encode($user['UserID']) ?>' class='w-100 p-1 btn btn-primary text-capitalize fs-12 fs-10-sm'>
                            <?php echo lang('PROFILE', $lang_file) ?>
                          </a>
                        </div>
                      <?php } ?>
                      <?php if ($_SESSION['sys']['user_delete'] == 1 && count($users_data) > 1 && $user['trust_status'] != 1 && $user['job_title_id'] != 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                        <!-- user delete button -->
                        <div class="col-4">
                          <button type="button" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal" class='w-100 p-1 btn btn-outline-danger text-capitalize fs-12 fs-10-sm' onclick="confirm_delete_employee(this, true, false)" data-employee-name="<?php echo $user['username'] ?>" data-employee-id="<?php echo base64_encode($user['UserID']) ?>">
                            <i class="bi bi-trash"></i>
                            <?php echo lang('DELETE') ?>
                          </button>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
</div>
<!-- include_once delete user module -->
<?php include_once 'delete-modal.php' ?>