<footer class="text-center">
  <!-- application name -->
  <div class="mt-1 row">
    <?php $footer_img_name = "treenet.png"; ?>
    <?php $footer_img_path = $treenet_assets . "treenet.png"; ?>
    <?php $footer_resized_img_path = $treenet_assets . "resized/treenet.png"; ?>
    <?php if (file_exists($footer_img_path)) { ?>
      <div class="footer-image">
        <?php $is_resized = resize_img($treenet_assets, $footer_img_name); ?>
        <!-- <?php $is_resized = false; ?> -->
        <img loading="lazy" src="<?php echo $is_resized ? $footer_resized_img_path : $footer_img_path ?>" alt="treenet app ">
      </div>
    <?php } else { ?>
      <h3 class="fw-bold">
        <?php echo lang('SYS TREE') ?>
      </h3>
    <?php } ?>
  </div>

  <!-- sponsor and developer name -->
  <div class="row fs-12">
    <p class="text-uppercase">
      <span>
        <?php echo lang('POWERED BY') ?>
      </span>
      <span>
        <?php echo $sponsorCompany ?>
      </span>
      <span>&copy; 2023</span>
    </p>
  </div>
</footer>