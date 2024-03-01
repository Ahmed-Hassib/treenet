<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize ">
      <?php echo lang('SYSTEM LANG', $lang_file) ?>
    </h5>
    <hr />
  </div>
  <!-- language form -->
  <form action="?do=change-lang" method="POST">
    <!-- hidden input for employee id -->
    <input type="hidden" name="id" value="<?php echo $_SESSION['sys']['UserID'] ?>">
    <!-- strat language field -->
    <div class="mb-3 language-container">
      <div class="form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <select class="form-select" name="language" id="language">
          <option value="default" disabled>
            <?php echo lang('SELECT LANG') ?>
          </option>
          <option value="<?php echo base64_encode(0) ?>" selected>
            <?php echo lang('AR') ?>
          </option>
          <option value="<?php echo base64_encode(1) ?>" disabled>
            <?php echo lang('EN') . "&nbsp;&dash;&nbsp;" . lang('UNDER DEVELOPING') ?></span>
          </option>
        </select>
        <label for="language">
          <?php echo lang('LANG') ?>
        </label>
      </div>
    </div>
    <!-- end language field -->
    <!-- strat submit -->
    <div class="hstack gap-3">
      <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12 py-1"><i
          class="bi bi-check-all me-1"></i>&nbsp;
        <?php echo lang('SAVE') ?>
      </button>
    </div>
    <!-- end submit -->
  </form>
</div>