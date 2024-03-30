<?php
// get comp or sugg id
$id = isset($_GET['id']) && !empty($_GET['id']) ? base64_decode($_GET['id']) : null;
// create an object of CompSugg
$obj = new CompSugg();
// get data
$data = $obj->get_specific_data($id, base64_decode($_SESSION['sys']['company_id']));

// array of error
$err_arr  = [];

// check id
if ($id == null) {
  $err_arr[] = 'no data';
}

// check data
if ($data != null) {
?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <div class="mb-4 comp-sugg-container">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5">
            <?php echo ucfirst(lang('edit', $lang_file)) ?>
          </h5>
          <hr>
        </header>
        <form class="profile-form" action="?do=update" method="POST">
          <input type="hidden" name="id" value="<?php echo base64_encode($id) ?>">
          <div class="mb-4 row justify-content-center align-items-center">
            <label for="type" class="col-sm-4 col-form-label text-capitalize"><?php echo lang('type') ?></label>
            <div class="col-sm-8">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="comp" value="<?php echo base64_encode('comp') ?>" <?php echo $data['type'] == 'comp' ? 'checked' : null ?> <?php echo !in_array($data['status'], [0, 1]) ? 'disabled' : null ?>>
                <label class="form-check-label text-capitalize" for="comp">
                  <?php echo lang('comp', $lang_file) ?>
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="sugg" value="<?php echo base64_encode('sugg') ?>" <?php echo $data['type'] == 'sugg' ? 'checked' : null ?> <?php echo !in_array($data['status'], [0, 1]) ? 'disabled' : null ?>>
                <label class="form-check-label text-capitalize" for="sugg">
                  <?php echo lang('sugg', $lang_file) ?>
                </label>
              </div>
            </div>
          </div>
          <div class="mb-4 form-floating">
            <textarea name="comment" id="comment" class="form-control" cols="30" rows="5" style="resize: none;direction: <?php echo $page_dir ?>" placeholder="<?php echo lang('the comp or sugg', $lang_file) ?>" <?php echo !in_array($data['status'], [0, 1]) ? 'disabled' : null ?>><?php echo $data['text'] ?></textarea>
            <label for="comment" class="col-sm-12 col-md-4 col-form-label text-capitalize"><?php echo lang('the comp or sugg', $lang_file) ?></label>
          </div>
          <?php if (in_array($data['status'], [0, 1])) { ?>
            <div class="my-3 hstack">
              <div class="<?php echo $page_dir == 'rtl' ? 'me-auto' : 'ms-auto' ?>">
                <button type="submit" class="btn btn-outline-primary text-capitalize fs-12 py-1">
                  <i class="bi bi-check-all"></i>&nbsp;<?php echo lang('save') ?></button>
              </div>
            </div>
          <?php } ?>
        </form>
      </div>

      <?php $media = $obj->get_media($id); ?>
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5"><?php echo ucfirst(lang('media', $lang_file)) ?></h5>
          <hr>
        </header>
        <?php if (!is_null($media)) { ?>
          <?php $path = "{$uploads}comp-sugg/" . base64_decode($_SESSION['sys']['company_id']) . "/" . $media['media']; ?>
          <?php if ($media['type'] == 'img') { ?>
            <img src="<?php echo $path ?>" class="comp-sugg-media" alt="<?php echo lang('media', $lang_file) ?>" onclick="open_media('<?php echo $path ?>', '<?php echo $media['type'] == 'img' ? 'jpg' : 'mp4' ?>')">
          <?php } else { ?>
          <?php } ?>
        <?php } else { ?>
          <span class="badge bg-danger p-3" style="font-size: 1em"><?php echo lang('no data') ?></span>
        <?php } ?>
      </div>

      <div class="section-block">
        <header class="section-header">
          <h5 class="h5"><?php echo ucfirst(lang('additional info', $lang_file)) ?></h5>
          <hr>
        </header>
        <div class="comp-sugg-info-container">
          <div class="comp-sugg-info">
            <span><?php echo lang('added date & time') ?></span>
            <span><?php echo date_format(date_create($data['created_at']), 'h:sa d/m/Y') ?></span>
          </div>
          <div class="comp-sugg-info">
            <span><?php echo lang('updated date & time') ?></span>
            <span><?php echo !is_null($data['updated_at']) ? date_format(date_create($data['updated_at']), 'h:sa d/m/Y') : str_repeat('-', 5) ?></span>
          </div>
          <div class="comp-sugg-info">
            <span><?php echo lang($data['type'] . ' status', $lang_file) ?></span>
            <span>
              <?php if ($data['status'] == 0) { ?>
                <span class="badge bg-warning"><?php echo lang('pending') ?></span>
              <?php } elseif ($data['status'] == 1) { ?>
                <span class="badge bg-info"><?php echo lang('processing') ?></span>
              <?php } else { ?>
                <span class="badge bg-success"><?php echo lang('success') ?></span>
              <?php } ?>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="section-block">
      <header class="section-header">
        <h5 class="h5"><?php echo ucfirst(lang('comments', $lang_file)) ?></h5>
        <hr>
      </header>
      <?php
      // create an object of CompSuggReplays
      $comments_obj = new CompSuggReplays();
      // get all comments
      $comments = $comments_obj->get_comments($id);
      ?>
      <div class="comments-container" <?php echo is_null($comments) ? "style='height: auto;'" : '' ?>>
        <?php if (!is_null($comments)) { ?>
          <?php foreach ($comments as $key => $comment) { ?>
            <div class="comment-content <?php echo $comment['added_by'] == 1 ? 'comment-even' : 'comment-odd' ?>">
              <header class="comment-header">
                <span><?php echo $comment['added_by'] == 1 ? lang('admin') : lang('you') ?></span>
                <span>&nbsp;&bullet;</span>
                <span><?php echo date_format(date_create($comment['created_at']), 'h:ia d/m/Y') ?></span>
              </header>
              <p class="lead comment"><?php echo ucfirst($comment['replay_text']) ?></p>
            </div>
          <?php } ?>
        <?php } else { ?>
          <span class="badge bg-danger p-3" style="font-size: 1em"><?php echo lang('no data') ?></span>
        <?php } ?>
      </div>
      <?php if (in_array($data['status'], [0, 1])) { ?>
        <div class="mt-5 add-comments">
          <hr>
          <form action="?do=add-comment" method="post">
            <input type="hidden" name="id" value="<?php echo base64_encode($id) ?>">
            <div class="add-comment-input">
              <input type="text" name="replay" class="form-control" placeholder="<?php echo lang('the comment') ?>">
              <button type="submit" class="ms-auto btn btn-primary w-100">
                <i class="bi bi-send"></i>
                <?php echo lang('send') ?>
              </button>
            </div>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php if (!is_null($media)) { ?>
    <!-- media modal -->
    <div id="media-modal" class="media-modal">
      <span class="close" id="media-modal-close">
        <i class="bi bi-x-lg"></i>
      </span>
      <div id="media-modal-content"></div>
    </div>
  <?php } ?>
<?php
} else {
  foreach ($errors as $key => $error) {
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = 'global_';
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
}
