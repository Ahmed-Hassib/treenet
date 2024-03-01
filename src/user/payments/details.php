<?php
// get company id
$company_id = base64_decode($_SESSION['sys']['company_id']);
// get transaction_id
$trans_id = isset($_GET['transaction']) && !empty($_GET['transaction']) && filter_var($_GET['transaction']) !== false ? $_GET['transaction'] : 0;
// get order id
$order_id = isset($_GET['order']) && !empty($_GET['order']) && filter_var($_GET['order']) !== false ? $_GET['order'] : 0;

// create an object of Transaction class
$trans_obj = new Transaction();
// get transaction details
$trans_details = $trans_obj->get_transaction($company_id, $trans_id, $order_id);
// get company license
$license_id = $trans_obj->get_license_id($company_id);
// get license info
$license_info = $trans_obj->get_license_info($license_id, $company_id);
// get license expire date
$license_expire_date = date_create($license_info['expire_date']);
// date of today
$today = date_create(Date('Y-m-d'));
// get diffrence
$diff = date_diff($today, $license_expire_date);
// check if trial license
if ($license_info['isTrial'] == 0) {
  switch ($license_info['type']) {
    case 0:
      $type = lang('FOREVER', 'settings');
      break;
    case 1:
      $type = lang('MONTHLY', 'settings');
      break;
    default:
      $type = lang('NO DATA');
  }
} else {
  $type = lang('TRIAL', 'settings');
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
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 row g-3 justify-content-center">
    <div class="col-sm-12">
      <div class="section-block">
        <header class="section-header">
          <h2 class="h2 text-capitalize"><?php echo lang('transaction details', $lang_file) ?></h2>
          <hr>
        </header>
        <div class="section-content">
          <div class="transaction-details">
            <p>
              <span><?php echo lang('transaction id', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['transaction_id']) ? $trans_details['transaction_id'] : str_repeat('x', 10) ?></span>
            </p>
            <p>
              <span><?php echo lang('order id', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['order_id']) ? $trans_details['order_id'] : str_repeat('x', 10) ?></span>
            </p>
            <p>
              <span><?php echo lang('status', $lang_file) ?>:</span>
              <span>
                <?php if ($trans_details['is_success']) { ?>
                  <span class="badge rounded-pill bg-success p-2 px-4">
                    <?php echo lang('success') ?>
                  </span>
                <?php } elseif ($trans_details['is_pending']) { ?>
                  <span class="badge rounded-pill bg-warning p-2 px-4">
                    <?php echo lang('pending') ?>
                  </span>
                <?php } elseif ($trans_details['is_refunded']) { ?>
                  <span class="badge rounded-pill bg-warning p-2 px-4">
                    <?php echo lang('refunded') ?>
                  </span>
                <?php } else { ?>
                  <span class="badge rounded-pill bg-danger p-2 px-4">
                    <?php echo lang('failed') ?>
                  </span>
                <?php } ?>
              </span>
            </p>
            <p>
              <span><?php echo lang('price', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['price']) ? $trans_details['price'] : str_repeat('x', 3) ?></span>
            </p>
            <p>
              <span><?php echo lang('currency', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['currency']) ? $trans_details['currency'] : str_repeat('x', 3) ?></span>
            </p>
            <p>
              <span><?php echo lang('errors occured', $lang_file) ?>:</span>
              <span>
                <?php if ($trans_details['is_error_occured'] == 0) { ?>
                  <span class="badge rounded-pill bg-success p-2 px-4">
                    <?php echo lang('no') ?>
                  </span>
                <?php } else { ?>
                  <span class="badge rounded-pill bg-danger p-2 px-4">
                    <?php echo lang('yes') ?>
                  </span>
                <?php } ?>
              </span>
            </p>
            <p>
              <span><?php echo lang('transaction type', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['source_data_type']) ? $trans_details['source_data_type'] : str_repeat('x', 10) ?></span>
            </p>
            <p>
              <span><?php echo lang('data source', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['source_data_pan']) ? $trans_details['source_data_pan'] : str_repeat('x', 11) ?></span>
            </p>
            <p>
              <span><?php echo lang('response code', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['txn_response_code']) ? $trans_details['txn_response_code'] : str_repeat('x', 5) ?></span>
            </p>
            <p>
              <span><?php echo lang('transaction description', $lang_file) ?>:</span>
              <span>
                <?php if ($trans_details['is_success']) { ?>
                  <span class="badge rounded-pill bg-success p-1 d-inline-block" title="<?php echo lang('success') ?>"></span>
                <?php } elseif ($trans_details['is_pending']) { ?>
                  <span class="badge rounded-pill bg-warning p-1 d-inline-block" title="<?php echo lang('pending') ?>"></span>
                <?php } elseif ($trans_details['is_refunded']) { ?>
                  <span class="badge rounded-pill bg-warning p-1 d-inline-block" title="<?php echo lang('refunded') ?>"></span>
                <?php } else { ?>
                  <span class="badge rounded-pill bg-danger p-1 d-inline-block" title="<?php echo lang('failed') ?>"></span>
                <?php } ?>
                <?php echo !empty($trans_details['data_message']) ? wordwrap(lang($trans_details['data_message']), 20) : wordwrap(str_repeat('x', 20), 10, " ", true) ?>
              </span>
            </p>
            <p>
              <span><?php echo lang('created at', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['created_at']) ? $trans_details['created_at'] : str_repeat('x', 10) . " " . str_repeat('x', 8) ?></span>
            </p>
            <p>
              <span><?php echo lang('updated at', $lang_file) ?>:</span>
              <span><?php echo !empty($trans_details['updated_at']) ? $trans_details['updated_at'] : str_repeat('x', 10) . " " . str_repeat('x', 8) ?></span>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="section-block">
        <header class="section-header">
          <h2 class="h2 text-capitalize"><?php echo lang('license info', $lang_file) ?></h2>
          <hr>
        </header>
        <div class="section-content">
          <div class="transaction-details">
            <p>
              <span><?php echo lang('license', 'settings') ?>:</span>
              <span>
                <?php
                // plan id
                $plan_id = $license_info['plan_id'];
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
            </p>
            <p>
              <span><?php echo lang('license status', 'settings') ?>:</span>
              <span>
                <?php if ($license_info['isEnded'] == 0) { ?>
                  <span class="badge rounded-pill bg-success p-2 px-4">
                    <?php echo lang('not expired') ?>
                  </span>
                <?php } else { ?>
                  <span class="badge rounded-pill bg-danger p-2 px-4">
                    <?php echo lang('expired') ?>
                  </span>
                <?php } ?>
              </span>
            </p>
            <p>
              <span><?php echo lang('start date', 'settings') ?>:</span>
              <span><?php echo !empty($license_info['start_date']) ? $license_info['start_date'] : str_repeat('x', 10) ?></span>
            </p>
            <p>
              <span><?php echo lang('expiry', 'settings') ?>:</span>
              <span><?php echo !empty($license_info['expire_date']) ? $license_info['expire_date'] : str_repeat('x', 10) ?></span>
            </p>
            <p>
              <span><?php echo lang('progress') ?>:</span>
              <span>
                <span><?php echo $diffrence->days . " " . lang('DAYS'); ?></span>
                <span class="progress">
                  <?php if ($rest < 15) { ?>
                    <span class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"></span>
                    <span class="progress-value">
                      <?php echo $rest ?>%
                    </span>
                  <?php } else { ?>
                    <span class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>">
                      <?php echo $rest ?>%
                    </span>
                  <?php } ?>
                </span>
              </span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>