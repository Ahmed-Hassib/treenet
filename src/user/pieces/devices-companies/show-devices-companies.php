<!-- start edit profile page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 hstack gap-3">
    <?php if ($_SESSION['sys']['pcs_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
      <button type="button" class="btn btn-outline-primary py-1 fs-12" data-bs-toggle="modal" data-bs-target="#addNewDevice">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD DEVICE', $lang_file) ?>
      </button>
    <?php } ?>
  </div>
  <!-- add new device modal -->

  <?php
  // get devices company id
  $dev_company_id = isset($_GET['dev-company-id']) && !empty($_GET['dev-company-id']) ? base64_decode($_GET['dev-company-id']) : 0;
  // create an object of Devices class
  $dev_obj = !isset($dev_obj) ? new Devices() : $dev_obj;
  // get company name
  @$dev_company_name = $dev_obj->select_specific_column("`man_company_name`", "`manufacture_companies`", "WHERE `man_company_id` = " . $dev_company_id)[0]['man_company_name'];
  // check if company is exit
  $is_exist = $dev_obj->is_exist("`man_company_id`", "`manufacture_companies`", $dev_company_id);
  // check the value
  if (!empty($dev_company_id) && $is_exist) {
    // get all devices of this company
    $devices = $dev_obj->get_all_company_devices($dev_company_id);
    // devices counter
    $devices_counter = $devices[0];
    // devices data
    $devices_data = $devices[1];
    // check the counter
    if ($devices_counter > 0) { ?>
      <!-- start table container -->
      <div class="section-block">
        <div class="section-header">
          <h2 class="h2 text-capitalize">
            <?php echo lang('ALL DEV COMP', $lang_file) ?>
            <span>:&nbsp;</span>
            <span class="badge bg-primary">
              <?php echo $dev_company_name ?>
            </span>
          </h2>
          <hr>
        </div>
        <!-- strst users table -->
        <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo $devices_counter <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="null"  style="width:100%">
          <thead class="primary text-capitalize">
            <tr>
              <th>#</th>
              <th>
                <?php echo lang('DEVICE NAME', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('#MODELS', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('ADDED BY') ?>
              </th>
              <th>
                <?php echo lang('ADDED DATE') ?>
              </th>
              <th>
                <?php echo lang('CONTROL') ?>
              </th>
            </tr>
          </thead>
          <tbody id="devices-info">
            <?php foreach ($devices_data as $key => $device) { ?>
              <tr>
                <td>
                  <?php echo ++$key ?>
                </td>
                <!-- display company name -->
                <td>
                  <?php echo $device['device_name'] ?>
                </td>
                <!-- display total number of models -->
                <td>
                  <?php echo $dev_obj->count_records("`model_id`", "`devices_model`", "WHERE `device_id` = " . $device['device_id']) ?>
                </td>
                <!-- display added by account -->
                <td>
                  <?php
                  // get username that add device
                  $added_by_name = $dev_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $device['added_by'])[0]['username'];
                  // check permission
                  if ($_SESSION['sys']['user_update'] == 1) { ?>
                    <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($device['added_by']) ?>">
                      <?php echo $added_by_name ?>
                    </a>
                  <?php } else { ?>
                    <span>
                      <?php echo $added_by_name ?>
                    </span>
                  <?php } ?>
                </td>
                <!-- display added date -->
                <td>
                  <?php echo $device['added_date'] ?>
                </td>
                <!-- controls buttons -->
                <td>
                  <?php if ($_SESSION['sys']['pcs_update'] == 1) { ?>
                    <!-- edit button -->
                    <a class="btn btn-success text-capitalize p-1 fs-12" href="?do=devices-companies&action=show-device&device-id=<?php echo base64_encode($device['device_id']); ?>" target="">
                      <i class="bi bi-pencil-square"></i>
                      <?php echo lang('EDIT') ?>
                    </a>
                  <?php } ?>
                  <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                    <!-- delete device info -->
                    <button type="button" class="btn btn-outline-danger text-capitalize bg-gradient fs-12 p-1" data-bs-toggle="modal" data-bs-target="#deleteDeviceModal" data-id="<?php echo base64_encode($device['device_id']) ?>" data-name="<?php echo $device['device_name'] ?>" onclick="put_data_into_modal(this, 'delete', 'deleted-device-id', 'deleted-device-name', true);">
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
  <?php
    } else {
      // include no data founded
      include_once $globmod . 'no-data-founded-no-redirect.php';
    }
  } else {
    // include no data founded
    include_once $globmod . 'no-data-founded.php';
  } ?>
</div>

<?php if ($_SESSION['sys']['pcs_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
  # include add new device modal 
  include_once 'add-device-modal.php';
}

if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
  # include delete device model modal 
  include_once 'delete-device-modal.php';
}
?>