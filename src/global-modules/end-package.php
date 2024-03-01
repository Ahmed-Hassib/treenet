<?php
// create an object of Compnay class
$cmp_obj = new CompanyInfo();
// get company info
$cmp_info = $cmp_obj->get_info();
// get company phones
$cmp_phones = $cmp_obj->get_phones();
// check result
$cmp_info = empty($cmp_info) || $cmp_info == null ? null : $cmp_info[0];
?>
<div class="under-developing" dir="<?php echo $page_dir ?>">
  <!-- section title -->
  <h3 class="h3">
    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
    <?php echo lang('DEAR CUSTOMER') . "، " ?>
  </h3>
  <h4 class="h4">
    <?php echo lang('END PACKAGE ALERT') . "، " . lang('END PACKAGE OFFER') . "، " . lang('END PACKAGE INQUIRE') . "." ?>
  </h4>
  <h4 class="h4">
    <?php echo lang('END PACKAGE SOLUTION') . "." ?>
  </h4>
  <?php if ($cmp_phones != null) { ?>
    <h4 class="h4">
      <?php echo lang('CONTACT US BY PHONES') . ": " ?>
      <?php foreach ($cmp_phones as $key => $phone) { ?>
        <span>
          <?php echo end($cmp_phones)['phone'] == $phone['phone'] ? ', ' : '' ?>
          <?php echo $phone['phone'] ?>
        </span>
      <?php } ?>
    </h4>
  <?php } ?>
  <?php if ($cmp_info != null) { ?>
    <h4 class="h4">
      <?php
      // formate start time
      $start_time = date_format(date_create($cmp_info['start_job_time']), 'h:i');
      // get start time period
      $start_time_period = date_format(date_create($cmp_info['start_job_time']), 'a');
      // formate end time
      $end_time = date_format(date_create($cmp_info['end_job_time']), 'h:i');
      // get end time period
      $end_time_period = date_format(date_create($cmp_info['end_job_time']), 'a');
      // mesaage
      $message = lang('JOB TIME') . ": " . lang('FROM') . " $start_time " . lang(strtoupper($start_time_period)) . " " . lang('TO') . " $end_time " . lang(strtoupper($end_time_period));
      // print message
      echo $message;
      ?>
    </h4>
  <?php } ?>

  <h4 class="h4">
    <?php echo lang('ACCEPT GREETINGS') . ".." ?>
  </h4>


  <!-- home button -->
  <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn btn-primary">
    <i class="bi bi-house-fill"></i>
    <?php echo lang('HOME') ?>
  </a>
</div>