<?php
// create an object of User class
$emp_obj = new User();
// count all users
$all_users_counter = $emp_obj->count_records("*", "`users`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
// get all job titles
$all_job_titles = $emp_obj->select_specific_column("*", "`users_job_title`", "WHERE `admin_only` = 0", 'multiple');
// main statement
$main_statement = lang('YOU HAVE', $lang_file) . " " . $all_users_counter . " " . lang('EMPLOYEES', $lang_file) . ", " . lang('DIVIDED INTO', $lang_file) . ":";
?>

<!-- employees reports -->
<p class="lead">
  <!-- display main statement -->
  <span>
    <?php echo $main_statement; ?>
  </span>
<ul>
  <?php foreach ($all_job_titles as $key => $job) { ?>
    <li>
      <?php
      // job name
      $job_name = $job['job_title_name'];
      // count employees of this job
      $job_counter = $emp_obj->count_records("*", "`users`", "WHERE `company_id` = '" . base64_decode($_SESSION['sys']['company_id']) . "' AND `job_title_id` = '" . $job['job_title_id'] . "'");
      ?>
      <span>
        <?php echo $job_counter; ?>
      </span>
      <span>
        <?php echo lang(strtoupper($job_name), 'employees') ?>
      </span>
    </li>
  <?php } ?>
</ul>
</p>