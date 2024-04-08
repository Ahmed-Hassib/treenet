<?php
// create an object of Database class
$dev_comp_obj = !isset($dev_comp_obj) ? new ManufuctureCompanies() : $dev_comp_obj;

// get all devices companies data
$manufacture_companies = $dev_comp_obj->get_all_man_companies(base64_decode($_SESSION['sys']['company_id']));
?>

<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- buttons section -->
  <div class="mb-3 hstack gap-3">
    <?php if ($_SESSION['sys']['pcs_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
      <button type="button" class="btn btn-outline-primary shadow-sm py-1 fs-12" data-bs-toggle="modal" data-bs-target="#addNewDevCompanyModal">
        <i class="bi bi-file-plus"></i>
        <?php echo lang("ADD COMPANY", $lang_file) ?>
      </button>

      <button type="button" class="btn btn-outline-primary py-1 fs-12" data-bs-toggle="modal" data-bs-target="#addNewDevice">
        <i class="bi bi-plus"></i>
        <?php echo lang('ADD DEVICE', $lang_file) ?>
      </button>
    <?php } ?>
  </div>

  <div class="section-block">
    <?php if ($manufacture_companies != null && count($manufacture_companies) > 0) { ?>
      <!-- strst manufacture companies table -->
      <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo count($manufacture_companies) <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="null"  style="width:100%">
        <thead class="primary text-capitalize">
          <tr>
            <th>#</th>
            <th>
              <?php echo lang('COMPANY NAME', $lang_file) ?>
            </th>
            <th>
              <?php echo lang('#DEVICES', $lang_file) ?>
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
        <tbody id="devices-companies">
          <?php foreach ($manufacture_companies as $key => $company) { ?>
            <tr>
              <td>
                <?php echo ++$key ?>
              </td>
              <!-- device`s company name -->
              <td>
                <?php echo $company['man_company_name'] ?>
              </td>
              <!-- total number of devices in this company -->
              <td>
                <?php echo $dev_comp_obj->count_records("`device_id`", "`devices_info`", "WHERE `device_company_id` = " . $company['man_company_id']) ?>
              </td>
              <!-- added by -->
              <td>
                <?php
                // get username that add company
                $added_by_name = $dev_comp_obj->select_specific_column("`username`", "`users`", "WHERE `UserID` = " . $company['added_by'])['username'];
                // check permission
                if ($_SESSION['sys']['user_update'] == 1) { ?>
                  <a href="<?php echo $nav_up_level ?>employees/index.php?do=edit-user-info&userid=<?php echo base64_encode($company['added_by']) ?>">
                    <?php echo $added_by_name ?>
                  </a>
                <?php } else { ?>
                  <span>
                    <?php echo $added_by_name ?>
                  </span>
                <?php } ?>
              </td>
              <!-- added date -->
              <td>
                <?php echo $company['added_date'] ?>
              </td>
              <!-- control buttons -->
              <td>
                <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                  <!-- edit button -->
                  <button type="button" class="btn btn-outline-success py-1 fs-12" data-bs-toggle="modal" data-bs-target="#editDevCompanyModal" data-name="<?php echo $company['man_company_name'] ?>" data-id="<?php echo base64_encode($company['man_company_id']) ?>" onclick="put_data_into_modal(this, 'edit', 'updated-company-id', 'old-company-name')">
                    <i class="bi bi-pencil-square"></i>
                    <?php echo lang('EDIT') ?>
                  </button>
                <?php } ?>
                <!-- show all devices button -->
                <a href="?do=devices-companies&action=show-devices&dev-company-id=<?php echo base64_encode($company['man_company_id']) ?>" class="btn btn-outline-primary p-1 fs-12" style="width: 50px">
                  <?php echo lang('PIECES') ?>
                </a>
                <?php if ($_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                  <!-- delete button -->
                  <button type="button" class="btn btn-outline-danger py-1 fs-12" data-bs-toggle="modal" data-bs-target="#deleteDevCompanyModal" data-name="<?php echo $company['man_company_name'] ?>" data-id="<?php echo base64_encode($company['man_company_id']) ?>" onclick="put_data_into_modal(this, 'delete', 'deleted-company-id', 'deleted-company-name')">
                    <i class="bi bi-trash"></i>
                    <?php echo lang('DELETE') ?>
                  </button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else {
      // include no data founded file
      include_once $globmod . 'no-data-founded-no-redirect.php';
    } ?>
  </div>
</div>

<?php
if ($_SESSION['sys']['pcs_add'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) {
  // include add new device company modal
  include_once 'add-man-company-modal.php';
  // include add new device modal
  include_once 'add-device-modal.php';
}

if ($_SESSION['sys']['isLicenseExpired'] == 0) {
  // include edit device company modal
  include_once 'edit-man-company-modal.php';
  // include delete device company modal
  include_once 'delete-man-company-modal.php';
}
?>