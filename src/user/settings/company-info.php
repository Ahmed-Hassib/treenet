<?php
// create an object of Company
$company_obj = new Company();
// get all company info 
$company_info = $company_obj->get_company_info(base64_decode($_SESSION['sys']['company_id']));

?>
<div class="section-block">
  <div class="section-header">
    <h5 class="h5 text-capitalize"><?php echo lang('company info') ?></h5>
    <hr>
  </div>

  <form action="?do=change-company-info" method="post">
    <div class="mb-3 row row-cols-sm-1 g-3">
      <div class="col">
        <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input type="text" class="form-control" name="company_name" id="company_name" placeholder="<?php echo lang('COMPANY NAME', $lang_file) ?>" value="<?php echo $_SESSION['sys']['company_name'] ?>" required>
          <label for="company_name"><?php echo lang('COMPANY NAME', $lang_file) ?></label>
        </div>
      </div>
      <div class="col">
        <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input type="text" class="form-control" name="company_manager_name" id="company_manager_name" placeholder="<?php echo lang('COMPANY NAME', $lang_file) ?>" value="<?php echo $company_info['company_manager'] ?>" required>
          <label for="company_manager_name"><?php echo lang('MANAGER NAME', 'login') ?></label>
        </div>
      </div>
      <div class="col">
        <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input type="text" class="form-control" name="company_phone" id="company_phone" placeholder="<?php echo lang('COMPANY NAME', $lang_file) ?>" value="<?php echo $company_info['company_phone'] ?>" required>
          <label for="company_phone"><?php echo lang('PHONE') ?></label>
        </div>
      </div>
      <!-- company country -->
      <div class="form-floating">
        <?php
        // create an object of Countries class
        $countries_obj = new Countries();
        // get all countries
        $countries = $countries_obj->get_all_countries();
        ?>
        <select class="form-select" name="country" id="country" required>
          <?php if ($countries != null) { ?>
            <option value="default" disabled selected>
              <?php echo lang('SELECT COUNTRY', 'login') ?>
            </option>
            <?php foreach ($countries as $country) { ?>
              <option value="<?php echo $country['country_id'] ?>" <?php echo $country['country_id'] == $company_info['country_id'] ? 'selected' : '' ?>>
                <?php echo @$_SESSION['sys']['lang'] == 'ar' ? $country['country_name_ar'] : $country['country_name_en'] ?>
              </option>
            <?php } ?>
          <?php } ?>
        </select>
        <label for="country">
          <?php echo lang("COUNTRY", 'login') ?>
        </label>
      </div>

      <div class="col hstack">
        <!-- submit button -->
        <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12 py-1"><i class="bi bi-check-all me-1"></i><?php echo lang('SAVE') ?></button>
      </div>
    </div>
  </form>
</div>