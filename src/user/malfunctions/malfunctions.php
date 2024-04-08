<?php
// get piece / client id
$pieceid = isset($_GET['pieceid']) && !empty($_GET['pieceid']) ? base64_decode($_GET['pieceid']) : 0;
// create an object of Malfunction class
$mal_obj = new Malfunction();
// check the piece id 
$is_exist_piece = $mal_obj->is_exist("`id`", "`pieces_info`", $pieceid);
// check if there are malfunctions of this piece / client
$is_exist_mal = $is_exist_piece == true ? $mal_obj->is_exist("`client_id`", "`malfunctions`", $pieceid) : 0;
// check
if ($is_exist_piece) {
  // get piece info
  $piece_info = $mal_obj->select_specific_column("`is_client`, `full_name`", "`pieces_info`", "WHERE `id` = $pieceid AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
  // get piece type
  $piece_type = $piece_info['is_client'] == 1 ? 'clients' : 'pieces';
  // get piece name
  $piece_name = $piece_info['full_name'];
}
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <?php if ($_SESSION['sys']['mal_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
    <div class="mb-3">
      <a href="?do=add-new-malfunction" class="btn btn-outline-primary py-1 fs-12 shadow-sm">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD NEW', $lang_file) ?>
      </a>
    </div>
  <?php } ?>
  <!-- start header -->
  <header class="header mb-1">
    <!-- title -->
    <h4 class="h4 text-capitalize text-secondary ">
      <?php echo $piece_type == 'clients' ? lang('CLT MALS', 'clients') : lang('PCS MALS', 'pieces') ?>
    </h4>
    <!-- piece name and link -->
    <h5 class="h5 text-capitalize text-secondary ">
      <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
        <?php if ($piece_type == 'clients') { ?>
          <a href="<?php echo $nav_up_level ?>clients/index.php?do=edit-client&client-id=<?php echo base64_encode($pieceid) ?>">
            <?php echo $piece_name ?>
          </a>
        <?php } else { ?>
          <a href="<?php echo $nav_up_level ?>pieces/index.php?do=edit-piece&piece-id=<?php echo base64_encode($pieceid) ?>">
            <?php echo $piece_name ?>
          </a>
        <?php } ?>
      <?php } else { ?>
        <span class="text-primary">
          <?php echo $piece_name ?>
        </span>
      <?php } ?>
    </h5>

    <?php if ($_SESSION['sys']['is_tech'] == 1) { ?>
      <p class="text-danger">
        <?php echo lang('MALS FAILED', $lang_file) ?>
      </p>
    <?php } ?>
  </header>
  <!-- end header -->
  <?php if ($is_exist_mal == true) { ?>
    <?php
    // if current emp is technical man
    $tech_condition = $_SESSION['sys']['is_tech'] == 1 ? 'AND `tech_id` = ' . base64_decode($_SESSION['sys']['UserID']) : '';
    $query = "SELECT *FROM `malfunctions` WHERE `client_id` = $pieceid $tech_condition";
    // prepaire the query
    $stmt = $con->prepare($query);
    $stmt->execute(); // execute query
    $rows = $stmt->fetchAll(); // fetch data
    $count = $stmt->rowCount(); // get row count
    ?>

    <!-- start table container -->
    <div class="table-responsive-sm">
      <!-- strst malfunctions table -->
      <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" style="width:100%" id="malfunctions">
        <thead class="primary text-capitalize">
          <tr>
            <th class="text-center" style="width: 20px">#</th>
            <th class="text-center">
              <?php echo lang('ADMIN NAME', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('TECH NAME', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('NAME', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('MAL DESC', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('TECH COMMENT', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('ADDED DATE') ?>
            </th>
            <th class="text-center">
              <?php echo lang('ADDED TIME') ?>
            </th>
            <th class="text-center">
              <?php echo lang('STATUS', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('MEDIA', $lang_file) ?>
            </th>
            <th class="text-center">
              <?php echo lang('CONTROL') ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $index => $row) { ?>
            <tr>
              <!-- row index -->
              <td>
                <?php echo ($index + 1) ?>
              </td>
              <!-- admin username -->
              <td>
                <?php
                // check if exist
                $is_exist_admin = $mal_obj->is_exist("`UserID`", "`users`", $row['mng_id']);
                // if exist
                if ($is_exist_admin) {
                  $admin_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $row['mng_id'])['username'];
                ?>
                  <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo $row['mng_id']; ?>">
                    <?php echo $admin_name ?>
                  </a>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('THIS EMPLOYEE HAS BEEN DELETED', $lang_file) ?>
                  </span>
                <?php } ?>
              </td>
              <!-- technical username -->
              <td>
                <?php
                // check if exist
                $is_exist_tech = $mal_obj->is_exist("`UserID`", "`users`", $row['tech_id']);
                // if exist
                if ($is_exist_tech) {
                  $tech_name = $mal_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $row['tech_id'])['username']; ?>
                  <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo $row['tech_id']; ?>">
                    <?php echo $tech_name ?>
                  </a>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('WAS DELETED', $lang_file) ?>
                  </span>
                <?php } ?>
              </td>
              <!-- piece/client name -->
              <td>
                <?php
                // check if exist
                $is_exist_device = $mal_obj->is_exist("`id`", "`pieces_info`", $row['client_id']);
                // if exist
                if ($is_exist_device) {
                  // get info
                  $info = $mal_obj->select_specific_column("`full_name`, `is_client`", "`pieces_info`", "WHERE `id` = " . $row['client_id'] . " LIMIT 1");
                  // get name
                  $name = $info['full_name'];
                  // get type
                  $is_client = $info['is_client'];
                  // prepare url
                  if ($is_client == 1) {
                    $url = $nav_up_level . "clients/index.php?do=edit-client&client-id=" . base64_encode($row['client_id']);
                  } else {
                    $url = "?do=edit-piece&piece-id=" . base64_encode($row['client_id']);
                  }
                ?>
                  <a href="<?php echo $url ?>">
                    <?php echo $name ?>
                  </a>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- malfunction description -->
              <td>
                <?php
                if (strlen($row['descreption']) > 0 && !empty($row['descreption'])) {
                  echo $row['descreption'];
                } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA') ?>
                  </span>
                <?php } ?>
              </td>
              <!-- technical man comment -->
              <td class="<?php echo empty($row['tech_comment']) ? 'text-danger' : '' ?>">
                <?php if (!empty($row['tech_comment'])) { ?>
                  <?php echo $row['tech_comment']; ?>
                <?php } else { ?>
                  <span class="text-danger">
                    <?php echo lang('NO DATA'); ?>
                  </span>
                <?php } ?>
              </td>
              <!-- added date -->
              <td class="text-center">
                <?php echo date_format(date_create($row['added_date']), "Y-m-d") ?>
              </td>
              <!-- added time -->
              <td class="text-center">
                <?php echo date_format(date_create($row['added_time']), "h:i a") ?>
              </td>
              <!-- malfunction status -->
              <td class="text-center">
                <?php
                if ($row['mal_status'] == 0) {
                  $iconStatus = "bi-x-circle-fill text-danger";
                  $titleStatus = lang('UNFINISHED', $lang_file);
                } elseif ($row['mal_status'] == 1) {
                  $iconStatus = "bi-check-circle-fill text-success";
                  $titleStatus = lang('FINISHED', $lang_file);
                } elseif ($row['mal_status'] == 2) {
                  $iconStatus = "bi-exclamation-circle-fill text-warning";
                  $titleStatus = lang('DELAYED', $lang_file);
                } else {
                  $iconStatus = "bi-dash-circle-fill text-info";
                  $titleStatus = lang('NOT ASSIGNED');
                }
                ?>
                <i class="bi <?php echo $iconStatus ?>" title="<?php echo $titleStatus ?>"></i>
              </td>
              <!-- malfunction media status -->
              <td style="width: 50px" class="text-center">
                <?php
                $have_media = $mal_obj->count_records("`id`", "`malfunctions_media`", "WHERE `mal_id` = " . $row['mal_id']);
                if ($have_media > 0) {
                  $icon = "bi-check-circle-fill text-success";
                  $title = lang('HAVE MEDIA', $lang_file);
                } else {
                  $icon = "bi-x-circle-fill text-danger";
                  $title = lang('NO MEDIA', $lang_file);
                }
                ?>
                <i class="bi <?php echo $icon ?>" title="<?php echo $title ?>"></i>
              </td>
              <!-- control buttons -->
              <td class="text-center">
                <?php if ($_SESSION['sys']['mal_show'] == 1) { ?>
                  <a href="?do=edit-malfunction-info&malid=<?php echo base64_encode($row['mal_id']) ?>" target="" class="btn btn-outline-primary m-1 fs-12">
                    <i class="bi bi-eye"></i>
                    <?php echo lang('SHOW DETAILS') ?>
                  </a>
                <?php } ?>
                <?php if ($_SESSION['sys']['comb_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                  <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#delete-malfunction-modal" id="delete-mal" data-mal-id="<?php echo base64_encode($row['mal_id']) ?>" data-mal-id="<?php echo $mal['mal_id'] ?>" onclick="put_mal_data_into_modal(this, true)">
                    <i class="bi bi-trash"></i>
                    <?php echo lang('DELETE') ?>
                  </button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  <?php } ?>
</div>

<!-- delete malfunction modal -->
<?php
if ($_SESSION['sys']['mal_delete'] == 1) {
  include_once 'delete-malfunction-modal.php';
}
?>