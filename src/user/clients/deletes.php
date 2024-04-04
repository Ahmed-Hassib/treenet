<?php
// check date
$date = isset($_POST['date']) && !empty($_POST['date']) ? trim($_POST['date'], " ") : null;
// check period start
$period_start = isset($_POST['period-start']) && !empty($_POST['period-start']) ? trim($_POST['period-start'], " ") : null;
// check period end
$period_end = isset($_POST['period-end']) && !empty($_POST['period-end']) ? trim($_POST['period-end'], " ") : Date('Y-m-d');
// craete an object of Pieces class
$pcs_obj = new Pieces();
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 row g-3">
    <div class="col-sm-12 col-lg-4">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('SELECT DAY'); ?>
          </h5>
          <hr>
        </header>
        <form action="?do=deletes" method="post" name="malfunction-year-form">
          <div class="row g-3 align-items-baseline">
            <div class="col-7">
              <div class="form-floating">
                <input type="date" class="form-control" name="date" id="date" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $date ?>" required>
                <label for="date">
                  <?php echo lang('THE DATE') ?>
                </label>
              </div>
            </div>
            <div class="col-5">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-check-all"></i>
                <?php echo lang('APPLY') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-sm-12 col-lg-8">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize">
            <?php echo lang('SELECT PERIOD'); ?>
          </h5>
          <hr>
        </header>
        <form action="?do=deletes" method="post" name="malfunction-year-form">
          <div class="row g-3 align-items-baseline">
            <div class="col-sm-6 col-md-4">
              <div class="form-floating">
                <input type="date" class="form-control" name="period-start" id="period-start" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $period_start ?>" required>
                <label for="date">
                  <?php echo lang('PERIOD START') ?>
                </label>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="form-floating">
                <input type="date" class="form-control" name="period-end" id="period-end" min="2022-01-01" max="<?php echo Date('Y-m-d') ?>" value="<?php echo $period_end ?>" required>
                <label for="date">
                  <?php echo lang('PERIOD END') ?>
                </label>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-check-all"></i>
                <?php echo lang('APPLY') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php if ($date != null || ($period_start != null && $period_end != null)) { ?>
    <div class="row g-3">
      <div class="col-sm-12">
        <div class="section-block">
          <header class="section-header">
            <h5 class="h5 text-capitalize">
              <?php
              if ($date != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A DAY') . " {$date}";
                // get all deleted clients of specific date
                $deleted_clients = $pcs_obj->get_pieces("where `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `is_client` = 1 AND Date(`deleted_at`) = '{$date}'");
              } elseif ($period_start != null && $period_end != null) {
                $title = lang('YOU ARE SHOWING DATA FOR A PERIOD') . "  " . lang('FROM') . " {$period_start} " . lang('TO') . " {$period_end}";
                // get all deleted clients of specific date
                $deleted_clients = $pcs_obj->get_pieces("where `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `is_client` = 1 AND Date(`deleted_at`) BETWEEN '{$period_start}' AND '{$period_end}'");
              } else {
                $title = lang('NOT ASSIGNED');
              }
              // display title
              echo $title;
              ?>
            </h5>
            <hr>
          </header>
          <!-- strst clients table -->
          <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="true" <?php echo !isset($deleted_clients) || count($deleted_clients) <= 10 ? 'data-scroll-y="auto"' : null ?> data-last-td="[-1]" style="width:100%">
            <thead class="primary text-capitalize">
              <tr>
                <th>#</th>
                <th>
                  <?php echo lang('CLT NAME', 'clients') ?>
                </th>
                <th>
                  <?php echo lang('ADDRESS', 'clients') ?>
                </th>
                <th>
                  <?php echo lang('PHONE') ?>
                </th>
                <th>
                  <?php echo lang('THE DIRECTION', 'directions') ?>
                </th>
                <th>
                  <?php echo lang('MAC') ?>
                </th>
                <th class="date-data">
                  <?php echo lang('DELETED DATE') ?>
                </th>
                <th>
                  <?php echo lang('CONTROL') ?>
                </th>
              </tr>
            </thead>
            <tbody id="clientsTbl">
              <?php if (!is_null($deleted_clients)) { ?>
                <?php foreach ($deleted_clients as $index => $client) { ?>
                  <tr>
                    <!-- index -->
                    <td>
                      <?php echo ++$index; ?>
                    </td>
                    <!-- client name -->
                    <td>
                      <?php echo wordwrap(trim($client['full_name'], ' '), 50, "<br>") ?>
                    </td>
                    <!-- client address -->
                    <td>
                      <?php echo wordwrap(trim($client['address'], ' '), 50, "<br>"); ?>
                    </td>
                    <!-- client phone -->
                    <td>
                      <?php
                      $phones = $client['phone'];
                      // check result
                      if (!empty($phones)) {
                        $phone_ex = explode(",", $phones);
                        if (count($phone_ex) > 1) {
                          foreach ($phone_ex as $key => $ph) {
                            echo $ph . "<br>";
                          }
                        } else {
                          echo $phones;
                        }
                      } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang('NOT ASSIGNED') ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- client direction -->
                    <td class="text-capitalize">
                      <?php
                      if (!is_null($client['direction_id']) && !empty($db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $client['direction_id']))) {
                        $dir_name = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = " . $client['direction_id'])[0]['direction_name'];
                      } else {
                        $dir_name = null;
                      }
                      ?>
                      <?php if (!is_null($client['direction_id']) && $client['direction_id'] != 0 && $_SESSION['sys']['dir_update'] == 1 && $dir_name != null) { ?>
                        <a target="_blank" href="<?php echo $nav_up_level ?>directions/index.php?do=show-direction-tree&dir-id=<?php echo base64_encode($client['direction_id']); ?>">
                          <?php echo $dir_name ?>
                        </a>
                      <?php } elseif ($_SESSION['sys']['dir_update'] == 0) { ?>
                        <span>
                          <?php echo $dir_name ?>
                        </span>
                      <?php } else { ?>
                        <span class="text-danger fs-12 fw-bold">
                          <?php echo lang("NOT ASSIGNED") ?>
                        </span>
                      <?php } ?>
                    </td>
                    <!-- mac address -->
                    <td>
                      <?php
                      // check result
                      if (empty($client['mac_add'])) {
                        $mac_addr = lang('NOT ASSIGNED');
                        $mac_class = 'text-danger fs-12 fw-bold';
                      } else {
                        $mac_addr = $client['mac_add'];
                        $mac_class = '';
                      }
                      ?>
                      <span class="<?php echo isset($mac_class) ? $mac_class : '' ?>">
                        <?php echo $mac_addr ?>
                      </span>
                    </td>
                    <!-- deleted date -->
                    <td>
                      <span dir="ltr">
                        <?php echo date_format(date_create($client['deleted_at']), 'h:i:sa, d-m-Y') ?>
                      </span>
                    </td>
                    <!-- control -->
                    <td>
                      <div class="hstack gap-1">
                        <?php if ($_SESSION['sys']['pcs_show'] == 1) { ?>
                          <a class="btn btn-success text-capitalize fs-12 " href="?do=restore&id=<?php echo base64_encode($client['id']); ?>">
                            <i class="bi bi-arrow-clockwise"></i>
                            <?php echo lang('RESTORE') ?>
                          </a>
                        <?php } ?>
                        <?php if ($_SESSION['sys']['pcs_delete'] == 1 && $_SESSION['sys']['isLicenseExpired'] == 0) { ?>
                          <button type="button" class="btn btn-outline-danger text-capitalize form-control bg-gradient fs-12" data-bs-toggle="modal" data-bs-target="#deleteClientModal" id="temp-delete-<?php echo ($index + 1) ?>" data-client-id="<?php echo base64_encode($client['id']) ?>" data-client-name="<?php echo $client['full_name'] ?>" onclick="confirm_delete_client(this, true, true)" style="width: 80px"><i class="bi bi-trash"></i>
                            <?php echo lang('PERMANENT DELETE') ?>
                          </button>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>

</div>


<?php if ($_SESSION['sys']['clients_delete'] == 1 && isset($deleted_clients) && $deleted_clients != null) { ?>
  <?php include_once "delete-client-modal.php"; ?>
<?php } ?>