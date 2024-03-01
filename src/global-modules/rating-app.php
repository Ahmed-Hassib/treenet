<!-- Modal -->
<div class="modal fade" id="ratingAppModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ratingAppModalLabel" aria-hidden="true" dir="<?php echo $page_dir ?>">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ratingAppModalLabel"><?php echo lang('RATE APP') ?></h1>
        <button type="button" class="btn-close btn-close-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'left' : 'right' ?>" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background-color: rgba(0,0,0,0.01)">
        <div class="rating-form-container">
          <form action="<?php echo $nav_up_level ?>requests/index.php?do=rating-app" method="POST" class="rating-form" id="rating-app-form">
            <input type="radio" id="rating-5" name="rating" value="5">
            <label for="rating-5" class="bi bi-star-fill"></label>
            <input type="radio" id="rating-4" name="rating" value="4">
            <label for="rating-4" class="bi bi-star-fill"></label>
            <input type="radio" id="rating-3" name="rating" value="3">
            <label for="rating-3" class="bi bi-star-fill"></label>
            <input type="radio" id="rating-2" name="rating" value="2">
            <label for="rating-2" class="bi bi-star-fill"></label>
            <input type="radio" id="rating-1" name="rating" value="1">
            <label for="rating-1" class="bi bi-star-fill"></label>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" form="rating-app-form" class="btn btn-primary py-1 px-5 fs-12"><?php echo lang('SEND') ?></button>
        <button type="button" class="btn btn-outline-secondary py-1 px-5 fs-12" data-bs-dismiss="modal"><?php echo lang('CLOSE') ?></button>
      </div>
    </div>
  </div>
</div>