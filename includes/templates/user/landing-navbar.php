<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container" dir="<?php echo $page_dir ?>">
    <a class="navbar-brand" href="<?php echo $conf['app_url'] ?>">
      <img src="<?php echo $treenet_assets ?>resized/treenet.png" width="40px" height="40" alt="<?php echo lang('tree net') ?>">
      <span class="brand-name"><?php echo lang('tree net') ?></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav m-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $conf['app_url'] ?>">
            <i class="bi bi-house-door"></i>
            <?php echo lang('home') ?>
          </a>
        </li>
        <?php
        // create an object of Agents class
        $ag_obj = new Agents();
        // get all agents counter
        $agents_count = $ag_obj->get_all_agents_counter("WHERE ISNULL(deleted_at) AND `is_active` = 1");
        // check counter
        if ($agents_count > 0) {
        ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?php echo $conf['app_url'] ?>#agents">
              <?php echo lang('agents') ?>
            </a>
          </li>
        <?php } ?>
        <?php if (!isset($_SESSION['sys']['username'])) { ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./login.php">
              <?php echo lang('login', 'login') ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-success" href="./signup.php">
              <?php echo lang('start now', 'login') ?>
              <i class="bi bi-chevron-<?php echo $page_dir == 'ltr' ? 'right' : 'left' ?>"></i>
            </a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./login.php">
              <i class="bi bi-grid"></i>
              <?php echo lang('dashboard') ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>