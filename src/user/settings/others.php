<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize "><?php echo lang('OTHER', $lang_file) ?></h5>
    <hr />
  </div>

  <div class="mb-1">
    <form action="?do=others" method="POST" id="other-settings">
      <!-- ping counter -->
      <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <input class="form-control" type="number" name="ping-counter" id="ping-counter" value="<?php echo $_SESSION['sys']['ping_counter'] ?>">
        <label for="ping-counter"><?php echo lang('PING COUNTER', $lang_file) ?></label>
      </div>

      <div class="hstack gap-3">
        <!-- submit button -->
        <button type="submit" class="me-auto btn btn-primary text-capitalize fs-12 py-1"><i class="bi bi-check-all me-1"></i><?php echo lang('SAVE') ?></button>
      </div>
    </form>
  </div>
</div>