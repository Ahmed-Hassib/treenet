<!-- START LANDING -->
<div class="landing">
  <div class="container">
    <div class="text">
      <h1>
        <span>
          <?php echo lang('WELCOME TO', 'index') ?>
        </span>
        <span class="badge bg-warning p-2">
          <?php echo lang('SERVICES') ?>
        </span>
        <span>
          <?php echo lang('SPONSOR') ?>
        </span>
      </h1>
      <p>
        <span class="badge bg-primary">
          <?php echo lang('TREE NET') ?>
        </span>
        <span>
          <?php echo '&nbsp;' . lang('TREENET DESC', $lang_file) ?>
        </span>
      </p>
    </div>
  </div>
  <a href="#abstract" class="go-down">
    <i class="bi bi-chevron-double-down"></i>
  </a>
</div>
<!-- END LANDING -->

<div class="abstract" id="abstract" dir="<?php echo $page_dir ?>">
  <h2 class="main-title">
    <?php echo lang('ABSTRACT', $lang_file) ?>
  </h2>
  <div class="container">
    <div class="clearfix">
      <div class="col-sm-12 col-md-4 float-md-start mb-3 me-md-3">
        <div class="overflow-hidden">
          <img loading="lazy" src="<?php echo $treenet_assets ?>treenet.jpg" class="mb-2 w-100" style="scale: 1.5;" alt="...">
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4">
            <?php echo lang('SERVICE NAME', $lang_file) ?>
          </h4>
        </div>
        <div class="section-content">
          <p class="lead">
            <?php echo lang('TREENET NAME DESC', $lang_file) ?>.
          </p>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4">
            <?php echo lang('SERVICE ADVANTAGE', $lang_file) ?>
          </h4>
        </div>
        <div class="section-content">
          <p class="lead">
            <?php echo lang('TREENET ADV DESC', $lang_file) . " " . lang('CHARACTERIZED BY') . ":" ?>
          </p>
          <ul>
            <?php
            // array of service advantages
            $service_advantages = ['DRAW NETWORK AND CAMERAS', 'IDENTIFY ALT SOURCE', 'DEVICES STATUS', 'ALERTS AND WARNINGS', 'REMOTE ACCESS', 'BACKUP', 'DEVICES REPORTS', 'CLIENTS REPORTS', 'COMPLAINTS AND MAINTENANCE MANAGEMENT', 'BUSINESS DOCUMENTATION', 'DATES MATTERS', 'CUSTOMERS RATES', 'CONTROLLING EMP PERMISSIONS', 'DATA ENTRY'];
            // loop on service advantages
            foreach ($service_advantages as $key => $advantage) {
              ?>
              <li>
                <?php echo lang($advantage, $lang_file) ?>:
                <ul>
                  <li>
                    <?php echo lang($advantage . ' DESC', $lang_file) ?>
                  </li>
                </ul>
              </li>
            <?php } ?>
          </ul>

          <p class="lead">
            <?php echo lang('TREENET ADV DESC 2', $lang_file) ?>
          </p>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4">
            <?php echo lang('CURRENT VERSION', $lang_file) ?>
          </h4>
        </div>
        <div class="section-content">
          <p class="lead">
            <?php echo $sys_curr_version ?>
          </p>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4">
            <?php echo lang('DEVELOPMENT PROCESS', $lang_file) ?>
          </h4>
        </div>
        <div class="section-content">
          <p class="lead">
            <?php echo lang('DEVELOPMENT PROCESS DESC', $lang_file) ?>
          </p>
        </div>
      </div>


      <div class="section">
        <div class="section-header">
          <h4 class="h4">
            <?php echo lang('TAKE TRIAL VERSION', $lang_file) ?>
          </h4>
        </div>
        <div class="section-content">
          <ul>
            <li>
              <p class="lead">
                <?php echo lang('VISIT SYSTEM LOGIN', $lang_file) ?>
                <a style="text-decoration: underline;" href="<?php echo $src ?>login.php" target="_blank">
                  <?php echo lang('FROM HERE') ?>
                  <i style="font-size: 16px" class="bi bi-arrow-up-left-square"></i>
                </a>
              </p>
            </li>
            <li>
              <p class="lead">
                <span>
                  <?php echo lang('VISIT SYSTEM SIGNUP', $lang_file) ?>&nbsp;
                </span>
                <a style="text-decoration: underline;" href="<?php echo $src ?>signup.php" target="_blank">
                  <?php echo lang('FROM HERE') ?>&nbsp;<i style="font-size: 16px"
                    class="bi bi-arrow-up-left-square"></i>
                </a>
                <span>
                  &nbsp;
                  <?php echo lang('THEN FOLOOW THESE STEPS') ?>
                </span>
              </p>

              <ul style="list-style: circle;">
                <li>
                  <?php echo lang('ADD COMPANY NAME', $lang_file) ?>
                  <!-- warnig messages -->
                  <span class="badge bg-danger">
                    <?php echo lang('DON`T WRITE ANY SPECIAL CHARACHTERS', $lang_file) ?>
                  </span>
                  <span class="badge bg-danger">
                    <?php echo lang('DON`T WRITE ANY NUMBERS', $lang_file) ?>
                  </span>
                  <span class="badge bg-danger">
                    <?php echo lang('DON`T WRITE ANY WHITE SPACES', $lang_file) ?>
                  </span>
                </li>
                <li>
                  <?php echo lang('SAVE COMPANY CODE', $lang_file) ?>
                </li>
                <li>
                  <?php echo lang('ENTER THE MANAGER NAME', $lang_file) ?>
                </li>
                <li>
                  <?php echo lang('ENTER MANAGER PHONE', $lang_file) ?>
                </li>
                <li>
                  <?php echo lang('ENTER ADMIN FULL NAME', $lang_file) ?>
                </li>
                <li>
                  <?php echo lang('CHOOSE ADMIN GENDER', $lang_file) ?>
                </li>
                <li>
                  <?php echo lang('ENTER ADMIN USERNAME TO LOGIN', $lang_file) ?>
                </li>
                <li>
                  <?php echo lang('ENTER ADMIN PASSWORD TAKING INTO ACCOUNT DON`T SHARE IT', $lang_file) ?>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>