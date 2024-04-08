<!-- start sidebar menu -->
<div class="sidebar-menu sidebar-menu-<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?> close">
  <!-- start sidebar menu brand -->
  <div class="sidebar-menu-brand" href="dashboard.php" <?php echo !isset($_SESSION['sys']['username']) ? "style='margin: auto'" : "" ?>>
    <div class="brand-container" style="align-self: center;">
      <?php $brand_img_name = "treenet.png"; ?>
      <?php $brand_img_path = $treenet_assets . "{$brand_img_name}"; ?>
      <?php $brand_resized_img_path = $treenet_assets . "resized/{$brand_img_name}"; ?>
      <?php if (file_exists($brand_img_path)) { ?>
        <?php $is_resized = resize_img($treenet_assets, $brand_img_name); ?>
        <img class="brand-img" loading="lazy" src="<?php echo $is_resized ? $brand_resized_img_path : $brand_img_path ?>" alt="Tree Net App ">
      <?php } else { ?>
        <h3 class="fw-bold sidebar-menu-logo-name">
          <?php echo lang('SYS TREE') ?>
        </h3>
      <?php } ?>
    </div>
    <!-- close icon displayed in small screens -->
    <span class="close-btn"><i class="bi bi-x"></i></span>
  </div>
  <!-- end sidebar menu brand -->
  <!-- start sidebar menu content -->
  <ul class="nav-links">
    <!-- start setting nav link -->
    <?php if (isset($_SESSION['sys']['username'])) { ?>
      <!-- start profile details nav link -->
      <li class="profile-details">
        <!-- start profile details -->
        <a href="">
          <!-- href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo $_SESSION['sys']['UserID']; ?>"> -->
          <div class="profile-content">
            <?php $profile_img_name = empty($_SESSION['sys']['profile_img']) || !file_exists($uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $_SESSION['sys']['profile_img']) ? "male-avatar.svg" : base64_decode($_SESSION['sys']['company_id']) . "/" . $_SESSION['sys']['profile_img']; ?>
            <?php $profile_img_path = $uploads . "employees-img/" . $profile_img_name; ?>
            <img loading="lazy" src="<?php echo $profile_img_path ?>" class="profile-img">
          </div>
          <div class="name-job">
            <div class="profile-name">
              <?php echo $_SESSION['sys']['username'] ?>
            </div>
            <?php if (!empty($_SESSION['sys']['job_title_id'])) { ?>
              <div class="profile-job">
                <?php
                $db_obj = new Database();
                // get job title
                $job_title = $db_obj->select_specific_column("`job_title_name`", "`users_job_title`", "WHERE `job_title_id` = " . base64_decode($_SESSION['sys']['job_title_id']))['job_title_name'];
                // display job title
                echo lang($job_title);
                ?>
              </div>
            <?php } ?>
          </div>
        </a>
        <!-- end profile details -->
      </li>
      <!-- start profile details nav link -->
    <?php } ?>
    <!-- start dashboard page link -->
    <li>
      <a href="<?php echo $nav_up_level ?>dashboard/index.php">
        <i class="bi bi-grid"></i>
        <span class="link-name">
          <?php echo lang('DASHBOARD') ?>
        </span>
      </a>
      <!-- start blank sub menu -->
      <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $nav_up_level ?>dashboard/index.php">
            <span class="link-name">
              <?php echo lang('DASHBOARD') ?>
            </span>
          </a>
        </li>
      </ul>
      <!-- end blank sub menu -->
    </li>
    <!-- end dashboard page link -->

    <!-- start employee nav link -->
    <li>
      <!-- start link containing sub menu -->
      <div class="icon-link">
        <section>
          <i class="bi bi-building"></i>
          <span class="link-name">
            <?php echo lang('THE COMPANIES', 'companies_root') ?>
          </span>
        </section>
        <i class="bi bi-chevron-down"></i>
      </div>
      <!-- end link containing sub menu -->
      <!-- start sub menu -->
      <ul class="sub-menu">
        <li>
          <a href="<?php echo $nav_up_level ?>companies/index.php?do=list">
            <span class="link-name">
              <?php echo lang('LIST', 'companies_root') ?>
            </span>
          </a>
        </li>
      </ul>
      <!-- end sub menu -->
    </li>
    <!-- end employee nav link -->

    <!-- start setting nav link -->
    <li>
      <!-- <a href="<?php echo $nav_up_level ?>settings/index.php">
        <i class="bi bi-gear"></i>
        <span class="link-name">
          <?php echo lang('SETTINGS') ?>
        </span>
      </a> -->
      <!-- start blank sub menu -->
      <!-- <ul class="sub-menu blank">
        <li>
          <a href="<?php echo $nav_up_level ?>settings/index.php">
            <span class="link-name">
              <?php echo lang('SETTINGS') ?>
            </span>
          </a>
        </li>
      </ul> -->
      <!-- end blank sub menu -->
    </li>
    <li>
      <a href="<?php echo $src ?>logout.php">
        <i class="bi bi-box-arrow-right"></i>
        <span class="link-name">
          <?php echo lang('LOGOUT') ?>
        </span>
      </a>
    </li>
  </ul>
  <!-- end sidebar menu content -->
</div>
<!-- end sidebar menu -->

<div class="top-navbar top-navbar-<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
  <div class="top-navbar-content">
    <i class="bi bi-list sidebar-menubtn"></i>

    <?php if (isset($possible_back) && $possible_back == true) { ?>
      <a href="<?php echo $nav_up_level ?>requests/index.php?do=update-session&user-id=<?php echo $_SESSION['sys']['UserID'] ?>" class="btn btn-outline-dark refresh-session py-1 fs-12 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> mx-3">
        <span>
          <?php echo lang('REFRESH SESSION') ?>
        </span>
      </a>
    <?php } ?>
  </div>
</div>

<div class="main-content">