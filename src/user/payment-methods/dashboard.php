<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="row mb-3">
    <div class="col-sm-12">
      <div class="py-3 section-block">
        <header class="mb-0 section-header">
          <h2 class="h2 text-capitalize"><?php echo lang('PAYMENT METHODS') ?></h2>
        </header>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-lg-6">
      <div class="section-block">
        <header class="section-header">
          <h2 class="h2 text-capitalize">
            <img loading="lazy" src="<?php echo $assets ?>vodafone-icon.svg" width="30" alt="">
            <?php echo lang('VODAFONE CASH', $lang_file) ?>
          </h2>
          <hr>
        </header>

        <form action="" method="POST">
          <input type="hidden" name="payment_method" value="paymob">
          <div class="mb-3 row row-cols-sm-1 row-cols-md-2 g-3">
            <div class="col">
              <div class="form-floating">
                <input type="text" class="form-control" name="paymob-phone"
                  placeholder="<?php echo lang('FIRST NAME') ?>" value="">
                <label for="paymob-phone">
                  <?php echo lang('FIRST NAME') ?>
                </label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating">
                <input type="text" class="form-control" name="paymob-phone"
                  placeholder="<?php echo lang('LAST NAME') ?>" value="">
                <label for="paymob-phone">
                  <?php echo lang('LAST NAME') ?>
                </label>
              </div>
            </div>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="paymob-phone" placeholder="<?php echo lang('PHONE') ?>"
              value="">
            <label for="paymob-phone">
              <?php echo lang('PHONE') ?>
            </label>
          </div>
          <div class="mt-3 hstack justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-all"></i>
              <?php echo lang('SAVE') ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>