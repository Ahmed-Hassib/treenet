<footer class="text-center">
  <!-- application name -->
  <div class="mt-1 row">
    <?php $footer_img_name = "treenet.png"; ?>
    <?php $footer_img_path = $treenet_assets . "treenet.png"; ?>
    <?php $footer_resized_img_path = $treenet_assets . "resized/treenet.png"; ?>
    <?php if (file_exists($footer_img_path)) { ?>
      <div class="footer-image">
        <?php $is_resized = resize_img($treenet_assets, $footer_img_name); ?>
        <img loading="lazy" src="<?php echo $is_resized ? $footer_resized_img_path : $footer_img_path ?>" alt="treenet app">
      </div>
    <?php } else { ?>
      <h3 class="fw-bold">
        <?php echo lang('TREE NET SYSTEM') ?>
      </h3>
    <?php } ?>
  </div>
  <?php if (isset($_SESSION['sys']['username'])) { ?>
    <!-- rate app or create a complaint or suggestion -->
    <div class="hstack gap-3" dir="<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>">
      <ul>
        <li>
          <!-- Button trigger modal -->
          <button type="button" data-bs-toggle="modal" data-bs-target="#ratingAppModal">
            <?php echo lang('RATE APP') ?>
          </button>
        </li>
        <!-- <li>
        <a href="<?php echo $nav_up_level ?>comp-sugg/index.php">
          <?php echo lang('COMP & SUGG', 'sugg_comp') ?>
        </a>
      </li> -->
      </ul>
    </div>
  <?php } ?>
  <!-- sponsor and developer name -->
  <div class="row fs-12">
    <p class="text-uppercase">
      <span>
        <?php echo lang('POWERED BY') ?>
      </span>
      <span>
        <?php echo $sponsorCompany ?>
      </span>
      <span>&copy; 2023&nbsp;&bull;&nbsp;<?php echo isset($_SESSION['sys']['username']) ? $_SESSION['sys']['curr_version_name'] : $sys_curr_version ?></span>
    </p>
  </div>
</footer>