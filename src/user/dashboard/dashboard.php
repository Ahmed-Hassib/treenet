<?php
$db_obj = new Database();
// check if system write a log for login into system
if ($_SESSION['sys']['log'] == 0) {
  // log message
  $msg = "loginning to system";
  create_logs($_SESSION['sys']['username'], $msg);
  $_SESSION['sys']['log'] = 1;
}

// check if current user is technical man
if ($_SESSION['sys']['mal_show'] == 1 && $_SESSION['sys']['is_tech'] == 1) {
  $techMalCondition = "AND `tech_id` = " . base64_decode($_SESSION['sys']['UserID']);
} else {
  $techMalCondition = "";
}

// check if current user is technical man
if ($_SESSION['sys']['comb_show'] == 1 && $_SESSION['sys']['is_tech'] == 1) {
  $techCombCondition = "AND `UserID` = " . base64_decode($_SESSION['sys']['UserID']);
} else {
  $techCombCondition = "";
}

// check if t query is set
if (isset($_GET['t']) && !empty($_GET['t']) && $_GET['t'] == 'success-payment') {
  // create a new object of Transaction class
  $trans_obj = new Transaction();

  // get data
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  $transaction_id = (int) $_GET['id'];
  $is_success = filter_var($_GET['success'], FILTER_VALIDATE_BOOLEAN);
  $is_pending = filter_var($_GET['pending'], FILTER_VALIDATE_BOOLEAN);
  $is_refunded = filter_var($_GET['is_refunded'], FILTER_VALIDATE_BOOLEAN);
  $price = (int) $_GET['amount_cents'] / 100;
  $order_id = (int) $_GET['order'];
  $currency = $_GET['currency'];
  $is_error_occured = filter_var($_GET['error_occured'], FILTER_VALIDATE_BOOLEAN);
  $src_data_type = $_GET['source_data_type'];
  $src_data_pan = $_GET['source_data_pan'];
  $txn_response_code = isset($_GET['txn_response_code']) ? $_GET['txn_response_code'] : 0;
  $hmac = $_GET['hmac'];
  $data_message = strtoupper(trim($_GET['data_message'], '\n\r\t\v\0.'));
  $created_at = implode(' ', explode('T', $_GET['created_at']));
  $updated_at = implode(' ', explode('T', $_GET['updated_at']));

  // check if this order id was inserted before or not
  if (!$trans_obj->is_exist("`order_id`", "`transactions`", $order_id)) {
    // success transaction
    // insert it in database
    $trans_obj->insert_transaction(array($company_id, $transaction_id, $is_success, $is_pending, $is_refunded, $price, $order_id, $currency, $is_error_occured, $src_data_type, $src_data_pan, $txn_response_code, $hmac, $data_message, $created_at, $updated_at));
  } else {
    // update transaction info into database
    $trans_obj->update_transaction(array($transaction_id, $is_success, $is_pending, $is_refunded, $price, $currency, $is_error_occured, $src_data_type, $src_data_pan, $txn_response_code, $hmac, $data_message, $created_at, $updated_at, $company_id, $order_id));
  }

  // check status of transaction
  if ($is_success && !$is_pending) {
    // create an object of Company class
    $cmp_obj = new Company();
    // update license
    // date of today
    $today = Date("Y-m-d");
    // license period
    $period = ' + 1 months';
    $expire_date = Date("Y-m-d", strtotime($today . $period));

    // get `isEnded` value
    $count_isEnded = count($cmp_obj->select_specific_column("`isEnded`", "`license`", "WHERE `company_id` = $company_id"));

    // check the value
    if ($count_isEnded > 0) {
      // call renew_license function
      $cmp_obj->end_licenses($company_id);
    }

    // insert a new record
    $cmp_obj->renew_license(1, $expire_date, $company_id, base64_decode($_SESSION['sys']['plan_id_purchase']), $order_id, $transaction_id, 0);

    // create an object of Session class
    $session_obj = new Session();
    // get user info
    $user_info = $session_obj->get_user_info(base64_decode($_SESSION['sys']['UserID']));

    // check if done
    if (!is_null($user_info)) {
      // set user session
      $session_obj->set_user_session($user_info);
    }

    // target url
    $target_url = "{$nav_up_level}payments/index.php?do=details&transaction={$transaction_id}&order={$order_id}";
    // prepare flash session
    $_SESSION['flash_message'] = 'LICENSE RENEWED';
    $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
    $_SESSION['flash_message_class'] = 'success';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
  } else {
    // target url
    $target_url = "{$nav_up_level}payments/index.php?do=pricing";
    // prepare flash session
    $_SESSION['flash_message'] = $data_message;
    $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'] = 'danger';
    $_SESSION['flash_message_status'] = true;
    $_SESSION['flash_message_lang_file'] = 'global_';
  }

  // redirect to target page
  redirect_home(null, $target_url, 0);
}
?>

<!-- start home stats container -->
<div class="container dashboard-container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="dashboard-stats">
    <div class="dashboard-content">
      <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
        <div class="dashboard-card card card-white bg-gradient">
          <img loading="lazy" class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "user.svg" ?>" alt="">
          <div class="card-body">
            <h5 class="h5 text-capitalize">
              <?php echo lang('EMPLOYEES') ?>
            </h5>
            <?php
            // get new employees added in this day
            $new_emp_counter = $db_obj->count_records("`UserID`", "`users`", "WHERE `deleted_at` IS NOT NULL AND `joined_at` = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
            // check counter
            echo "<h5>(" . ($new_emp_counter > 0 ? $new_emp_counter : 0) . " " . lang('NEW') . ")</h5>";
            ?>
          </div>
          <a href="<?php echo $nav_up_level ?>employees/index.php" class="stretched-link text-capitalize"></a>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['dir_show'] == 1) { ?>
        <div class="dashboard-card card card-white bg-gradient">
          <img loading="lazy" class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "cloud.svg" ?>" alt="">
          <div class="card-body">
            <h5 class="h5 text-capitalize">
              <?php echo lang('DIRECTIONS') ?>
            </h5>
            <?php
            // get new directions counter
            $new_dir_counter = $db_obj->count_records("`direction_id`", "`direction`", "WHERE Date(`added_date`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
            // check counter
            echo "<h5>(" . ($new_dir_counter > 0 ? $new_dir_counter : 0) . " " . lang('NEW') . ")</h5>";
            ?>
          </div>
          <a href="<?php echo $nav_up_level ?>directions/index.php" class="stretched-link text-capitalize"></a>
        </div>
        <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <div class="dashboard-card card card-white bg-gradient">
            <img loading="lazy" class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "map.svg" ?>" alt="">
            <div class="card-body">
              <h5 class="h5 text-capitalize">
                <?php echo wordwrap(lang('DIRECTIONS MAP'), 20, "<br>") ?>
              </h5>
              <h5>
                <span class="badge bg-primary">
                  <?php echo lang('NEW FEATURE') ?>
                </span>
              </h5>
            </div>
            <a href="<?php echo $nav_up_level ?>directions/index.php?do=direction-map&dir-id=<?php echo base64_encode('all') ?>" class="stretched-link text-capitalize"></a>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
        <div class="dashboard-card card card-white bg-gradient">
          <img loading="lazy" class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "router.svg" ?>" alt="">
          <div class="card-body">
            <h5 class="h5 text-capitalize">
              <?php echo lang('PIECES') ?>
            </h5>
            <?php
            // get new pieces counter
            $new_pcs_counter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 0 AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
            // check counter
            echo "<h5>(" . ($new_pcs_counter > 0 ? $new_pcs_counter : 0) . " " . lang('NEW') . ")</h5>";
            ?>
          </div>
          <a href="<?php echo $nav_up_level ?>pieces/index.php" class="stretched-link text-capitalize"></a>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
        <div class="dashboard-card card card-white bg-gradient">
          <img loading="lazy" class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "people.svg" ?>" style="scale: 1.5" alt="">
          <div class="card-body">
            <h5 class="h5 text-capitalize">
              <?php echo lang('CLIENTS') ?>
            </h5>
            <?php
            // get new clients counter
            $new_clients_counter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND Date(`created_at`) = '" . get_date_now() . "' AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
            // check counter
            echo "<h5>(" . ($new_clients_counter > 0 ? $new_clients_counter : 0) . " " . lang('NEW') . ")</h5>";
            ?>
          </div>
          <a href="<?php echo $nav_up_level ?>clients/index.php" class="stretched-link text-capitalize"></a>
        </div>
        <div class="dashboard-card card card-white bg-gradient">
          <img loading="lazy" class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "complaints_2.png" ?>" style="scale: 1.5" alt="">
          <div class="card-body">
            <h5 class="h5 text-capitalize">
              <?php echo wordwrap(lang('THE COMPS & SUGGS', 'comp_sugg'), 20, "<br>") ?>
            </h5>
            <h5>
              <span class="badge bg-primary">
                <?php echo lang('new feature') ?>
              </span>
            </h5>
          </div>
          <a href="<?php echo $nav_up_level ?>comp-sugg/index.php" class="stretched-link text-capitalize"></a>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
        <div class="dashboard-card card card-mal bg-gradient">
          <div class="card-img-container <?php echo $page_dir == 'ltr' ? 'card-img-container-right' : 'card-img-container-left' ?> bg-white">
            <img class="card-img" src="<?php echo $treenet_assets . "flash.svg" ?>" alt="">
          </div>
          <div class="card-body">
            <h5 class="h5 text-capitalize">
              <?php echo lang('MALS') ?>
            </h5>
            <?php
            // get new malfunctions counter
            $new_mal_counter = $db_obj->count_records("`mal_id`", "`malfunctions`", "WHERE Date(`created_at`) = '" . get_date_now() . "' AND `mal_status` = 0 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " $techMalCondition");
            // check the counter
            echo "<h5>(" . ($new_mal_counter > 0 ? $new_mal_counter : 0) . " " . lang('NEW') . ")</h5>";
            ?>
          </div>
          <a href="<?php echo $nav_up_level ?>malfunctions/index.php" class="stretched-link text-capitalize"></a>
        </div>
      <?php } ?>
      <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
        <div class="dashboard-card card card-comb bg-gradient">
          <div class="card-img-container <?php echo $page_dir == 'ltr' ? 'card-img-container-right' : 'card-img-container-left' ?> bg-white">
            <img class="card-img" src="<?php echo $treenet_assets . "braces-asterisk.svg" ?>" alt="">
          </div>
          <div class="card-body">
            <h5 class="h5 text-capitalize">
              <?php echo lang('COMBS') ?>
            </h5>
            <?php
            // get new combinations counter
            $new_comb_counter = $db_obj->count_records("`comb_id`", "`combinations`", "WHERE Date(`created_at`) = '" . get_date_now() . "' AND `isFinished` = 0 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " $techCombCondition");
            // check the counter
            echo "<h5>(" . ($new_comb_counter > 0 ? $new_comb_counter : 0) . " " . lang('NEW') . ")</h5>";
            ?>
          </div>
          <a href="<?php echo $nav_up_level ?>combinations/index.php" class="stretched-link text-capitalize"></a>
        </div>
      <?php } ?>
      <div class="dashboard-card card card-trash bg-gradient">
        <div class="card-img-container <?php echo $page_dir == 'ltr' ? 'card-img-container-right' : 'card-img-container-left' ?> bg-white">
          <img class="card-img" src="<?php echo $treenet_assets . "trash.svg" ?>" alt="">
        </div>
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo lang('TRASH') ?>
          </h5>
        </div>
        <a href="<?php echo $nav_up_level ?>deletes/index.php" class="stretched-link text-capitalize"></a>
      </div>
    </div>
  </div>
  <!-- end stats -->

  <aside class="dashboard-aside none">
    <!-- search form -->
    <form action="?do=search" class="mb-3 search-form">
      <div class="search-container">
        <i class="bi bi-search search-icon <?php echo $page_dir == 'rtl' ? 'search-icon-right' : 'search-icon-left' ?>"></i>
        <input type="search" name="search" id="" class="form-control <?php echo $page_dir == 'rtl' ? 'search-right' : 'search-left' ?>" placeholder="<?php echo lang('SEARCH HERE', $lang_file) ?>">
      </div>
    </form>
    <!-- advertisements container -->
    <div class="mb-3 advs-container card">
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <!-- <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button> -->
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?php echo $treenet_assets . "search.svg" ?>" class="d-block w-100 card-img-top" alt="..." data-bs-interval="7000">
            <div class="carousel-caption <?php echo $page_dir == 'rtl' ? 'text-end' : 'text-start' ?>" data-bs-interval="7000">
              <h5 class="card-title"><?php echo lang('SEARCH FEATURE', $lang_file)  ?></h5>
              <h6 class="card-subtitle mb-3 badge bg-primary"><?php echo lang('NEW FEATURE')  ?></h6>
              <p><?php echo lang('SEARCH FEATURE NOTE', $lang_file) ?></p>
            </div>
          </div>
          <!-- <div class="carousel-item">
            <img src="<?php echo $treenet_assets . "adv_img.svg" ?>" class="d-block w-100 card-img-top" alt="..." data-bs-interval="7000">
            <div class="carousel-caption <?php echo $page_dir == 'rtl' ? 'text-end' : 'text-start' ?>">
              <h5 class="card-title">Second slide label</h5>
              <p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة ذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.</p>
              <a href="" class="btn btn-treenet-primary w-100">
                <?php echo lang('GO TO INTRO VIDEO', $lang_file) ?>
              </a>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <!-- advertisements small card -->
    <div class="small-card-adv card card-adv-dark">
      <div class="card-img-top-container card-img-top-container-dark">
        <img src="<?php echo $treenet_assets . "wallet-arrow-left.svg" ?>" alt="">
      </div>
      <div class="card-body">
        <h5 class="card-title"><?php echo wordwrap(lang('ADV OF EARLY DISCOUNT'), 50, "<br>") ?></h5>
      </div>

      <div class="card-link-container">
        <div class="card-link-container_content card-link-container_content-dark">
          <a href="<?php echo $nav_up_level ?>payments/index.php?do=pricing" class="card-link">
            <?php echo wordwrap(lang('VIEW PLANS'), 20, "<br>") ?>
          </a>
        </div>
      </div>
    </div>
  </aside>
</div>
<!-- end dashboard page -->


<script>
  localStorage.removeItem("sss", true)
  localStorage.setItem('mikrotik_ping', Boolean(<?php echo $_SESSION['sys']['mikrotik']['status'] ?>));
</script>