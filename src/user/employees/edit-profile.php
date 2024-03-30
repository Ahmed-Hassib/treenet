<?php
// check if Get request userid is numeric and get the integer value
$user_id = isset($_GET['userid']) && !empty($_GET['userid']) ? base64_decode($_GET['userid']) : null;
// check the current users
if ($user_id == base64_decode($_SESSION['sys']['UserID']) || $_SESSION['sys']['user_show'] == 1) {
  // create an object of User class
  $user_obj = !isset($user_obj) ? new User() : $user_obj;
  // get user info from database
  $user_info = $user_obj->get_user_info($user_id, base64_decode($_SESSION['sys']['company_id']));
  // check the row count
  if (!is_null($user_info)) {
    // get user permissions
    $stmt = $con->prepare("SELECT *FROM `users_permissions` WHERE `UserID` = ? LIMIT 1");
    $stmt->execute(array($user_id)); // execute query
    $permissions = $stmt->fetch(); // fetch data
?>
    <div class="container" dir="<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>">
      <!-- start edit profile -->
      <div class="row row-cols-sm-1 row-cols-lg-2 g-3">
        <!-- start add new user form -->
        <form class="profile-form w-100" action="?do=update-user-info" method="POST" enctype="multipart/form-data" id="edit-user-info" onchange="form_validation(this)">
          <!-- strat submit -->
          <div class="hstack gap-3">
            <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
              <!-- edit button -->
              <?php if (($_SESSION['sys']['user_update'] == 1 || $user_info['UserID'] == base64_decode($_SESSION['sys']['UserID'])) && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                <button type="button" form="edit-user-info" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-primary text-capitalize py-1 fs-12" onclick="form_validation(this.form, 'submit')"><i class="bi bi-check-all"></i>&nbsp;
                  <?php echo lang('SAVE') ?>
                </button>
              <?php } ?>

              <?php if ($user_info['is_root'] != 1 && $user_info['trust_status'] != 1 && $user_info['job_title_id'] != 1 && $_SESSION['sys']['user_delete'] == 1 && $user_info['UserID'] != base64_decode($_SESSION['sys']['UserID']) && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                <!-- delete button -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal" onclick="confirm_delete_employee(this, null, false)" data-employee-name="<?php echo $user_info['username'] ?>" data-employee-id="<?php echo base64_encode($user_info['UserID']) ?>" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-outline-danger text-capitalize py-1 fs-12"><i class="bi bi-trash"></i>&nbsp;
                  <?php echo lang('DELETE') ?>
                </button>
              <?php } ?>
            </div>
          </div>
          <!-- end submit -->

          <!-- horzontal stack -->
          <div class="hstack gap-3">
            <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
              <span>
                <?php echo lang('*REQUIRED') ?>
              </span>
            </h6>
            <?php if (!is_null($user_info['updated_at'])) { ?>
              <h6 class="h6 text-capitalize text-muted fw-bold">
                <?php echo lang('last update') . " " . date_format(date_create($user_info['updated_at']), 'h:i:sa d/m/Y') ?>
              </h6>
            <?php } ?>
          </div>
          <!-- start new design -->
          <div class="mb-3 row g-3 justify-content-start align-items-stretch">
            <!-- employee general info -->
            <div class="col-sm-12">
              <div class="section-block">
                <!-- start profile image -->
                <div class="mb-3 row profile-image-container" id="profile-image-container">
                  <?php $profile_img_name = empty($user_info['profile_img']) || !file_exists($uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $user_info['profile_img']) ? 'male-avatar.svg' : $user_info['profile_img']; ?>
                  <?php $profile_img_path = empty($user_info['profile_img']) || !file_exists($uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $user_info['profile_img']) ? $uploads . "employees-img" : $uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']); ?>
                  <img loading="lazy" src="<?php echo "$profile_img_path/$profile_img_name" ?>" class="profile-img" alt="" id="profile-img">
                  <!-- profile image form -->
                  <input type="file" class="d-none" name="profile-img-input" id="profile-img-input" onchange="change_profile_img(this)" accept="image/*">
                </div>
                <!-- end profile image -->
                <?php if (base64_decode($_SESSION['sys']['UserID']) == $user_info['UserID']) { ?>
                  <!-- start control buttons -->
                  <div class="vstack gap-3 justify-content-center">
                    <?php if (!empty($user_info['profile_img']) && !file_exists($uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $user_info['profile_img'])) { ?>
                      <p class="mb-0 text-center text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?php echo lang('IMG ERROR', $lang_file); ?>
                      </p>
                    <?php } ?>
                    <div class="mx-auto">
                      <!-- edit image button -->
                      <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize" onclick="click_input()">
                        <i class="bi bi-pencil-square"></i>
                        <?php echo lang('CHANGE IMG') ?>
                      </button>
                      <?php if (!empty($user_info['profile_img'])) { ?>
                        <!-- delete image button -->
                        <button type="button" role="button" class="btn btn-danger fs-12 py-1 text-capitalize" onclick="delete_profile_image()">
                          <i class="bi bi-trash"></i>
                          <?php echo lang('DELETE IMG') ?>
                        </button>
                      <?php } ?>
                    </div>
                  </div>
                  <!-- end control buttons -->
                <?php } ?>
              </div>
            </div>
          </div>

          <div class="mb-3 row g-3 justify-content-start align-items-stretch">
            <!-- employee general info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize">
                    <?php echo lang('GENERAL INFO', $lang_file) ?>
                  </h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- user id -->
                <input type="hidden" name="userid" value="<?php echo base64_encode($user_info['UserID']) ?>">
                <!-- start full name field -->
                <div class="mb-3">
                  <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="<?php echo lang('FULLNAME', $lang_file) ?>" value="<?php echo $user_info['fullname'] ?>" <?php echo $_SESSION['sys']['user_update'] == 0 && base64_decode($_SESSION['sys']['UserID']) != $user_info['UserID'] ? 'readonly' : '' ?> required>
                    <label for="fullname">
                      <?php echo lang('FULLNAME', $lang_file) ?>
                    </label>
                  </div>
                </div>
                <!-- end full name field -->
                <!-- start gender field -->
                <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                  <select class="form-select" name="gender" id="gender" <?php echo $_SESSION['sys']['user_update'] == 0 && base64_decode($_SESSION['sys']['UserID']) != $user_info['UserID'] ? 'readonly' : ''; ?> required>
                    <option value="default" selected disabled>
                      <?php echo lang('SELECT GENDER', $lang_file) ?>
                    </option>
                    <option value="0" <?php echo $user_info['gender'] == 0 ? 'selected' : '' ?>>
                      <?php echo lang('MALE', $lang_file) ?>
                    </option>
                    <option value="1" <?php echo $user_info['gender'] == 1 ? 'selected' : '' ?>>
                      <?php echo lang('FEMALE', $lang_file) ?>
                    </option>
                  </select>
                  <label for="gender">
                    <?php echo lang('GENDER', $lang_file) ?>
                  </label>
                </div>
                <!-- end gender field -->
                <!-- start address field -->
                <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                  <input type="text" class="form-control" name="address" id="address" aria-describedby="address" value="<?php echo $user_info['address'] ?>" placeholder="<?php echo lang('NO DATA') ?>" <?php echo $_SESSION['sys']['user_update'] == 0 && base64_decode($_SESSION['sys']['UserID']) != $user_info['UserID'] ? 'readonly' : '' ?>>
                  <label for="address">
                    <?php echo lang('ADDRESS', $lang_file) ?>
                  </label>
                </div>
                <!-- end address field -->
                <!-- strat phone field -->
                <div class="mb-3">
                  <div class="phone-container" <?php if ((empty($user_info['phone']) || $_SESSION['sys']['isLicenseExpired'] == 1) && 1) { ?>style="grid-template-columns: 1fr!important" <?php } ?>>
                    <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                      <input type="text" maxlength="11" class="form-control" name="phone" id="phone" placeholder="<?php echo lang('NO DATA') ?>" value="<?php echo empty($user_info['phone']) ? '' : $user_info['phone'] ?>" <?php echo $_SESSION['sys']['user_update'] == 0 && base64_decode($_SESSION['sys']['UserID']) != $user_info['UserID'] ? 'readonly' : '' ?>>
                      <label for="phone">
                        <?php echo lang('PHONE', $lang_file) ?>
                      </label>
                    </div>
                    <?php if ($user_info['is_activated_phone'] == 0 && !empty($user_info['phone']) && $_SESSION['sys']['isLicenseExpired'] == 0 && 0) { ?>
                      <a href="?do=activate-phone" class="btn btn-primary pt-2">
                        <?php echo lang('ACTIVATE') ?>
                      </a>
                    <?php } ?>
                  </div>
                  <?php if (!empty($user_info['phone'])) { ?>
                    <?php if ($user_info['is_activated_phone'] == 1) { ?>
                      <div id="passHelp" class="form-text text-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <?php echo lang('MOBILE ACTIVATED', $lang_file) ?>
                      </div>
                    <?php } else { ?>
                      <div id="passHelp" class="form-text text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?php echo lang('PHONE NOT ACTIVATED', $lang_file) ?>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
                <!-- end phone field -->
                <!-- strat date of birth field -->
                <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                  <input type="date" class="form-control px-5" name="date-of-birth" id="date-of-birth" value="<?php echo $user_info['date_of_birth'] ?>" <?php echo $_SESSION['sys']['user_update'] == 0 && base64_decode($_SESSION['sys']['UserID']) != $user_info['UserID'] ? 'readonly' : '' ?>>
                  <label for="date-of-birth">
                    <?php echo lang('BIRTH', $lang_file) ?>
                  </label>
                </div>
                <!-- end date of birth field -->
              </div>
            </div>

            <!-- employee personal info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize">
                    <?php echo lang('PERSONAL INFO', $lang_file) ?>
                  </h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- strat email field -->
                <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                  <input type="email" class="form-control" name="email" id="email" placeholder="example@example.com" aria-describedby="emailHelp" value="<?php echo $user_info['email'] ?>" <?php echo $_SESSION['sys']['user_update'] == 0 && base64_decode($_SESSION['sys']['UserID']) != $user_info['UserID'] ? 'readonly' : '' ?>>
                  <label for="email">
                    <?php echo lang('EMAIL', $lang_file) ?>
                  </label>
                </div>
                <!-- end email field -->
                <!-- start user name field -->
                <div class="mb-3 position-relative">
                  <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="text" class="form-control" name="username" id="username" placeholder="<?php echo lang('USERNAME LOGIN', $lang_file) ?>" autocomplete="off" value="<?php echo $user_info['username'] ?>" required readonly>
                    <label for="username">
                      <?php echo lang('USERNAME') ?>
                    </label>
                  </div>
                  <div id="usernameHelp" class="form-text">
                    <?php echo lang('USERNAME LOGIN', $lang_file) ?>
                  </div>
                </div>
                <!-- end user name field -->
                <!-- strat password field -->
                <div class="mb-3 position-relative">
                  <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="hidden" name="old-password" value="<?php echo $user_info['password'] ?>">
                    <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo lang('ENTER NEW PASSSWORD', $lang_file) ?>" aria-describedby="passHelp" autocomplete="new-password" <?php echo $_SESSION['sys']['user_update'] == 0 && base64_decode($_SESSION['sys']['UserID']) != $user_info['UserID'] ? 'readonly' : '' ?>>
                    <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" id="show-pass" onclick="show_pass(this)"></i>
                    <label for="password">
                      <?php echo lang('PASSWORD') ?>
                    </label>
                  </div>
                  <div id="passHelp" class="form-text">
                    <?php echo lang('HARD & COMPLEX') ?>
                  </div>
                </div>
                <!-- end password field -->
              </div>
            </div>

            <!-- employee job info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize">
                    <?php echo lang('JOB INFO', $lang_file) ?>
                  </h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- start job title field -->
                <div class="mb-3 position-relative">
                  <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <select class="form-select" name="job_title_id" id="job_title_id" <?php echo $_SESSION['sys']['user_update'] == 0 ? 'disabled' : '' ?> required>
                      <?php $job_titles = $db_obj->select_specific_column('*', "`users_job_title`", "WHERE `admin_only` = '0'"); ?>
                      <option value="default" <?php echo $user_info['job_title_id'] == 0 ? 'selected' : '' ?> disabled>
                        <?php echo lang('JOB TITLE', $lang_file) ?>
                      </option>
                      <?php foreach ($job_titles as $job_title) { ?>
                        <option value="<?php echo base64_encode($job_title['job_title_id']) ?>" <?php echo $user_info['job_title_id'] == $job_title['job_title_id'] ? 'selected' : '' ?>>
                          <?php echo lang($job_title['job_title_name'], $lang_file) ?>
                        </option>
                      <?php } ?>
                    </select>
                    <label for="job_title_id">
                      <?php echo lang('JOB TITLE', $lang_file) ?>
                    </label>
                  </div>
                  <?php if ($_SESSION['sys']['user_update'] == 0) { ?>
                    <div id="updatePermissionHelp" class="form-text" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
                      <p class="text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <?php echo lang('PERMISSION UPDATE FAILED', $lang_file); ?>
                      </p>
                    </div>
                  <?php } ?>
                </div>
                <!-- end user type field -->
              </div>
            </div>

            <!-- employee social media info -->
            <div class="col-sm-12 col-lg-6">
              <div class="section-block">
                <header class="section-header">
                  <h5 class="h5 text-capitalize">
                    <?php echo lang('SOCIAL MEDIA', $lang_file) ?>
                  </h5>
                  <p class="text-secondary fs-12"></p>
                  <hr>
                </header>
                <!-- strat twitter field -->
                <div class="input-group mb-3">
                  <span class="input-group-text bg-white <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="twitter"><i class="bi bi-twitter-x text-primary"></i></span>
                  <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="text" class="form-control <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="twitter" value="<?php echo $user_info['twitter'] ?>" placeholder="<?php echo lang('NO DATA') ?>" aria-label="twitter" aria-describedby="twitter">
                    <label for="twitter">twitter</label>
                  </div>
                </div>
                <!-- end twitter field -->
                <!-- strat facebook field -->
                <div class="input-group mb-3">
                  <span class="input-group-text bg-white <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="facebook"><i class="bi bi-facebook text-primary"></i></span>
                  <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <input type="text" class="form-control <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="facebook" value="<?php echo $user_info['facebook'] ?>" placeholder="<?php echo lang('NO DATA') ?>" aria-label="facebook" aria-describedby="facebook">
                    <label for="facebook">facebook</label>
                  </div>
                </div>
                <!-- end facebook field -->
                <!-- strat whatsapp field -->
                <!-- <div class="input-group mb-3">
                    <span class="input-group-text bg-success border-success <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="whatsapp"><i class="bi bi-whatsapp"></i></span>
                    <input type="text" class="form-control border-success <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="whatsapp" placeholder="<?php echo lang('NO DATA') ?>" aria-label="whatsapp" aria-describedby="whatsapp">
                </div> -->
                <!-- end whatsapp field -->
              </div>
            </div>

            <?php if ($_SESSION['sys']['permission_show'] == 1) { ?>
              <!-- employee permission -->
              <div class="col-sm-12">
                <div class="section-block">
                  <header class="section-header">
                    <h5 class="text-capitalize ">
                      <?php echo lang('PERMISSIONS', $lang_file) ?>
                    </h5>
                    <hr>
                  </header>
                  <!-- strat user-permission field -->
                  <?php include_once 'edit-user-permissions.php' ?>
                  <!-- end user-permission field -->
                </div>
              </div>
            <?php } ?>
          </div>
          <!-- end new design -->
          <!-- strat submit -->
          <div class="hstack gap-3">
            <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
              <!-- edit button -->
              <?php if (($_SESSION['sys']['user_update'] == 1 || $user_info['UserID'] == base64_decode($_SESSION['sys']['UserID'])) && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                <button type="button" form="edit-user-info" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-primary text-capitalize py-1 fs-12" onclick="form_validation(this.form, 'submit')"><i class="bi bi-check-all"></i>&nbsp;
                  <?php echo lang('SAVE') ?>
                </button>
              <?php } ?>

              <?php if ($user_info['is_root'] != 1 && $user_info['trust_status'] != 1 && $user_info['job_title_id'] != 1 && $_SESSION['sys']['user_delete'] == 1 && $user_info['UserID'] != base64_decode($_SESSION['sys']['UserID']) && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                <!-- delete button -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal" onclick="confirm_delete_employee(this, null, false)" data-employee-name="<?php echo $user_info['username'] ?>" data-employee-id="<?php echo base64_encode($user_info['UserID']) ?>" dir="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'ltr' : 'rtl' ?>" class="btn btn-outline-danger text-capitalize py-1 fs-12"><i class="bi bi-trash"></i>&nbsp;
                  <?php echo lang('DELETE') ?>
                </button>
              <?php } ?>
            </div>
          </div>
          <!-- end submit -->
        </form>
        <!-- start edit profile form -->
      </div>
      <!-- end edit profile -->
    </div>
    <?php if ($_SESSION['sys']['isLicenseExpired'] == 1) : ?>
      <script>
        // select form
        let emp_form_els = document.querySelector('#edit-user-info').elements;
        // loop on it
        for (const element of emp_form_els) {
          // disable element
          element.disabled = true;
        }
      </script>
    <?php endif; ?>

    <!-- include_once delete user module -->
<?php
    // check license
    if ($_SESSION['sys']['isLicenseExpired'] == 0) {
      include_once 'delete-modal.php';
    }
  } else {
    // include_once no data founded module
    include_once $globmod . 'no-data-founded.php';
  }
} else {
  // include_once permission error module
  include_once $globmod . 'permission-error.php';
}
?>