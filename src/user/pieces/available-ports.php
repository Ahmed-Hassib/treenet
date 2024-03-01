<?php
// create an object of RouterosAPI
$api_opj = new RouterosAPI();
// connect to mikrotik api
$is_connected = $api_obj->connect($_SESSION['sys']['mikrotik']['remote_ip'], $_SESSION['sys']['mikrotik']['username'], $_SESSION['sys']['mikrotik']['password']);
// company name
$company_name = str_replace_whitespace($_SESSION['sys']['company_name']);
// check connection to get roles
if ($is_connected) {
  // get roles from api
  $available_roles = $api_obj->comm(
    "/ip/firewall/nat/print",
    array(
      "?comment" => "mohamady",
      "?disabled" => "false"
    )
  );
}
?>
<!-- start add new user page -->
<div class="container" dir="<?php echo $page_dir ?>">
  <section class="section-block">
    <header class="section-header">
      <h2>
        <?php # echo lang('PREPARING MIKROTIK CONFIRM') 
        ?>
        <?php echo lang('AVAILABLE PORTS') ?>
      </h2>
      <hr>
      <?php if ($is_connected && count($available_roles) < 10) { ?>
        <button type="button" class="btn btn-outline-primary py-0 floating-button floating-button-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?>" onclick="add_new_port('.card.available_ports_card', 'prepare-ips-section', this)">
          <i class="bi bi-plus"></i>
          <span>
            <?php echo lang('OPEN NEW') ?>
          </span>
        </button>
      <?php } ?>
    </header>
    <?php if ($is_connected) { ?>
      <!-- success alert -->
      <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">
          <i class="bi bi-check-circle-fill"></i>
          <?php echo lang('MIKROTIK SUCCESS') ?>
        </h4>
        <!-- <hr> -->
        <p class="mb-0">
          <?php echo lang('SYS TREE MSG'); ?>
        </p>
      </div>

      <!-- roles in mikrotik -->
      <section class="prepare-ips-section" id="prepare-ips-section">
        <?php if (!empty($available_roles) || count($available_roles) != 0) { ?>
          <?php for ($i = 0; $i < $conf['available_ports']; $i++) { ?>
            <?php if (array_key_exists($i, $available_roles)) { ?>
              <div class="card available_ports_card text-center">
                <div class="card-header">
                  <?php echo strtoupper('port') . " #" . ($i + 1) ?>
                </div>
                <div class="card-body">
                  <form action="?do=mikrotik" method="post" onchange="form_validation(this)">
                    <input type="hidden" name="id" value="<?php echo base64_encode($available_roles[$i]['.id']) ?>">
                    <div class="row row-cols-sm-1 g-3 mb-3">
                      <div class="col-12 form-floating form-floating-right mb-3">
                        <input type="text" class="form-control" id="device-ip" name="ip" value="<?php echo trim($available_roles[$i]['to-addresses'], "\n\r\t\v\x") ?>" placeholder="xxx.xxx.xxx.xxx" required>
                        <label for="device-ip">
                          <?php echo lang('IP') ?>
                        </label>
                      </div>
                      <div class="col-12 form-floating form-floating-right">
                        <input type="text" class="form-control" id="device-port" name="port" value="<?php echo trim($available_roles[$i]['to-ports'], "\n\r\t\v\x") ?>" placeholder="text" required>
                        <label for="device-port">
                          <?php echo lang('PORT') ?>
                        </label>
                      </div>
                      <div class="col-12">
                        <div class="row g-1">
                          <button type="button" class="col-sm-12 btn btn-primary" onclick="form_validation(this.form, 'submit')">
                            <?php echo lang('CONFIRM') ?>
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-body-secondary">
                  you can open this device from
                  <a href="<?php echo trim($available_roles[$i]['to-ports'], "\n\r\t\v\x") == '80' ? 'http' : 'https' ?>://leadergroupegypt.com:<?php echo $available_roles[$i]['dst-port'] ?>" target="_blank">here</a>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
        <?php } else { ?>
          <div class="card available_ports_card text-center">
            <div class="card-header">
              <?php echo strtoupper('port') . " #1" ?>
            </div>
            <div class="card-body">
              <form action="?do=mikrotik" method="post" onchange="form_validation(this)">
                <div class="row row-cols-sm-1 g-3 mb-3">
                  <div class="col-12 form-floating form-floating-right mb-3">
                    <input type="text" class="form-control" id="device-ip" name="ip" placeholder="xxx.xxx.xxx.xxx" required>
                    <label for="device-ip">
                      <?php echo lang('IP') ?>
                    </label>
                  </div>
                  <div class="col-12 form-floating form-floating-right">
                    <input type="text" class="form-control" id="device-port" name="port" placeholder="port" required>
                    <label for="device-port">
                      <?php echo lang('PORT') ?>
                    </label>
                  </div>
                  <div class="col-12">
                    <div class="row g-1">
                      <button type="button" class="col-sm-12 btn btn-primary" onclick="form_validation(this.form, 'submit')">
                        <?php echo lang('CONFIRM') ?>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <?php } ?>
      </section>
    <?php } else { ?>
      <div class="alert alert-danger">
        <div class="alert-heading">
          <h5 class="h5 text-capitalize">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?php echo lang('MIKROTIK FAILED') ?>
          </h5>
        </div>
      </div>
    <?php } ?>
  </section>
</div>