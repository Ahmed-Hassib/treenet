<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize ">
      <?php echo lang('COMPANY BRAND', $lang_file) ?>
    </h5>
    <hr />
  </div>
  <!-- start company image -->
  <div class="company-img-container" id="company-image-container">
    <?php
    $company_img_name_db = $db_obj->select_specific_column("`company_img`", "`companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
    $company_img_name_db = count($company_img_name_db) > 0 ? $company_img_name_db[0]['company_img'] : null;
    $company_img_name = empty($company_img_name_db) || $company_img_name_db == null ? 'treenet.jpg' : $company_img_name_db;
    $company_img_path = empty($company_img_name_db) || $company_img_name_db == null ? $treenet_assets : $uploads . "companies-img/" . base64_decode($_SESSION['sys']['company_id']);
    // check if image exists
    $is_exist_company_img = file_exists("$company_img_path/$company_img_name");

    $img_file =  $is_exist_company_img ? "$company_img_path/$company_img_name" : $treenet_assets . "treenet.jpg";
    // resize company image
    $is_resized = $is_exist_company_img ? resize_img($company_img_path . "/", $company_img_name) : false;
    ?>
    <img loading="lazy" src="<?php echo $is_resized ? "$company_img_path/$company_img_name" : $img_file ?>" class="company-img" id="company-img" alt="<?php echo isset($_SESSION['sys']['company_name']) ? "Image of " . $_SESSION['sys']['company_name'] : lang('NOT ASSIGNED') ?>">
    <form action="?do=change-company-img" method="POST" id="change-company-image" enctype="multipart/form-data">
      <!-- company image form -->
      <input type="file" class="d-none" name="company-img-input" id="company-img-input" onchange="change_company_img(this)" accept="image/*">
    </form>
    <?php if (empty($_SESSION['sys']['company_img']) || !$is_exist_company_img) { ?>
      <span class="d-block text-center text-muted" id="company-img-status">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?php echo lang('DEFAULT IMG', $lang_file) ?>
      </span>
    <?php } ?>
    <?php if (!$is_exist_company_img) { ?>
      <span class="d-block text-center text-danger" id="company-img-status">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?php echo lang('IMG ERROR', $lang_file) ?>
      </span>
    <?php } ?>
  </div>
  <!-- end company image -->
  <?php if ($_SESSION['sys']['change_company_img'] == 1) { ?>
    <!-- start control buttons -->
    <div class="company-img-btn company-img-btn-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'left' : 'right' ?>">
      <!-- edit image button -->
      <button type="button" role="button" class="btn btn-outline-primary fs-12 py-1 text-capitalize" onclick="click_input()">
        <i class="bi bi-pencil-square"></i>
        <?php echo lang('CHANGE IMG', $lang_file) ?>
      </button>
      <?php if (!empty($_SESSION['sys']['company_img'])) { ?>
        <!-- delete image button -->
        <button type="button" role="button" class="btn btn-danger fs-12 py-1 text-capitalize" onclick="delete_company_image('company')">
          <i class="bi bi-trash"></i>
          <?php echo lang('DELETE') ?>
        </button>
      <?php } ?>

      <button type="submit" class="btn btn-success fs-12 py-1 text-capitalize d-none" form="change-company-image" id="change-company-img-btn">
        <i class="bi bi-check-all"></i>
        <?php echo lang('SAVE') ?>
      </button>
    </div>
    <!-- end control buttons -->
  <?php } ?>
</div>