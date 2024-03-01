<!-- modal to show -->
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px"  dir="<?php echo $page_dir ?>">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize " id="exampleModalLabel"><?php echo lang('CONFIRM DELETE', $lang_file) ?></h5>
      </div>
      <div class="modal-body">
        <h4 class="h4" <?php echo @$_SESSION['sys']['lang'] == "ar" ? "dir=rtl" : ""; ?>><?php echo lang('CONFIRM DELETE')." '" ?> <span id="deleted-employee-name" class="text-danger"></span> <?php echo "' ".( @$_SESSION['sys']['lang'] == "ar" ? "؟" : "?" )?> </h4>
      </div>
      <div class="modal-footer">
        <?php if ($_SESSION['sys']['user_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
          <a id="deleted-employee-url" class="btn btn-danger text-capitalize py-1 fs-12" dir="<?php echo $page_dir ?>"><i class="bi bi-trash"></i>&nbsp;<?php echo lang('DELETE') ?></a>
        <?php } ?>
        <button type="button" class="btn btn-outline-secondary py-1 fs-12" data-bs-dismiss="modal"><?php echo lang('CLOSE') ?></button>
      </div>
    </div>
  </div>
</div>