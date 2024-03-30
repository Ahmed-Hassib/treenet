<main class="mt-5" dir="<?php echo $page_dir ?>">
  <!-- landing section -->
  <div class="landing-section animate-section" data-nav-link="0">
    <div class="container landing-container">
      <div class="landing-content">
        <div class="landing-content__content">
          <h1 class="h1 text-capitalize">
            <?php echo $page_dir == 'rtl' ? wordwrap(lang('home desc', $lang_file), 40, "<br>") : lang('home desc', $lang_file) ?>
          </h1>
          <h3 class="h3 text-capitalize">
            <?php echo lang('TREENET') . " " . lang('TREENET SPONSOR', 'description') . " <br>" . lang('SPONSOR') ?>
          </h3>
          <p class="lead">
            <?php echo lang('TREENET ADV DESC', 'description') ?>
          </p>
          <div class="my-3 hstack gap-3">
            <a href="https://wa.me/+201016100346" target="_blank">
              <i class="bi bi-whatsapp"></i>
              <?php echo lang('contact us on whatsapp') ?>
            </a>
            <?php if (!isset($_SESSION['sys']['username'])) { ?>
              <a class="py-2 nav-link not-nav-link btn btn-outline-success" href="./signup.php">
                <?php echo lang('start now', 'login') ?>
                <i class="bi bi-chevron-<?php echo $page_dir == 'ltr' ? 'right' : 'left' ?>"></i>
              </a>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="landing-carousel carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?php echo $treenet_assets ?>treenet.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- features section -->
  <div class="features-section animate-section" data-nav-link="1" id="features">
    <div class="container">
      <header class="section-header" data-increased="10">
        <p class="lead">
        <div class="avatars-row">
          <span class="avatar">
            <img src="<?php echo $treenet_assets ?>avatar_1.webp" width="40">
          </span>
          <span class="avatar">
            <img src="<?php echo $treenet_assets ?>avatar_2.png" width="40">
          </span>
          <span class="avatar">
            <img src="<?php echo $treenet_assets ?>avatar_3.png" width="40">
          </span>
        </div>
        <?php
        // create an object of User class
        $emp_obj = new User();
        // get all users counters
        $users_count = $emp_obj->get_all_users_counter();
        // create an object of Company class
        $company_obj = new Company();
        // get all companies counters
        $companies_count = $company_obj->get_all_companies_counter();
        // total = users + companies;
        $total_counter = $users_count + $companies_count;
        // display the result
        echo number_format($total_counter) . "+ " . lang('users and companies uses system', $lang_file) . " " . lang('tree net') ?>
        </p>
        <h2 class="mt-3 h2">
          <?php echo wordwrap(ucfirst(lang('treenet production ready', $lang_file)), 50, "<br>") ?>
        </h2>
        <h3 class="h3"><?php echo ucfirst(lang('know features', $lang_file)) ?></h3>
      </header>
      <div class="mt-5 features-container">
        <?php $features = include_once "{$src}landing/features.php"; ?>
        <?php foreach ($features as $key => $feature) { ?>
          <div class="features-row" data-increased="<?php echo $feature['increased'] ?>">
            <div class="feature-content">
              <header class="feature-header">
                <h3 class="h3">
                  <?php echo ucfirst(lang($feature['title'], $lang_file)) ?>
                  <?php if ($feature['is_developing']) { ?>
                    <span class="badge bg-primary"><?php echo ucfirst(lang('under developing')) ?></span>
                  <?php } ?>
                </h3>
              </header>
              <div class="feature-body">
                <p class="lead"><?php echo ucfirst(lang($feature['content'], $lang_file)) ?></p>
              </div>
            </div>
            <?php if (!is_null($feature['media'])) { ?>
              <div class="feature-media">
                <?php if ($feature['media_type'] == 'img') { ?>
                  <img src="<?php echo $treenet_assets ?>landing/<?php echo $feature['media'] ?>">
                <?php } else { ?>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <!-- agents section -->
  <div class="agents-section animate-section" data-nav-link="2" id="agents">
    <div class="container">
      <header class="section-header" data-increased="2500">
        <p class="lead">
        <div class="avatars-row">
          <span class="avatar">
            <img src="<?php echo $treenet_assets ?>avatar_1.webp" width="40">
          </span>
          <span class="avatar">
            <img src="<?php echo $treenet_assets ?>avatar_2.png" width="40">
          </span>
          <span class="avatar">
            <img src="<?php echo $treenet_assets ?>avatar_3.png" width="40">
          </span>
        </div>
        <?php
        // get all agents info
        $agents_info = $ag_obj->get_all_agents();
        // display the result
        echo number_format($agents_count) . "+ " . lang('agents recommend system', $lang_file) . " " . lang('tree net') ?>
        </p>
        <h2 class="mt-3 h2">
          <span><?php echo wordwrap(ucfirst(lang('become agent', $lang_file)), 50, "<br>") ?></span><br>
        </h2>
        <h3 class="h3"><?php echo ucfirst(lang('know agents', $lang_file)) ?></h3>
      </header>
      <!-- agents info -->
      <div class="mt-5 agents-container">
        <?php $country_obj = new Countries(); // create an object of Country class 
        ?>
        <?php foreach ($agents_info as $key => $agent) { ?>
          <div class="agents-container__content">
            <div class="agents-img-container">
              <img src="<?php echo $treenet_assets ?>agents/<?php echo $agent['logo'] ?>" class="agents-img">
            </div>
            <div class="agents-content">
              <h3 class="h3 text-uppercase fw-bold"><?php echo $agent['company_name'] ?></h3>
              <p class="mb-0 lead text-capitalize">
                <?php echo $agent['agent_name'] ?><br>
              </p>
              <p class="mb-0 lead text-capitalize">
                <?php
                // get country id
                $country_id = $agent['country_id'];
                // get country data
                $country_data = $country_obj->get_country($country_id);
                ?>

                <img src="<?php echo $treenet_assets ?>/countries_flags/4x3/<?php echo $country_data['flag'] ?>.svg" width="30" alt="<?php echo $page_dir == 'ltr' ? $country_data['country_name_en'] : $country_data['country_name_ar'] ?>">
                <span><?php echo $page_dir == 'ltr' ? $country_data['country_name_en'] : $country_data['country_name_ar'] ?></span>
              </p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>


<div class="scroll-top-btn">
  <i class="bi bi-chevron-up"></i>
</div>