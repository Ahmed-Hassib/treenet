<!-- start add new user page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start add new user form -->
  <form class="profile-form" action="?do=insert-user" method="POST" id="add-new-user" enctype="multipart/form-data" onchange="form_validation(this)">
    <!-- start buttons section -->
    <div class="hstack gap-2">
      <?php if ($_SESSION['sys']['user_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <!-- submit button -->
        <button type="button" form="add-new-user" class="btn btn-primary text-capitalize py-1 fs-12 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" onclick="form_validation(this.form, 'submit')">
          <span>
            <?php echo lang('ADD NEW', $lang_file) ?>
          </span>&nbsp;<i class="bi bi-person-plus"></i>
        </button>
      <?php } ?>
    </div>
    <!-- end submit -->
    <!-- horzontal stack -->
    <div class="hstack gap-3">
      <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
        <span>
          <?php echo lang('*REQUIRED') ?>
        </span>
      </h6>
    </div>
    <!-- start new design -->
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
          <!-- start full name field -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="<?php echo lang('FULLNAME', $lang_file) ?>" aria-describedby="fullNameHelp" required>
            <label for="fullname">
              <?php echo lang('FULLNAME', $lang_file) ?>
            </label>
          </div>
          <!-- end full name field -->
          <!-- start gender field -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <select class="form-select" name="gender" id="gender" required>
              <option value="default" selected disabled>
                <?php echo lang('SELECT GENDER', $lang_file) ?>
              </option>
              <option value="0">
                <?php echo lang('MALE', $lang_file) ?>
              </option>
              <option value="1">
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
            <input type="text" class="form-control" name="address" id="address" aria-describedby="address" placeholder="<?php echo lang('THE ADDRESS', $lang_file) ?>">
            <label for="address">
              <?php echo lang('ADDRESS', $lang_file) ?>
            </label>
          </div>
          <!-- end address field -->
          <!-- strat phone field -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="text" maxlength="11" class="form-control" name="phone" id="phone" placeholder="<?php echo lang('PHONE', $lang_file) ?>">
            <label for="phone">
              <?php echo lang('PHONE', $lang_file) ?>
            </label>
          </div>
          <!-- end phone field -->
          <!-- strat date of birth field -->
          <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
            <input type="date" class="form-control px-5" name="date-of-birth" id="date-of-birth" placeholder="<?php echo lang('BIRTH', $lang_file) ?>" min="2005-01-01">
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
            <input type="email" class="form-control" name="email" id="email" placeholder="example@example.com">
            <label for="email">
              <?php echo lang('EMAIL', $lang_file) ?>
            </label>
          </div>
          <!-- end email field -->
          <!-- start user name field -->
          <div class="mb-3 position-relative">
            <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control" name="username" id="username" placeholder="<?php echo lang('USERNAME') ?>" autocomplete="off" aria-describedby="usernameHelp" onblur="check_username(this);" required>
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
              <input type="password" class="form-control" name="password" id="password" placeholder="" autocomplete="new-password" aria-describedby="passHelp" required>
              <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="show_pass(this)" id="show-pass"></i>
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
                <option value="default" selected disabled>
                  <?php echo lang('JOB TITLE', $lang_file) ?>
                </option>
                <?php
                $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
                $job_titles = $db_obj->select_specific_column('*', "`users_job_title`", "WHERE `admin_only` = '0'", 'multiple'); ?>
                <?php foreach ($job_titles as $job_title) { ?>
                  <option value="<?php echo $job_title['job_title_id'] ?>">
                    <?php echo lang($job_title['job_title_name'], $lang_file) ?>
                  </option>
                <?php } ?>
              </select>
              <label for="job-title">
                <?php echo lang('JOB TITLE', $lang_file) ?>
              </label>
            </div>
            <?php if ($_SESSION['sys']['user_update'] == 0) { ?>
              <div id="updatePermissionHelp" class="form-text" dir="<?php echo @$_SESSION['sys']['lang'] == "ar" ? "rtl" : "ltr" ?>">
                <p class="text-danger">
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
            <span class="input-group-text bg-white <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="twitter"><i class="bi bi-twitter text-primary"></i></span>
            <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="twitter" placeholder="twitter" aria-label="twitter" aria-describedby="twitter">
              <label for="twitter">twitter</label>
            </div>
          </div>
          <!-- end twitter field -->
          <!-- strat facebook field -->
          <div class="input-group mb-3">
            <span class="input-group-text bg-white <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'input-group-right' : 'input-group-left' ?>" id="facebook"><i class="bi bi-facebook text-primary"></i></span>
            <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="text" class="form-control <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'form-control-left' : 'form-control-right' ?>" name="facebook" placeholder="facebook" aria-label="facebook" aria-describedby="facebook">
              <label for="facebook">facebook</label>
            </div>
          </div>
          <!-- end facebook field -->
        </div>
      </div>

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
          <?php include_once 'add-user-permissions.php' ?>
          <!-- end user-permission field -->
        </div>
      </div>
    </div>

    <!-- start buttons section -->
    <div class="hstack gap-2">
      <?php if ($_SESSION['sys']['user_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <!-- submit button -->
        <button type="button" form="add-new-user" class="btn btn-primary text-capitalize py-1 fs-12 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" onclick="form_validation(this.form, 'submit')">
          <span>
            <?php echo lang('ADD NEW', $lang_file) ?>
          </span>&nbsp;<i class="bi bi-person-plus"></i>
        </button>
      <?php } ?>
    </div>
    <!-- end submit -->
  </form>
</div>