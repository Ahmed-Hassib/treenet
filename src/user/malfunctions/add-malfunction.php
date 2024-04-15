<?php
// array of errors
$err_arr = array();
// create an object of Database class
$db_obj = !isset($db_obj) ? new Database() : $db_obj;
// get counter of employees, clients and pieces
$emp_counter = $db_obj->count_records("`UserID`", "`users`", "WHERE `job_title_id` = 2 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
$pcs_counter = $db_obj->count_records("`id`", "`pieces_info`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
// add an error if technical men == 0
if ($emp_counter <= 0) {
  $err_arr[] = '*TECH REQUIRED';
}

// add an error if pieces/clients == 0
if ($pcs_counter <= 0) {
  $err_arr[] = '*CLTS & PCS';
}

// check number of pieces/clients and technical men
if (empty($err_arr)) {
?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <!-- start form -->
    <form class="custom-form" action="?do=insert-new-malfunction" method="POST" id="add-malfunction" onchange="form_validation(this)">
      <!-- horzontal stack -->
      <div class="vstack gap-1">
        <!-- note for required inputs -->
        <h6 class="h6 text-decoration-underline text-capitalize text-danger fw-bold">
          <span><?php echo lang('*REQUIRED') ?></span>
        </h6>
      </div>
      <!-- form inputs -->
      <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3">
        <!-- first column -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5 class="h5 text-capitalize"><?php echo lang('RESP MAL', $lang_file) ?></h5>
              <hr />
            </div>
            <!-- Administrator name -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <input type="hidden" class="form-control" id="admin-id" name="admin-id" value="<?php echo $_SESSION['sys']['UserID'] ?>" autocomplete="off" required />
              <input type="text" class="form-control" id="admin-name" name="admin-name" placeholder="administrator name" value="<?php echo $_SESSION['sys']['username'] ?>" autocomplete="off" required readonly />
              <label for="admin-name"><?php echo lang('ADMIN NAME', $lang_file) ?></label>
            </div>
            <!-- Technical name -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <select class="form-select" id="technical-id" name="technical-id" required <?php echo $emp_counter == 0 ? 'disabled' : '' ?>>
                  <option value="default" disabled selected><?php echo lang('SELECT TECH NAME', $lang_file) ?></option>
                  <?php
                  // get Employees ID and Names
                  $usersRows = $db_obj->select_specific_column("`UserID`, `username`, `fullname`", "`users`", "WHERE `is_tech` = 1 AND `job_title_id` = 2 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']), 'multiple');
                  // check the length of result
                  if (!is_null($usersRows)) {
                    // loop on result ..
                    foreach ($usersRows as $userRow) { ?>
                      <!-- get all information of pieces -->
                      <option value="<?php echo base64_encode($userRow['UserID']) ?>">
                        <?php echo $userRow['fullname'] . " (" . $userRow['username'] . ")"; ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                </select>
                <label for="technical-id"><?php echo lang('TECH NAME', $lang_file) ?></label>
              </div>
              <?php if (is_null($usersRows)) { ?>
                <div class="text-danger fw-bold">
                  <i class="bi bi-exclamation-triangle-fill"></i>
                  <?php echo lang("NO DATA") ?>
                </div>
              <?php } ?>
            </div>
            <!-- phone -->
            <div class="mb-3">
              <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                <input type="hidden" name="client-id" id="client-id" class="form-control w-100" placeholder="<?php echo lang('CLT NAME', 'clients') ?>" />
                <input type="text" name="client-name" id="client-name" class="form-control w-100" placeholder="<?php echo lang('CLT NAME', 'clients') ?>" onkeyup="search_name(this)" data-company-id="<?php echo $_SESSION['sys']['company_id'] ?>" required <?php echo $pcs_counter == 0 ? 'disabled' : '' ?> />
                <label for="client-name"><?php echo lang('CLT NAME', 'clients') ?></label>
                <div class="result w-100">
                  <ul class="clients-names" id="clients-names"></ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- forth column -->
        <div class="col-12">
          <div class="section-block">
            <div class="section-header">
              <h5><?php echo lang('MAL DESC', $lang_file) ?></h5>
              <hr />
            </div>
            <!-- notes -->
            <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
              <textarea name="descreption" id="descreption" title="<?php echo lang('MAL DESC', $lang_file) ?>" class="form-control w-100" style="height: 10rem; resize: none; direction: <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>" placeholder="<?php echo lang('MAL DESC', $lang_file) ?>" required><?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['descreption'] : '' ?></textarea>
              <label for="descreption"><?php echo lang('MAL DESC', $lang_file) ?></label>
            </div>
          </div>
        </div>
      </div>

      <!-- submit -->
      <?php if ($_SESSION['sys']['mal_add'] == 1 && $emp_counter >= 1 && $pcs_counter >= 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
        <div class="hstack gap-3">
          <div class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>">
            <button type="button" form="add-malfunction" class="btn btn-primary text-capitalize form-control bg-gradient fs-12" style="width: 150px" id="add-malfunctions" onclick="form_validation(this.form, 'submit')">
              <?php echo lang('ADD') ?>
            </button>
          </div>
        </div>
      <?php } ?>
    </form>
    <!-- end form -->
  </div>
<?php
} else {
  // loop on errors
  foreach ($err_arr as $key => $error) {
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'malfunctions';
  }
  // redirect home
  redirect_home(null, null, 0);
}
