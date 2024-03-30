<?php
// get type
$type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : null;

// array of errors
$errors = array();

// available types
$available_types = ['comp', 'sugg'];

// check type
if ($type == null) {
  $errors[] = 'type null';
} elseif (!in_array($type, $available_types)) {
  $errors[] = 'type not right';
}

// check if array of errors is empty
if (empty($errors)) {
  $comp_sugg_obj = new CompSugg();

  // get data
  $data = $comp_sugg_obj->get_data($type, base64_decode($_SESSION['sys']['UserID']), base64_decode($_SESSION['sys']['company_id']));
?>
  <div class="container" dir="<?php echo $page_dir ?>">
    <div class="mb-3 hstack gap-3">
      <a href="?do=add" class="btn btn-outline-primary py-1">
        <i class="bi bi-plus"></i>
        <?php echo lang('add', $lang_file) ?>
      </a>
    </div>
    <div class="section-block">
      <header class="section-header">
        <h5 class="h5">
          <?php echo $type == 'comp' ? ucfirst(lang('the comps', $lang_file)) : ucfirst(lang('the suggs', $lang_file)) ?>
        </h5>
        <hr>
      </header>
      <!-- strst malfunctions table -->
      <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" data-scroll-y="<?php echo ($data != null && count($data) <= 10) || $data == null ? null : '400' ?>" style="width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <th class="text-center" style="width: 20px">#</th>
            <th class="text-center"><?php echo lang('type') ?></th>
            <th class="text-center"><?php echo lang('text', $lang_file) ?></th>
            <th class="text-center"><?php echo lang('status') ?></th>
            <th class="text-center"><?php echo lang('date & time') ?></th>
            <th class="text-center"><?php echo lang('control') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if ($data != null && count($data) > 0) { ?>
            <?php foreach ($data as $index => $row) { ?>
              <tr>
                <td><?php echo ($index + 1); ?></td>
                <td><?php echo lang($row['type'], $lang_file) ?></td>
                <td><?php echo ucfirst($row['text']) ?></td>
                <td>
                  <?php if ($row['status'] == 0) { ?>
                    <span class="badge bg-warning py-2" style='font-size: 1em'><?php echo ucfirst(lang('pending')) ?></span>
                  <?php } elseif ($row['status'] == 1) { ?>
                    <span class="badge bg-info py-2" style='font-size: 1em'><?php echo ucfirst(lang('processing')) ?></span>
                  <?php } elseif ($row['status'] == 2) { ?>
                    <span class="badge bg-success py-2" style='font-size: 1em'><?php echo ucfirst(lang('success')) ?></span>
                  <?php } ?>
                </td>
                <td><?php echo date_format(date_create($row['created_at']), 'h:ia d/m/Y') ?></td>
                <td>
                  <a href="?do=edit&id=<?php echo base64_encode($row['id']) ?>" class="btn btn-outline-success">
                    <i class="bi bi-pencil-square"></i>
                    <?php echo ucfirst(lang('show details')) ?>
                  </a>
                </td>
              </tr>
            <?php } ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
<?php
} else {
  foreach ($errors as $key => $error) {
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
    $_SESSION['flash_message_class'][$key] = 'danger';
    $_SESSION['flash_message_status'][$key] = false;
    $_SESSION['flash_message_lang_file'][$key] = $lang_file;
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
}
