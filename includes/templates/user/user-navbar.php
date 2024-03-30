<!-- start sidebar menu -->
<div class="sidebar-menu sidebar-menu-<?php echo $page_dir == 'rtl' ? 'right' : 'left' ?>">
  <!-- start sidebar menu brand -->
  <div class="sidebar-menu-brand" href="dashboard.php" <?php echo !isset($_SESSION['sys']['username']) ? "style='margin: auto'" : "" ?>>
    <div class="brand-container" style="align-self: center;">
      <?php $brand_img_name = "treenet.png"; ?>
      <?php $brand_img_path = "{$treenet_assets}{$brand_img_name}"; ?>
      <?php $brand_resized_img_path = "{$treenet_assets}resized/{$brand_img_name}"; ?>
      <?php if (file_exists($brand_img_path)) { ?>
        <?php $is_resized = resize_img("{$treenet_assets}", $brand_img_name); ?>
        <img class="brand-img" loading="lazy" src="<?php echo $is_resized ? $brand_resized_img_path : $brand_img_path ?>" alt="Tree Net App ">
      <?php } else { ?>
        <h3 class="fw-bold sidebar-menu-logo-name">
          <?php echo lang('SYS TREE') ?>
        </h3>
      <?php } ?>
    </div>
    <!-- close icon displayed in small screens -->
    <span class="close-btn close-btn-<?php echo $page_dir == 'ltr' ? 'right' : 'left' ?>"><i class="bi bi-x"></i></span>
  </div>
  <!-- end sidebar menu brand -->
  <!-- start sidebar menu content -->
  <ul class="nav-links">
    <!-- start user profile link -->
    <?php if (isset($_SESSION['sys']['username'])) { ?>
      <!-- start profile details nav link -->
      <li class="profile-details">
        <!-- start profile details -->
        <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo $_SESSION['sys']['UserID']; ?>">
          <div class="profile-content">
            <?php $profile_img_name = empty($_SESSION['sys']['profile_img']) || !file_exists($uploads . "employees-img/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $_SESSION['sys']['profile_img']) ? "male-avatar.svg" : base64_decode($_SESSION['sys']['company_id']) . "/" . $_SESSION['sys']['profile_img']; ?>
            <?php $profile_img_path = $uploads . "employees-img/" . $profile_img_name; ?>
            <img loading="lazy" src="<?php echo $profile_img_path ?>" class="profile-img">
          </div>
          <div class="name-job">
            <div class="profile-name">
              <?php echo $_SESSION['sys']['username'] ?>
            </div>
          </div>
        </a>
        <!-- end profile details -->
      </li>
      <!-- start profile details nav link -->
    <?php } ?>
    <!-- start dashboard page link -->
    <li class="<?php echo get_page_active_link('dashboard') ? 'active' : NULL ?>">
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

    <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
      <!-- start employee nav link -->
      <li class="<?php echo get_page_active_link('employees') ? 'active show-menu' : '' ?>">
        <!-- start link containing sub menu -->
        <div class="icon-link">
          <section>
            <i class="bi bi-people"></i>
            <span class="link-name">
              <?php echo lang('EMPLOYEES') ?>
            </span>
          </section>
          <i class="bi bi-chevron-down"></i>
        </div>
        <!-- end link containing sub menu -->
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['user_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>employees/index.php">
                <span class="link-name">
                  <?php echo lang('LIST', 'employees') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['user_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>employees/index.php?do=add-new-user">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'employees') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
            <hr class="m-1">
            <li>
              <a href="<?php echo $nav_up_level ?>employees/index.php?do=deletes">
                <span class="link-name">
                  <?php echo lang('deletes') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end employee nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['dir_show'] == 1) { ?>
      <!-- start directions nav link -->
      <li class="<?php echo get_page_active_link('directions') ? 'active show-menu' : '' ?>">
        <div class="icon-link">
          <section>
            <i class="bi bi-diagram-3"></i>
            <span class="link-name">
              <?php echo lang('DIRECTIONS') ?>
            </span>
          </section>
          <i class="bi bi-chevron-down"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['dir_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>directions/index.php">
                <span class="link-name">
                  <?php echo lang('LIST', "directions") ?>
                </span>
              </a>
            </li>
            <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
              <li>
                <a href="<?php echo $nav_up_level ?>directions/index.php?do=direction-map">
                  <span class="link-name">
                    <?php echo lang('DIRECTIONS MAP') ?>
                    <span class="badge bg-danger p-2 d-inline-block"></span>
                  </span>
                </a>
              </li>
            <?php } ?>
          <?php } ?>
          <?php if ($_SESSION['sys']['dir_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <hr class="m-1">
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#addNewDirectionModal">
                <span class="link-name">
                  <?php echo lang('ADD NEW', "directions") ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>directions/index.php?do=upload">
                <span class="link-name">
                  <?php echo wordwrap(lang('upload data by file', "directions"), "45", "<br>", true) ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end directions nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['pcs_show'] == 1 || $_SESSION['sys']['pcs_add'] == 1) { ?>
      <!-- start pieces nav link -->
      <li class="<?php echo get_page_active_link('pieces') ? 'active show-menu' : '' ?>">
        <div class="icon-link">
          <section>
            <i class="bi bi-router"></i>
            <span class="link-name">
              <?php echo lang('PIECES') ?>
            </span>
          </section>
          <i class="bi bi-chevron-down"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php">
                <span class="link-name">
                  <?php echo lang('DASHBOARD') ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?do=show-all-pieces">
                <span class="link-name">
                  <?php echo lang('LIST', 'pieces') ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?do=devices-companies">
                <span class="link-name">
                  <?php echo lang('PCS TYPES', 'pieces') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['pcs_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?do=add-new-piece">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'pieces') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
            <hr class="m-1">
            <li>
              <a href="<?php echo $nav_up_level ?>pieces/index.php?do=deletes">
                <span class="link-name">
                  <?php echo lang('deletes') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end pieces nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['connection_add'] == 1 || $_SESSION['sys']['connection_show'] == 1) { ?>
      <!-- start dashboard page link -->
      <li class="<?php echo get_page_active_link('connection') ? 'active show-menu' : '' ?>">
        <div class="icon-link">
          <section>
            <i class="bi bi-hdd-network"></i>
            <span class="link-name">
              <?php echo lang('CONNECTION TYPES') ?>
            </span>
          </section>
          <i class="bi bi-chevron-down"></i>
        </div>
        <!-- start blank sub menu -->
        <ul class="sub-menu">
          <li>
            <a href="<?php echo $nav_up_level ?>pieces-connection/index.php">
              <span class="link-name">
                <?php echo lang('DASHBOARD') ?>
              </span>
            </a>
          </li>
          <?php if ($_SESSION['sys']['connection_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#addNewPieceConnTypeModal">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'pcs_conn') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php
          // create an object of PiecesConn class
          $pcs_conn_obj = !isset($pcs_conn_obj) ? new PiecesConn() : $pcs_conn_obj;
          // get all connections 
          $conn_data_types = $pcs_conn_obj->count_records("`id`", "`connection_types`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
          ?>
          <?php if ($_SESSION['sys']['connection_update'] == 1 && $conn_data_types > 0 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#editPieceConnTypeModal">
                <span class="link-name">
                  <?php echo lang('EDIT CONN', 'pcs_conn') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['connection_delete'] == 1 && $conn_data_types > 0 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <hr class="m-1">
            <li>
              <a href="#" data-bs-toggle="modal" data-bs-target="#deletePieceConnTypeModal">
                <span class="link-name">
                  <?php echo lang('DELETE CONN', 'pcs_conn') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end blank sub menu -->
      </li>
      <!-- end dashboard page link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['clients_show'] == 1 || $_SESSION['sys']['clients_add'] == 1) { ?>
      <!-- start clients nav link -->
      <li class="<?php echo get_page_active_link('clients') ? 'active show-menu' : '' ?>">
        <div class="icon-link">
          <section>
            <i class="bi bi-people"></i>
            <span class="link-name">
              <?php echo lang('CLIENTS') ?>
            </span>
          </section>
          <i class="bi bi-chevron-down"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>clients/index.php">
                <span class="link-name">
                  <?php echo lang('DASHBOARD') ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>clients/index.php?do=show-all-clients">
                <span class="link-name">
                  <?php echo lang('LIST', 'clients') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['clients_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>clients/index.php?do=add-new-client">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'clients') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['clients_show'] == 1) { ?>
            <hr class="m-1">
            <li>
              <a href="<?php echo $nav_up_level ?>clients/index.php?do=deletes">
                <span class="link-name">
                  <?php echo lang('deletes') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end clients nav link -->
    <?php } ?>

    <?php if ($_SESSION['sys']['mal_show'] == 1 || $_SESSION['sys']['mal_add'] == 1) { ?>
      <!-- start malfunctions nav link -->
      <li class="<?php echo get_page_active_link('malfunctions') ? 'active show-menu' : '' ?>">
        <div class="icon-link">
          <section>
            <i class="bi bi-lightning-charge"></i>
            <span class="link-name">
              <?php echo lang('MALS') ?>
            </span>
          </section>
          <i class="bi bi-chevron-down"></i>
        </div>
        <!-- start sub menu -->
        <ul class="sub-menu">
          <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>malfunctions/index.php">
                <span class="link-name">
                  <?php echo lang('DASHBOARD') ?>
                </span>
              </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['sys']['mal_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
            <li>
              <a href="<?php echo $nav_up_level ?>malfunctions/index.php?do=add-new-malfunction">
                <span class="link-name">
                  <?php echo lang('ADD NEW', 'malfunctions') ?>
                </span>
              </a>
            </li>
          <?php } ?>
        </ul>
        <!-- end sub menu -->
      <?php } ?>
      </li>
      <!-- end malfunctions nav link -->

      <?php if ($_SESSION['sys']['comb_show'] == 1 || $_SESSION['sys']['comb_add'] == 1) { ?>
        <!-- start combinations nav link -->
        <li class="<?php echo get_page_active_link('combinations') ? 'active show-menu' : '' ?>">
          <div class="icon-link">
            <section>
              <i class="bi bi-braces-asterisk"></i>
              <span class="link-name">
                <?php echo lang('COMBS') ?>
              </span>
            </section>
            <i class="bi bi-chevron-down"></i>
          </div>
          <!-- start sub menu -->
          <ul class="sub-menu">
            <?php if ($_SESSION['sys']['comb_show'] == 1) { ?>
              <li>
                <a href="<?php echo $nav_up_level ?>combinations/index.php">
                  <span class="link-name">
                    <?php echo lang('DASHBOARD') ?>
                  </span>
                </a>
              </li>
            <?php } ?>
            <?php if ($_SESSION['sys']['comb_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
              <li>
                <a href="<?php echo $nav_up_level ?>combinations/index.php?do=add-new-combination">
                  <span class="link-name">
                    <?php echo lang('ADD NEW', 'combinations') ?>
                  </span>
                </a>
              </li>
            <?php } ?>
            <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
              <hr class="m-1">
              <li>
                <a href="<?php echo $nav_up_level ?>combinations/index.php?do=deletes">
                  <span class="link-name">
                    <?php echo lang('deletes') ?>
                  </span>
                </a>
              </li>
            <?php } ?>
          </ul>
          <!-- end sub menu -->
        </li>
        <!-- end combinations nav link -->
      <?php } ?>
      <?php if (base64_decode($_SESSION['sys']['job_title_id']) == 1) { ?>
        <!-- start services nav link -->
        <li class="<?php echo get_page_active_link('services') ? 'active' : NULL ?>">
          <div class="icon-link">
            <a href="<?php echo $nav_up_level ?>services/index.php">
              <i class="bi bi-tools"></i>
              <span class="link-name">
                <?php echo lang('THE SERVICES') ?>
              </span>
            </a>
          </div>
          <!-- start sub menu -->
          <ul class="sub-menu blank">
            <li>
              <a href="<?php echo $nav_up_level ?>services/index.php">
                <span class="link-name">
                  <?php echo lang('THE SERVICES') ?>
                </span>
              </a>
            </li>
          </ul>
          <!-- end sub menu -->
        </li>
        <!-- end services nav link -->
      <?php } ?>
      <?php if (base64_decode($_SESSION['sys']['job_title_id']) == 1) { ?>
        <!-- start pricing nav link -->
        <li class="<?php echo get_page_active_link('payments') ? 'active show-menu' : '' ?>">
          <div class="icon-link">
            <section>
              <i class="bi bi-currency-dollar"></i>
              <span class="link-name">
                <?php echo lang('PAYMENTS') ?>
              </span>
            </section>
            <i class="bi bi-chevron-down"></i>
          </div>
          <!-- start sub menu -->
          <ul class="sub-menu">
            <li>
              <a href="<?php echo $nav_up_level ?>payments/index.php?do=pricing">
                <span class="link-name">
                  <?php echo lang('PRICING PLANS') ?>
                </span>
              </a>
            </li>
            <li>
              <a href="<?php echo $nav_up_level ?>payments/index.php?do=transactions">
                <span class="link-name">
                  <?php echo lang('TRANSACTIONS') ?>
                </span>
              </a>
            </li>
          </ul>
          <!-- end sub menu -->
        </li>
        <!-- end pricing nav link -->
      <?php } ?>
      <!-- start temporary deletes nav link -->
      <li class="<?php echo get_page_active_link('deletes') ? 'active' : NULL ?>">
        <a href="<?php echo $nav_up_level ?>deletes/index.php">
          <i class="bi bi-trash"></i>
          <span class="link-name">
            <?php echo lang('TRASH') ?>
          </span>
        </a>
        <!-- start sub menu -->
        <ul class="sub-menu blank">
          <li>
            <a href="<?php echo $nav_up_level ?>deletes/index.php">
              <span class="link-name">
                <?php echo lang('dashboard') ?>
              </span>
            </a>
          </li>
        </ul>
        <!-- end sub menu -->
      </li>
      <!-- end temporary deletes nav link -->
      <?php if (base64_decode($_SESSION['sys']['job_title_id']) == 1 && 0) { ?>
        <!-- start report nav link -->
        <li>
          <a href="<?php echo $nav_up_level ?>reports/index.php">
            <i class="bi bi-graph-up"></i>
            <span class="link-name">
              <?php echo lang('REPORTS') ?>
            </span>
          </a>
          <!-- start blank sub menu -->
          <ul class="sub-menu blank">
            <li>
              <a href="<?php echo $nav_up_level ?>reports/index.php">
                <span class="link-name">
                  <?php echo lang('REPORTS') ?>
                </span>
              </a>
            </li>
          </ul>
          <!-- end blank sub menu -->
        </li>
      <?php } ?>
      <!-- start setting nav link -->
      <li class="<?php echo get_page_active_link('settings') ? 'active' : NULL ?>">
        <a href="<?php echo $nav_up_level ?>settings/index.php">
          <i class="bi bi-gear"></i>
          <span class="link-name">
            <?php echo lang('SETTINGS') ?>
          </span>
        </a>
        <!-- start blank sub menu -->
        <ul class="sub-menu blank">
          <li>
            <a href="<?php echo $nav_up_level ?>settings/index.php">
              <span class="link-name">
                <?php echo lang('SETTINGS') ?>
              </span>
            </a>
          </li>
        </ul>
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

  <!-- advertisements small card -->
  <div class="small-card-adv card card-adv-light">
    <div class="card-img-top-container card-img-top-container-light">
      <img src="<?php echo $treenet_assets . "wallet-arrow-left.svg" ?>" alt="">
    </div>
    <div class="card-body">
      <h5 class="card-title"><?php echo lang('LIKE TO BE A PARTNER') ?></h5>
    </div>

    <div class="card-link-container" style="border-radius: 20px;">
      <div class="card-link-container_content card-link-container_content-light">
        <a href="<?php echo $nav_up_level ?>dashboard/index.php?do=contact-us" class="card-link">
          <?php $contact_stmt = explode(' ', lang('CONTACT US NOW')); ?>
          <span class="fs-12"><?php echo $contact_stmt[0] . " " . $contact_stmt[1] ?></span><br>
          <span><?php echo $contact_stmt[2] ?></span>
        </a>
      </div>
    </div>
  </div>
</div>
<!-- end sidebar menu -->

<div class="top-navbar top-navbar-<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
  <div class="top-navbar-content">
    <i class="bi bi-list sidebar-menubtn"></i>
    <?php if (isset($_SESSION['sys']['isTrial']) && $_SESSION['sys']['isTrial'] == 1) { ?>
      <span class="<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?> mx-3">
        <span class="badge bg-danger">
          <?php echo lang("TRIAL") ?>
        </span>
      </span>
    <?php } ?>

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