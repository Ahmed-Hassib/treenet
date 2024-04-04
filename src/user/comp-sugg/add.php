<div class="container" dir="<?php echo $page_dir ?>">
  <div class="section-block mx-auto" style="max-width: 450px">
    <header class="section-header">
      <h5 class="h5">
        <?php echo ucfirst(lang('add new', $lang_file)) ?>
      </h5>
      <hr>
    </header>
    <form class="profile-form" action="?do=insert" method="POST" enctype="multipart/form-data">
      <div class="mb-4 row justify-content-center align-items-center">
        <label for="type" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('type') ?></label>
        <div class="col-sm-8">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="comp" value="<?php echo base64_encode('comp') ?>">
            <label class="form-check-label text-capitalize" for="comp">
              <?php echo lang('comp', $lang_file) ?>
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="sugg" value="<?php echo base64_encode('sugg') ?>">
            <label class="form-check-label text-capitalize" for="sugg">
              <?php echo lang('sugg', $lang_file) ?>
            </label>
          </div>
        </div>
      </div>
      <div class="mb-4 form-floating">
        <textarea name="comment" id="comment" class="form-control" cols="30" rows="5" style="resize: none;direction: <?php echo $page_dir ?>" placeholder="<?php echo lang('the comp or sugg', $lang_file) ?>"></textarea>
        <label for="comment" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo lang('the comp or sugg', $lang_file) ?></label>
      </div>
      <!-- cost receipt -->
      <label for="comp-sugg-media" class="custum-file-upload">
        <div class="icon">
          <img src="<?php echo $treenet_assets ?>file-cloud.svg" alt="">
        </div>
        <div class="text">
          <span class="text-primary fw-bold">
            <?php echo lang('upload media', $lang_file) ?>
          </span>
        </div>
        <input type="file" id="comp-sugg-media" name="comp-sugg-media" accept="image/*" onchange="add_media(this, 'image-preview')">
      </label>

      <!-- cost image preview -->
      <div id="image-preview" class="image-preview w-100 d-none"></div>

      <div class="my-3 hstack">
        <div class="me-auto">
          <button type="submit" class="ms-auto btn btn-outline-primary text-capitalize fs-12 py-1">
            <i class="bi bi-plus"></i>&nbsp;<?php echo lang('add', $lang_file) ?></button>
        </div>
      </div>
    </form>
  </div>
</div>