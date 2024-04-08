<?php
// echo sha1("123456");
// create an object of Companies
$company_obj = new Company();
// get company id
$company_id = isset($_GET['company-id']) && !empty($_GET['company-id']) ? base64_decode(trim($_GET['company-id'], "")) : null;

// check id
if ($company_id != null) {
  // company_data
  $company_data = $company_obj->get_company_info($company_id);
  // company current license id
  $company_license_id = $company_obj->get_license_id($company_id);
  // company current license info
  $company_license_info = $company_obj->get_license_info($company_license_id, $company_id);
  // employees
  $company_employees = $company_obj->get_company_employees($company_id);

  // check company license
  if ($company_license_info['isEnded'] == '1' || $company_obj->is_expired($company_license_info['expire_date'])) {
    $is_updated_license = $company_obj->end_licenses($company_id);

    // check if update license
    if ($is_updated_license) {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'LICENSE DATE EXPIRED';
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
      // redirect to same page
      redirect_home(null, $_SERVER['REQUEST_URI'], 0);
    }
  }
?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start header -->
    <header class="header mb-3">
      <div class="hstack gap-2">
        <?php if ($company_license_info['isEnded'] == '1') { ?>
          <div>
            <span class="badge bg-danger p-2 d-inline-block"></span>
            <span>
              <?php echo lang('LICENSE EXPIRED', $lang_file) ?>
            </span>
          </div>
        <?php } else { ?>
          <div>
            <span class="badge bg-success p-2 d-inline-block"></span>
            <span>
              <?php echo lang('LICENSE ACTIVE', $lang_file) ?>
            </span>
          </div>
        <?php } ?>
      </div>
    </header>
    <!-- start company info -->
    <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start">
      <!-- first column -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('COMPANY INFO', 'login') . '&nbsp;' . $company_id; ?>
            </h5>
            <hr />
          </div>
          <form action="?do=update" method="post">
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-5 g-3 align-items-stretch justify-content-start">
              <!-- company name -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="hidden" class="form-control" id="company-id" name="company-id" value="<?php echo base64_encode($company_data['company_id']) ?>" readonly />
                <input type="text" class="form-control" id="company-name" name="company-name" placeholder="<?php echo lang('COMPANY NAME', 'login') ?>" value="<?php echo $company_data['company_name'] ?>" disabled />
                <label for="company-name">
                  <?php echo lang('COMPANY NAME', 'login'); ?>
                </label>
              </div>
              <!-- company code -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" class="form-control" id="company-code" name="company-code" placeholder="<?php echo lang('COMPANY CODE', 'login') ?>" value="<?php echo $company_data['company_code'] ?>" disabled />
                <label for="company-code">
                  <?php echo lang('COMPANY CODE', 'login'); ?>
                </label>
              </div>
              <!-- company manager -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" class="form-control" id="company-manager" name="company-manager" placeholder="<?php echo lang('COMPANY MANAGER', 'login') ?>" value="<?php echo $company_data['company_manager'] ?>" disabled />
                <label for="company-manager">
                  <?php echo lang('COMPANY MANAGER', 'login'); ?>
                </label>
              </div>
              <!-- company country -->
              <div class="mb-3 form-floating">
                <?php
                // create an object of Countries class
                $countries_obj = new Countries();
                // get all countries
                $countries = $countries_obj->get_all_countries();
                ?>
                <select class="form-select" name="country" id="country" required disabled>
                  <?php if ($countries != null) { ?>
                    <option value="default" disabled selected>
                      <?php echo lang('SELECT COUNTRY', $lang_file) ?>
                    </option>
                    <?php foreach ($countries as $country) { ?>
                      <option value="<?php echo $country['country_id'] ?>" <?php echo $company_data['country_id'] == $country['country_id'] ? 'selected' : '' ?>>
                        <?php echo @$_SESSION['sys']['lang'] == 'ar' ? $country['country_name_ar'] : $country['country_name_en'] ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                </select>
                <label for="country">
                  <?php echo lang("COUNTRY", 'login') ?>
                </label>
              </div>
              <!-- phone -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" name="phone-number" id="phone-number" class="form-control w-100" placeholder="<?php echo lang('PHONE') ?>" value="<?php echo $company_data['company_phone'] ?>" disabled />
                <label for="phone-number">
                  <?php echo lang('PHONE'); ?>
                </label>
              </div>
              <!-- license id -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="text" name="license-id" id="license-id" class="form-control w-100" placeholder="<?php echo lang('LICENSE ID', $lang_file) ?>" value="<?php echo $company_license_id . (!empty($company_data['company_code']) ? $company_data['company_code'] : 'AA00') ?>" disabled />
                <input type="hidden" name="license-id" id="license-id" class="form-control w-100" placeholder="<?php echo lang('LICENSE ID', $lang_file) ?>" value="<?php echo base64_encode($company_license_id) ?>" readonly />
                <label for="license-id">
                  <?php echo lang('LICENSE ID', $lang_file); ?>
                </label>
              </div>
              <!-- license type -->
              <div class="mb-3 form-floating">
                <select class="form-select" name="is-trial" id="is-trial" required>
                  <option value="default" disabled><?php echo lang('SELECT LICENSE TYPE', $lang_file) ?></option>
                  <option value="0" <?php echo $company_license_info['isTrial'] == '0' ? 'selected' : '' ?>><?php echo lang('ACTIVE', 'settings') ?></option>
                  <option value="1" <?php echo $company_license_info['isTrial'] == '1' ? 'selected' : '' ?>><?php echo lang('TRIAL', 'settings') ?></option>
                </select>
                <label for="is-trial">
                  <?php echo lang('LICENSE TYPE', $lang_file); ?>
                </label>
              </div>
              <!-- license status -->
              <div class="mb-3 form-floating">
                <select class="form-select" name="is-ended" id="is-ended" required>
                  <option value="default" disabled><?php echo lang('SELECT LICENSE STATUS', $lang_file) ?></option>
                  <option value="0" <?php echo $company_license_info['isEnded'] == '0' ? 'selected' : '' ?>><?php echo lang('LICENSE ACTIVE', $lang_file) ?></option>
                  <option value="1" <?php echo $company_license_info['isEnded'] == '1' || $company_license_info['expire_date'] < date('Y-m-d') ? 'selected' : '' ?>><?php echo lang('LICENSE EXPIRED', $lang_file) ?></option>
                  <option value="2" <?php echo $company_license_info['isEnded'] == '2' ? 'selected' : '' ?>><?php echo lang('LICENSE SUSPENDED', $lang_file) ?></option>
                </select>
                <label for="is-ended">
                  <?php echo lang('LICENSE STATUS', $lang_file); ?>
                </label>
              </div>
              <!-- license status -->
              <?php
              // create an object of Pricing class
              $pricing_obj = new Pricing();
              // get all pricing plans
              $pricing_plans = $pricing_obj->get_all_pricing_plans();
              ?>
              <div class="mb-3 form-floating">
                <select class="form-select" name="plan-id" id="plan-id" required>
                  <option value="default" disabled <?php echo $company_license_info['plan_id'] == '0' ? 'selected' : null ?>><?php echo lang('SELECT PLAN TYPE', $lang_file) ?></option>
                  <?php foreach ($pricing_plans as $key => $plan) { ?>
                    <option value="<?php echo base64_encode($plan['id']) ?>" <?php echo $company_license_info['plan_id'] == $plan['id'] ? 'selected' : null ?>><?php echo $page_dir == 'rtl' ? $plan['name_ar'] : $plan['name_en'] ?></option>
                  <?php } ?>
                </select>
                <label for="plan-id">
                  <?php echo lang('PLAN TYPE', $lang_file); ?>
                </label>
              </div>
              <!-- expire date -->
              <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="date" name="expire-date" id="expire-date" class="form-control w-100" placeholder="<?php echo lang('EXPIRY', 'settings') ?>" value="<?php echo $company_license_info['expire_date'] ?>" />
                <label for="expire-date">
                  <?php echo lang('EXPIRY', 'settings'); ?>
                </label>
              </div>
            </div>

            <div class="hstack gap-3">
              <button type="submit" class="<?php echo $page_dir == 'rtl' ? 'me-auto' : 'ms-auto' ?> btn btn-primary">
                <i class="bi bi-check-all"></i>
                <?php echo lang('SAVE') ?>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- start company licenses -->
    <div class="mb-3 row row-cols-sm-1 align-items-stretch justify-content-start">
      <?php
      // get all company licenses
      $company_licenses = $company_obj->get_licenses_info($company_id);
      ?>
      <!-- company licenses info -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('company licenses', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <!-- strst pieces table -->
          <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" data-scroll-y="<?php echo count($company_licenses) < 5 ? 'auto' : '200' ?>" style="width:100%">
            <thead class="primary text-capitalize">
              <tr>
                <th>#</th>
                <th><?php echo lang('license id') ?></th>
                <th><?php echo lang('start date') ?></th>
                <th><?php echo lang('expire date') ?></th>
                <th><?php echo lang('license type', $lang_file); ?></th>
                <th><?php echo lang('license status', $lang_file); ?></th>
                <th><?php echo lang('plan type', $lang_file); ?></th>
                <th><?php echo lang('order id'); ?></th>
                <th><?php echo lang('transaction id'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($company_licenses as $key => $license) { ?>
                <tr>
                  <td><?php echo $key + 1 ?></td>
                  <td>
                    <?php echo $license['ID'] . (!empty($company_data['company_code']) ? $company_data['company_code'] : 'AA00') ?>
                  </td>
                  <td><?php echo $license['start_date'] ?></td>
                  <td><?php echo $license['expire_date'] ?></td>
                  <td>
                    <?php if ($license['isTrial'] == 1) { ?>
                      <span class="px-4 badge bg-danger"><?php echo lang('TRIAL', 'settings') ?></span>
                    <?php } else { ?>
                      <span class="px-4 badge bg-success"><?php echo lang('ACTIVE', 'settings') ?></span>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($license['isEnded'] == 1) { ?>
                      <span class="px-4 badge bg-danger"><?php echo lang('license expired', $lang_file) ?></span>
                    <?php } elseif ($license['isEnded'] == 2) { ?>
                      <span class="px-4 badge bg-warning"><?php echo lang('license suspended', $lang_file) ?></span>
                    <?php } else { ?>
                      <span class="px-4 badge bg-success"><?php echo lang('license active', $lang_file) ?></span>
                    <?php } ?>
                  </td>
                  <td>
                    <?php
                    // check plan id 
                    if ($license['plan_id'] == 0) {
                      echo "-";
                    } else {
                      $price_plan = $pricing_obj->get_plan($license['plan_id']);
                      echo $page_dir == 'ltr' ? $price_plan['name_en'] : $price_plan['name_ar'];
                    }
                    ?>
                  </td>
                  <td><?php echo $license['order_id'] == 0 ? '-' : $license['order_id'] ?></td>
                  <td><?php echo $license['transaction_id'] == 0 ? '-' : $license['transaction_id'] ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- start company info -->
    <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3 align-items-stretch justify-content-start">
      <?php
      // create an object of User class
      $emp_obj = new User();
      // get all employees of this company
      $employees = $emp_obj->get_all_users($company_id);

      // check employees
      if (!is_null($employees)) {
      ?>

        <!-- additional info -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('THE EMPLOYEES', 'employees') . '&nbsp;' . count($employees) ?>
              </h5>
              <hr />
            </div>
            <!-- strst pieces table -->
            <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" data-scroll-y="<?php echo count($employees) < 5 ? 'auto' : '200' ?>" style="width:100%">
              <thead class="primary text-capitalize">
                <tr>
                  <th>#</th>
                  <th><?php echo lang('FULLNAME', 'employees') ?></th>
                  <th><?php echo lang('JOB TITLE', 'employees') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($employees as $key => $emp) { ?>
                  <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td>
                      <?php echo !empty($emp['fullname']) ? $emp['fullname'] : $emp['username'] ?>
                      <?php if ($emp['trust_status'] == 1) { ?>
                        <i class="bi bi-patch-check-fill text-primary"></i>
                      <?php } ?>
                    </td>
                    <td>
                      <?php
                      if ($emp['job_title_id'] != null) {
                        $job_name = $emp_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . $emp['job_title_id']);
                        if (!empty($job_name)) {
                          $job_name = $job_name['job_title_name'];
                          $job_lang_file = 'employees';
                        } else {
                          $job_name = 'not assigned';
                          $job_lang_file = 'global_';
                        }
                      } else {
                        $job_name = 'not assigned';
                        $job_lang_file = 'global_';
                      }
                      // display job title
                      echo lang(strtoupper($job_name), $job_lang_file);
                      ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php } ?>
      <?php
      // create an object of Direction class
      $dir_obj = new Direction();
      // get all directions of this company
      $directions = $dir_obj->get_all_directions($company_id);
      // check directions
      if (!is_null($directions)) {
        // directions counter
        $dirs_count = count($directions);
        // directions data
        $dirs_data = $directions;
      ?>

        <!-- additional info -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5>
                <?php echo lang('THE DIRECTIONS', 'directions') . '&nbsp;' . $dirs_count ?>
              </h5>
              <hr />
            </div>
            <!-- strst pieces table -->
            <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" data-scroll-y="<?php echo count($dirs_data) < 5 ? 'auto' : '200' ?>" style="width:100%">
              <thead class="primary text-capitalize">
                <tr>
                  <th>#</th>
                  <th><?php echo lang('DIR NAME', 'directions') ?></th>
                  <th><?php echo lang('ADDED DATE') ?></th>
                  <th><?php echo lang('CODE') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($dirs_data as $key => $dir) { ?>
                  <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $dir['direction_name']  ?></td>
                    <td><?php echo $dir['added_date'] ?></td>
                    <td><?php echo 'DIR_' . $dir['direction_id'] . '_' . $dir['company_id'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- start company statistics -->
    <div class="mb-3 row row-cols-sm-1 align-items-stretch justify-content-start">
      <!-- company statistics info -->
      <div class="col-12">
        <div class="section-block">
          <div class="section-header">
            <h5>
              <?php echo lang('COMPANY STATISTICS', $lang_file) ?>
            </h5>
            <hr />
          </div>
          <div class="stats">
            <div class="dashboard-content">
              <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
                <div class="card-body">
                  <span class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-ethernet"></i></span>
                  <h5 class="h5 text-capitalize d-block">
                    <?php echo lang('AVAILABLE PORTS') ?>
                  </h5>
                </div>
                <div class="card-footer">
                  <span>
                    <?php echo $conf['available_ports'] ?>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php
} else {
  // include permission error
  include_once $globmod . "permission-error.php";
}
