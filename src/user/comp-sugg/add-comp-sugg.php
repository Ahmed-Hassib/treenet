<?php $type = isset($_GET['type']) ? $_GET['type'] : -1; ?>
<!-- start edit profile page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="section-block mx-auto" style="max-width: 600px">
    <form class="profile-form" action="?do=insert-comp-sugg" method="POST">
      <!-- start type field -->
      <div class="mb-4 row justify-content-center align-items-center">
        <label for="type" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('THE TYPE', @$_SESSION['sys']['lang']) ?></label>
        <div class="col-sm-8">
          <!-- COMPLAINT -->
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="comp" value="0" <?php echo $type == 0 ? 'checked' : ''; ?>>
            <label class="form-check-label text-capitalize" for="comp">
              <?php echo lang('COMPLAINT', @$_SESSION['sys']['lang']) ?>
            </label>
          </div>
          <!-- SUGGESTION -->
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="sugg" value="1" <?php echo $type == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label text-capitalize" for="sugg">
              <?php echo lang('SUGGESTION', @$_SESSION['sys']['lang']) ?>
            </label>
          </div>
        </div>
      </div>
      <!-- end type field -->
      <!-- strat comment field -->
      <div class="mb-4 row">
        <label for="comment" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo lang('THE COMPLAINTS', @$_SESSION['sys']['lang'])." - ".lang('THE SUGGESTION', @$_SESSION['sys']['lang']) ?></label>
        <div class="col-sm-12 col-md-8">
          <textarea name="comment" id="comment" class="form-control" cols="30" rows="5" style="resize: none;direction:<?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>"></textarea>
        </div>
      </div>
      <!-- end comment field -->
      
      <!-- strat submit -->
      <div class="hstack">
        <div class="me-auto">
          <button type="submit" class="ms-auto btn btn-outline-primary text-capitalize fs-12 py-1">
            <i class="bi bi-plus"></i>&nbsp;<?php echo lang('SUBMIT', @$_SESSION['sys']['lang']) ?></button>
        </div>
      </div>
      <!-- end submit -->
    </form>
  </div>
</div>