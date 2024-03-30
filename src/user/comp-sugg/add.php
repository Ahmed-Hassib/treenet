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
          <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" fill=""></path>
            </g>
          </svg>
        </div>
        <div class="text">
          <span>
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