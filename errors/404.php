<div class="container" dir="<?php echo $page_dir ?>">
  <div class="page-error-container">
    <header class="page-error-header">
      <h1 class="h1 text-uppercase fw-bold"><?php echo lang('page not found', $lang_file) ?></h1>
      <p class="lead"><?php echo wordwrap(lang('404 warning', $lang_file), 100, "<br>") ?></p>
    </header>
    <img src="<?php echo $treenet_assets ?>page-not-found.svg" class="error-img" alt="404">
    <a href="<?php echo $target_url ?>" class="btn btn-primary">
      <i class="bi bi-house-door"></i>
      <?php echo lang('HOME') ?>
    </a>
  </div>
</div>