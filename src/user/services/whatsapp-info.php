<div class="section-block">
  <!-- section header -->
  <div class="section-header">
    <h5 class="text-capitalize ">
      <?php echo lang('WHATSAPP SERVICE', $lang_file) ?>
    </h5>
    <hr />

    <form action="?do=change-whatsapp-status" method="post">
      <input type="hidden" name="company_id" value="<?php echo $_SESSION['sys']['company_id'] ?>">
      <input type="hidden" id="whatsapp_status" name="whatsapp_status" value="<?php echo $_SESSION['sys']['whatsapp_status'] ?>">
      <div class="service-status form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="whatsappStatusSwitch"
          <?php echo $_SESSION['sys']['whatsapp_status'] == true ? 'checked' : '' ?>>
      </div>
    </form>
  </div>

  <div class="mb-1">
    <span class="badge bg-warning w-100">
      <i class="bi bi-exclamation-triangle-fill"></i>
      <?php echo lang('UNDER DEVELOPING') ?>
    </span>
  </div>
</div>


<!-- Modal -->
<!-- <div class="modal fade" id="whatsappCheckInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="whatsappCheckInfoModalLabel">
          <?php echo lang('whatsapp CONNECTION STATUS', $lang_file) ?>
        </h1>
        <button type="button" class="btn-close btn-close-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?> d-none"
          data-bs-dismiss="modal" aria-label="Close" onclick="clear_modal_body('#whatsappCheckInfoModal')"></button>
      </div>
      <div class="modal-body">
        <div class="loader text-center">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary fs-12 py-1 disabled" data-bs-dismiss="modal"
          onclick="clear_modal_body('#whatsappCheckInfoModal')">
          <span class="d-none">
            <?php echo lang('CLOSE') ?>
          </span>
          <span class="spinner-border" role="status"></span>
        </button>
      </div>
    </div>
  </div>
</div> -->


<script>
  // get whatsapp switch
  let whatsapp_switch = document.querySelector('#whatsappStatusSwitch');
  let whatsapp_status = document.querySelector('#whatsapp_status');

  // add event to whatsapp switch
  whatsapp_switch.addEventListener('click', function (evt) {
    // check switch value
whatsapp_status.value = this.checked ? '1' : '0';
    // select whatsapp form
    let whatsapp_form_elements = document.querySelector('#whatsapp-settings').elements;
    // loop on it
    for (const element of whatsapp_form_elements) {
      element.disabled = this.checked ? false : true;
    }
    // submit form to save changes after 0.5sec
    setTimeout(() => {
      this.form.submit();
    }, 300);
  });
</script>