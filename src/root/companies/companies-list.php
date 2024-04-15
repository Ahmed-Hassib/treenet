<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start header -->
  <header class="header mb-3">
    <div class="hstack gap-2">
      <!-- edit current piece -->
      <div>
        <!-- Button trigger modal -->
        <a class="btn btn-outline-primary fs-12 py-1" href="?do=add-new-company">
          <i class="bi bi-pencil d-sm-block d-md-none"></i>
          <span class="d-none d-md-block"><?php echo lang("ADD NEW COMPANY", $lang_file) ?></span>
        </a>
      </div>
      <div class="hstack gap-2">
        <div>
          <span class="badge bg-danger p-2 d-inline-block"></span>
          <span><?php echo lang('LICENSE EXPIRED', $lang_file) ?></span>
        </div>
        <div>
          <span class="badge bg-success p-2 d-inline-block"></span>
          <span><?php echo lang('LICENSE ACTIVATED', $lang_file) ?></span>
        </div>
      </div>
    </div>
  </header>

  <!-- start table container -->
  <div class="table-responsive-sm">
    <div class="fixed-scroll-btn">
      <!-- scroll left button -->
      <button type="button" role="button" class="scroll-button scroll-prev scroll-prev-right">
        <i class="carousel-control-prev-icon"></i>
      </button>
      <!-- scroll right button -->
      <button type="button" role="button" class="scroll-button scroll-next <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
        <i class="carousel-control-next-icon"></i>
      </button>
    </div>
    <!-- strst companies table -->
    <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" style="width:100%">
      <thead class="primary text-capitalize">
        <tr>
          <th class="d-none">#</th>
          <th>#</th>
          <th><?php echo lang('STATUS', $lang_file) ?></th>
          <th><?php echo lang('COMPANY NAME', $lang_file) ?></th>
          <th><?php echo lang('MANAGER NAME', $lang_file) ?></th>
          <th><?php echo lang('PHONE', $lang_file) ?></th>
          <th><?php echo lang('APP VERSION', $lang_file) ?></th>
          <th><?php echo lang('JOINED DATE', $lang_file) ?></th>
          <th><?php echo lang('EXPIRE DATE', $lang_file) ?></th>
          <th>Progress</th>
          <th><?php echo lang('CONTROL', $lang_file) ?></th>
        </tr>
      </thead>
      <tbody id="companies-table">
        <?php
        // create an object of Company class
        $comp_obj = new Company();
        // get all companies
        $companies = $comp_obj->get_all_companies();
        // loop on data
        foreach ($companies as $key => $company) { ?>
          <?php
          // get company dates
          $dates = $comp_obj->select_specific_column("`start_date`, `expire_date`", "`license`", "WHERE `isEnded` = 0 AND `company_id` = " . $company['company_id']);
          // check the value
          if (!is_null($dates) && count($dates) > 0 && !is_null($dates)) {
            $start_date = date_create($dates['start_date']);
            $expire_date = date_create($dates['expire_date']);
            $expire = $dates['expire_date'];
            $is_ended = $expire < date("Y-m-d");
          } else {
            $is_ended = true;
            // get company dates
            $expire = $comp_obj->select_specific_column("`expire_date`", "`license`", "WHERE `isEnded` = 1 AND `company_id` = " . $company['company_id'] . " ORDER BY `expire_date` DESC LIMIT 1");
            $expire = !is_null($expire) ? $expire['expire_date'] : '';
          }
          ?>
          <tr>
            <!-- index -->
            <td class="d-none"><?php echo $company['company_id'] ?></td>
            <!-- index -->
            <td><?php echo ++$key; ?></td>
            <td class="text-center">
              <?php if ($is_ended == true) { ?>
                <span class="badge bg-danger p-2 d-inline-block" title="<?php echo lang('LICENSE EXPIRED', $lang_file) ?>"></span>
              <?php } else { ?>
                <span class="badge bg-success p-2 d-inline-block" title="<?php echo lang('LICENSE ACTIVATED', $lang_file) ?>"></span>
              <?php } ?>
            </td>
            <!-- company name -->
            <td>
              <?php echo $company['company_name'] ?>
            </td>
            <!-- company manager name -->
            <td><?php echo $company['company_manager'] ?></td>
            <!-- company phone -->
            <td class="<?php echo !empty($company['company_phone']) ? '' : 'text-danger fw-bold' ?>">
              <?php echo !empty($company['company_phone']) ? $company['company_phone'] : lang('NOT ASSIGNED', $lang_file) ?>
            </td>
            <!-- company version -->
            <td>
              <?php echo $comp_obj->select_specific_column("`v_name`", "`versions`", "WHERE `v_id` = " . $company['version'])['v_name']; ?>
            </td>
            <!-- company joined date -->
            <td><?php echo !empty($company['joined_date']) ? $company['joined_date'] : lang('NOT ASSIGNED', $lang_file) ?></td>
            <!-- company expire date -->
            <td>
              <?php echo $expire; ?>
            </td>
            <!-- company progress -->
            <td>
              <?php
              if ($is_ended == false) {
                // get total days
                $total_days = date_diff($start_date, $expire_date);
                // get date of today
                $to_day = date_create(date("Y-m-d"));
                // get diffrence between today and expire date
                $diffrence = date_diff($to_day, $expire_date);
                // check if diffrence is minus value
                $is_minus = $diffrence->invert;
                // get the rest
                $rest = round(($diffrence->days / $total_days->days) * 100, 2);
                // check the rest
                if ($rest >= 100) {
                  $rest = 100;
                } elseif ($is_minus) {
                  $rest = 0;
                }
              } else {
                $rest = 0;
              }
              ?>
              <div class="progress" title="<?php echo (isset($is_minus) && $is_minus == true) || !isset($diffrence)  ? 0 : $diffrence->days ?> days">
                <?php if ($rest < 15) { ?>
                  <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"></div>
                  <div class="progress-value"><?php echo $rest ?>%</div>
                <?php } else { ?>
                  <div class="progress-bar <?php echo bg_progress($rest) ?>" role="progressbar" style="width: <?php echo $rest ?>%" aria-valuenow="<?php echo $diffrence->days ?>" aria-valuemin="10" aria-valuemax="<?php echo $total_days->days ?>"><?php echo $rest ?>%</div>
                <?php } ?>
              </div>
            </td>
            <!-- control -->
            <td>
              <a href="?do=edit-company&company-id=<?php echo $company['company_id'] ?>" class="btn btn-success text-capitalize fs-12"><i class="bi bi-pencil-square"></i></a>
              <a href="?do=show-company-details&company-id=<?php echo $company['company_id'] ?>" class="btn btn-outline-primary fs-12 text-capitalize fs-12"><i class="bi bi-eye"></i></a>
              <button type="button" class="btn btn-outline-primary fs-12 renew-license-btn" data-bs-toggle="modal" data-bs-target="#renew_license"><i class="bi bi-arrow-clockwise"></i></button>
              <button type="button" class="btn btn-danger fs-12 delete-btn" data-bs-toggle="modal" data-bs-target="#delete_company"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- renew modal -->
<?php include_once 'renew-license-modal.php' ?>
<?php include_once 'delete-company-modal.php' ?>