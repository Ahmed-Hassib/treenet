<?php
// check if Database object was created or not
$db_obj = new Database();
// get license info
$license_info = $db_obj->get_license_info(base64_decode($_SESSION['sys']['license_id']), base64_decode($_SESSION['sys']['company_id']));
// check if license not null
if ($license_info != null && count($license_info) > 0) {
  // get license expire date
  $licenseDate = date_create($license_info['expire_date']);
  // date of today
  $today = date_create(Date('Y-m-d'));
  // get diffrence
  $diff = date_diff($today, $licenseDate);
  // check if trial license
  if ($license_info['isTrial'] == 0) {
    switch ($license_info['type']) {
      case 0:
        $type = lang('FOREVER', $lang_file);
        break;
      case 1:
        $type = lang('MONTHLY', $lang_file);
        break;
      default:
        $type = lang('NO DATA');
    }
  } else {
    $type = lang('TRIAL', $lang_file);
  }
  // start date
  $start_date = date_create($license_info['start_date']);
  // expire date
  $expire_date = date_create($license_info['expire_date']);
  // get total days
  $total_days = date_diff($start_date, $expire_date);
  // get date of today
  $to_day = date_create(date("Y-m-d"));
  // get diffrence between today and expire date
  $diffrence = date_diff($to_day, $expire_date);
  // get the rest
  $rest = $diffrence->invert ? 0 : round(($diffrence->days / $total_days->days) * 100, 2);
  ?>
  <div class="section-block">
    <!-- section header -->
    <div class="section-header">
      <h5 class="text-capitalize ">
        <?php echo lang('SYSTEM INFO', $lang_file) ?>
      </h5>
      <hr />
    </div>
    <div class="company-info">
      <span class="company-info__row">
        <span class="company-info__row-label pe-2">
          <?php echo lang('COMPANY NAME', $lang_file) ?>
        </span>
        <span class="company-info__row-info">
          <?php echo $_SESSION['sys']['company_name'] ?>
        </span>
      </span>
      <span class="company-info__row">
        <span class="company-info__row-label pe-2">
          <?php echo lang('COMPANY CODE', $lang_file) ?>
        </span>
        <span class="company-info__row-info">
          <?php echo $_SESSION['sys']['company_code'] ?>
        </span>
      </span>
      <span class="company-info__row">
        <span class="company-info__row-label pe-2">
          <?php echo lang('APP VERSION', $lang_file) ?>
        </span>
        <span class="company-info__row-info">
          <?php echo $_SESSION['sys']['curr_version_name'] ?>
        </span>
      </span>

      <?php if ($_SESSION['sys']['is_tech'] == 0) { ?>
        <span class="company-info__row">
          <span class="company-info__row-label pe-2">
            <?php echo lang('LICENSE', $lang_file) ?>
          </span>
          <span class="company-info__row-info <?php echo $license_info['isTrial'] == 1 ? 'badge bg-danger' : '' ?>">
            <?php
            // plan id
            $plan_id = base64_decode($_SESSION['sys']['plan_id']);
            // check plan id
            if ($plan_id != 0) {
              // get plan data
              $plan_data = $db_obj->select_specific_column("`name_ar`, `name_en`", "`pricing_plans`", "WHERE `id` = {$plan_id}")[0];
              // prepare plan name
              $plan_data = $_SESSION['sys']['lang'] == 'ar' ? $plan_data['name_ar'] : $plan_data['name_en'];
              // display plan 
              echo "{$plan_data}/{$type}";
            } else {
              echo $type;
            }
            ?>
          </span>
        </span>
        <span class="company-info__row">
          <span class="company-info__row-label pe-2">
            <?php echo lang('EXPIRY', $lang_file) ?>
          </span>
          <span class="company-info__row-info">
            <?php echo $license_info['expire_date'] ?>
            <?php if ($rest <= 0) { ?>
              <span class="badge bg-danger fs-12">
                <?php echo lang('EXPIRED') ?>
              </span>
            <?php } ?>
            <?php if ($rest <= 3) { ?>
              <a href="<?php echo $nav_up_level ?>payments/index.php?do=pricing"
                class="btn btn-outline-primary fs-12 mt-1 py-1">
                <i class="bi bi-arrow-clockwise"></i>
                <?php echo lang('RENEW LICENSE') ?>
              </a>
            <?php } ?>
          </span>
        </span>
        <span class="company-info__row">
          <span class="company-info__row-label"></span>
          <span class="company-info__row-info progress">
            <?php if ($rest < 15) { ?>
              <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar"
                style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10"
                aria-valuemax="<?php echo $total_days->days ?>"></div>
              <div class="progress-value">
                <?php echo $rest ?>%
              </div>
            <?php } else { ?>
              <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar"
                style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10"
                aria-valuemax="<?php echo $total_days->days ?>">
                <?php echo $rest ?>%
              </div>
            <?php } ?>
          </span>
        </span>
      <?php } ?>
    </div>
  </div>
<?php } ?>