<?php
// check system theme
if ($_SESSION['sys']['system_theme'] == 2) {
  $card_class = 'card-effect';
  $card_position = $_SESSION['sys']['lang'] == "ar" ? "card-effect-right" : "card-effect-left";
}
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="stats">
    <div class="dashboard-content">
      <div class="dashboard-card card card-stat <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "user.svg" ?>" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('DELETED EMPLOYEES', $lang_file), 15, "<br>") ?>
          </h5>
        </div>
        <a href="?do=employees" class="stretched-link text-capitalize"></a>
      </div>
      <div class="dashboard-card card card-stat <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
        <!-- <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "user.svg" ?>" alt=""> -->
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "people.svg" ?>" style="scale: 1.5" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('DELETED CLIENTS', $lang_file), 15, "<br>") ?>
          </h5>
        </div>
        <a href="<?php echo $nav_up_level ?>clients/index.php?do=deletes" class="stretched-link text-capitalize"></a>
      </div>
      <div class="dashboard-card card card-stat  <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "router.svg" ?>" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('DELETED PIECES', $lang_file), 15, "<br>") ?>
          </h5>
        </div>
        <a href="<?php echo $nav_up_level ?>pieces/index.php?do=deletes" class="stretched-link text-capitalize"></a>
      </div>
      <!-- <div class="dashboard-card card card-stat  <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "braces-asterisk.svg" ?>" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('deleted combinations', $lang_file), 15, "<br>") ?>
          </h5>
        </div>
        <a href="?do=combinations" class="stretched-link text-capitalize"></a>
      </div>
      <div class="dashboard-card card card-stat  <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
        <img class="card-img <?php echo $page_dir == 'ltr' ? 'card-img-right' : 'card-img-left' ?>" src="<?php echo $treenet_assets . "flash.svg" ?>" alt="">
        <div class="card-body">
          <h5 class="h5 text-capitalize">
            <?php echo wordwrap(lang('deleted malfunctions', $lang_file), 15, "<br>") ?>
          </h5>
        </div>
        <a href="?do=malfunctions" class="stretched-link text-capitalize"></a>
      </div> -->
    </div>
  </div>
</div>