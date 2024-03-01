<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize ">
      <?php echo lang('MIKROTIK SERVICE', $lang_file) ?>
    </h5>
    <hr />

    <form action="?do=change-mikrotik-status" method="post">
      <input type="hidden" name="company_id" value="<?php echo $_SESSION['sys']['company_id'] ?>">
      <input type="hidden" id="mikrotik_status" name="mikrotik_status" value="<?php echo $_SESSION['sys']['mikrotik']['status'] ?>">
      <div class="service-status form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="mikrotikStatusSwitch" <?php echo $_SESSION['sys']['mikrotik']['status'] == true ? 'checked' : '' ?>>
      </div>
    </form>
  </div>

  <div class="mb-1">
    <!-- change mikrotik info form -->
    <form action="?do=change-mikrotik" method="POST" id="mikrotik-settings">
      <div class="ip-port-container">
        <!-- IP -->
        <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input class="form-control" type="text" name="mikrotik-ip" id="mikrotik-ip" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['ip']) ? trim($_SESSION['sys']['mikrotik']['ip'], '') : null ?>" placeholder="<?php echo lang('IP') ?>" <?php echo $_SESSION['sys']['mikrotik']['status'] == true ? '' : 'disabled' ?>>
          <label for="mikrotik-ip">
            <?php echo lang('IP') ?>
          </label>
        </div>
        <!-- port -->
        <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
          <input class="form-control" type="number" name="mikrotik-port" id="mikrotik-port" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['port']) ? trim($_SESSION['sys']['mikrotik']['port'], '') : null ?>" placeholder="<?php echo lang('PORT') ?>" <?php echo $_SESSION['sys']['mikrotik']['status'] == true ? '' : 'disabled' ?>>
          <label for="mikrotik-port">
            <?php echo lang('PORT') ?>
          </label>
        </div>
      </div>
      <!-- username -->
      <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <input class="form-control" type="text" name="mikrotik-username" id="mikrotik-username" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['username']) ? trim($_SESSION['sys']['mikrotik']['username'], '') : null ?>" placeholder="<?php echo lang('USERNAME') ?>" <?php echo $_SESSION['sys']['mikrotik']['status'] == true ? '' : 'disabled' ?>>
        <label for="mikrotik-username">
          <?php echo lang('USERNAME') ?>
        </label>
      </div>
      <!-- password -->
      <div class="mb-3 form-floating form-floating-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
        <input class="form-control" type="password" name="mikrotik-password" id="mikrotik-password" value="<?php echo isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['password']) ? trim($_SESSION['sys']['mikrotik']['password'], '') : null ?>" placeholder="<?php echo lang('PASSWORD') ?>" <?php echo $_SESSION['sys']['mikrotik']['status'] == true ? '' : 'disabled' ?>>
        <i class="bi bi-eye-slash show-pass <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'show-pass-left' : 'show-pass-right' ?>" onclick="show_pass(this)"></i>
        <label for="mikrotik-password">
          <?php echo lang('PASSWORD') ?>
        </label>
        <div id="passHelp" class="form-text text-warning ">
          <?php echo lang('PASS NOTE') ?>
        </div>
      </div>

      <div class="hstack gap-3 justify-content-end">
        <?php if (isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['ip']) && !empty($_SESSION['sys']['mikrotik']['username']) && !empty($_SESSION['sys']['mikrotik']['password'])) { ?>
          <!-- check mikrotik info -->
          <button type="button" form="mikrotik-settings" class="me-auto btn btn-outline-primary text-capitalize fs-12 py-1" onclick="check_mikrotik_info(this, this.form)" data-bs-toggle="modal" data-bs-target="#mikrotikCheckInfoModal" <?php echo $_SESSION['sys']['mikrotik']['status'] == true ? '' : 'disabled' ?>>
            <i class="bi bi-arrow-clockwise"></i>
            <?php echo lang('CHECK CONNECTION', $lang_file) ?>
            <span class="spinner-border d-none" role="status"></span>
          </button>
        <?php } ?>
        <!-- submit button -->
        <button type="submit" form="mikrotik-settings" class="btn btn-primary text-capitalize fs-12 py-1" <?php echo $_SESSION['sys']['mikrotik']['status'] == true ? '' : 'disabled' ?>>
          <i class="bi bi-check-all me-1"></i>
          <?php echo lang('SAVE') ?>
        </button>
      </div>
      <?php if (isset($_SESSION['sys']['mikrotik']) && !empty($_SESSION['sys']['mikrotik']['ip']) && !empty($_SESSION['sys']['mikrotik']['username']) && !empty($_SESSION['sys']['mikrotik']['password'])) { ?>
        <div>
          <a href="?msg=mikrotik-ok">show codes</a>
        </div>
      <?php } ?>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mikrotikCheckInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="mikrotikCheckInfoModalLabel">
          <?php echo lang('MIKROTIK CONNECTION STATUS', $lang_file) ?>
        </h1>
        <button type="button" class="btn-close btn-close-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?> d-none" data-bs-dismiss="modal" aria-label="Close" onclick="clear_modal_body('#mikrotikCheckInfoModal')"></button>
      </div>
      <div class="modal-body">
        <div class="loader text-center">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary fs-12 py-1 disabled" data-bs-dismiss="modal" onclick="clear_modal_body('#mikrotikCheckInfoModal')">
          <span class="d-none">
            <?php echo lang('CLOSE') ?>
          </span>
          <span class="spinner-border" role="status"></span>
        </button>
      </div>
    </div>
  </div>
</div>


<script>
  // get mikrotik switch
  let mikrotik_switch = document.querySelector('#mikrotikStatusSwitch');
  let mikrotik_status = document.querySelector('#mikrotik_status');

  // add event to mikrotik switch
  mikrotik_switch.addEventListener('click', function(evt) {
    // check switch value
    mikrotik_status.value = this.checked ? '1' : '0';
    // select mikrotik form
    let mikrotik_form_elements = document.querySelector('#mikrotik-settings').elements;
    // loop on it
    for (const element of mikrotik_form_elements) {
      element.disabled = this.checked ? false : true;
    }
    // submit form to save changes after 0.5sec
    setTimeout(() => {
      this.form.submit();
    }, 300);
  });
</script>