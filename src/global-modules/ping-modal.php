<!-- modal to show -->
<div class="modal fade" id="pingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px" dir="<?php echo @$page_dir ?>">
    <div class="modal-content">
      <div class="modal-header" dir="ltr">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel">Ping</h5>
      </div>
      <div class="modal-body position-relative">
        <div class="ping-preloader">
          <div class="ping-spinner spinner-grow spinner-border"></div>
        </div>
        <div id="ping-status" dir="ltr"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary py-1 fs-12" data-bs-dismiss="modal" onclick="reset_modal()"><?php echo lang('CLOSE') ?></button>
      </div>
    </div>
  </div>
</div>