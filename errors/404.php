<div class="container" dir="<?php echo $page_dir ?>">
  <div class="page-error-container">
    <header class="page-error-header">
      <h1 class="h1 text-uppercase fw-bold"><?php echo lang('page not found') ?></h1>
      <p class="lead">oops! the page you want not found, you can try another or return home.</p>
    </header>
    <img src="<?php echo $treenet_assets ?>page-not-found.svg" class="error-img" alt="404">
    <a href="<?php echo $target_url ?>" class="btn btn-primary">
      <i class="bi bi-house-door"></i>
      <?php echo lang('HOME') ?>
    </a>
  </div>
</div>