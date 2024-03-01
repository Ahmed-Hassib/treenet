<?php if (isset($_GET['address']) && !empty($_GET['address'])) { ?>
  <!-- start add new user page -->
  <div class="container" dir="<?php echo $page_dir ?>">
    <section class="section-block">
      <header class="section-header">
        <h2>
          <?php echo lang('PREPARING MIKROTIK CONFIRM') ?>
        </h2>
        <hr>
      </header>

      <section class="prepare-ips-section">
        <div class="card text-center">
          <div class="card-header">
            port 1
          </div>
          <div class="card-body">
            <!-- confirmation form -->
            <form action="?do=mikrotik" method="post" onchange="form_validation(this)">
              <div class="row row-cols-sm-1 g-3 mb-3">
                <div class="col-12 form-floating form-floating-right mb-3">
                  <input type="text" class="form-control" id="device-ip" name="ip"
                    value="<?php echo trim($_GET['address'], "\n\r\t\v\x") ?>" placeholder="name@example.com" required>
                  <label for="device-ip">
                    <?php echo lang('IP') ?>
                  </label>
                </div>
                <div class="col-12 form-floating form-floating-right">
                  <input type="text" class="form-control" id="device-port" name="port"
                    value="<?php echo isset($_GET['port']) && !empty($_GET['port']) ? trim($_GET['port'], "\n\r\t\v\x") : '' ?>"
                    placeholder="text" required>
                  <label for="device-port">
                    <?php echo lang('PORT') ?>
                  </label>
                </div>
                <div class="col-12">
                  <button type="button" class="btn btn-primary w-100" onclick="form_validation(this.form, 'submit')">
                    <?php echo lang('CONFIRM') ?>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="card-footer text-body-secondary">
            status
          </div>
        </div>
      </section>
    </section>
  </div>
<?php } ?>