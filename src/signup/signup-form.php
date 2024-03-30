<div class="signupPageContainer">
  <div class="contentBox" dir="rtl">
    <div class="formBox">
      <div class="formBoxHeader">
        <h2 class="h2">
          <?php echo lang('SIGNUP', $lang_file) ?>
        </h2>
      </div>
      <!-- signup form -->
      <form class="signup-form needs-validation" id="signup-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <!-- first row that contain company info -->
        <div class="mb-4 row row-cols-sm-1">
          <div class="section-header">
            <h4 class="h4">
              <?php echo lang("COMPANY INFO", $lang_file) ?>
            </h4>
          </div>
          <div class="signup-row">
            <!-- company name -->
            <div class="form-floating">
              <input class="form-control w-100" type="text" name="company-name" id="company-name" placeholder="<?php echo lang("COMPANY NAME", $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['company-name'] : null ?>" onblur="is_valid(this, 'company');" required>
              <label for="company-name">
                <?php echo lang("COMPANY NAME", $lang_file) ?>
              </label>
            </div>
            <?php
            if (!isset($_SESSION['request_data']['company_code'])) {
              // flag for check if code is exist or not
              $is_exist_code = false;
              // check if db_obj is created or ot
              $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
              // loop to generate a code that is not exist in database
              do {
                // generate a code
                // first 2 character -> string
                // second 2 character -> numbers
                $company_code = generate_random_string(2) . random_digits(2);
                // count companies that have same code
                $is_exist_code = $db_obj->is_exist("`company_code`", "`companies`", $company_code);
              } while ($is_exist_code);
            }
            ?>
            <!-- company code -->
            <div class="form-floating">
              <input class="form-control w-100" type="text" name="company-code" id="company-code-id" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['company-code'] : $company_code; ?>" placeholder="<?php echo lang("COMPANY CODE", $lang_file) ?>" readonly>
              <label for="company-code">
                <?php echo lang("COMPANY CODE", $lang_file) ?>
              </label>
            </div>
            <!-- company country -->
            <div class="form-floating">
              <?php
              // create an object of Countries class
              $countries_obj = new Countries();
              // get all countries
              $countries = $countries_obj->get_all_countries();
              ?>
              <select class="form-select" name="country" id="country" required>
                <?php if ($countries != null) { ?>
                  <option value="default" disabled selected>
                    <?php echo lang('SELECT COUNTRY', $lang_file) ?>
                  </option>
                  <?php foreach ($countries as $country) { ?>
                    <option value="<?php echo $country['country_id'] ?>" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['country'] == $country['country_id'] ? 'selected' : null  ?>>
                      <?php echo $_SESSION['sys']['lang'] == 'ar' ? $country['country_name_ar'] : $country['country_name_en'] ?>
                    </option>
                  <?php } ?>
                <?php } ?>
              </select>
              <label for="country">
                <?php echo lang("COUNTRY", $lang_file) ?>
              </label>
            </div>
            <!-- company phone -->
            <div class="form-floating">
              <input class="form-control w-100" type="text" name="company-phone" id="company-phone" placeholder="<?php echo lang("PHONE", $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['company-phone'] : null ?>" required>
              <label for="company-phone">
                <?php echo lang("PHONE", $lang_file) ?>
              </label>
            </div>
          </div>
        </div>

        <!-- second row that contain agent info -->
        <div class="mb-4 row row-cols-sm-1">
          <div class="section-header">
            <h4 class="h4">
              <?php echo lang("AGENT INFO IF EXIST", $lang_file) ?>
            </h4>
          </div>
          <div class="signup-row">
            <!-- company agent -->
            <div class="form-floating">
              <?php
              // create an object of Countries class
              $ag_obj = new Agents();
              // get all agents info
              $agents_info = $ag_obj->get_all_agents();
              ?>
              <select class="form-select" name="agent" id="agent" required>
                <option value="default" disabled selected>
                  <?php echo lang('SELECT AGENT', $lang_file) ?>
                </option>
                <?php if ($agents_info != null) { ?>
                  <?php foreach ($agents_info as $key => $agent) { ?>
                    <option value="<?php echo $agent['id'] ?>" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['agent'] == $agent['id'] ? 'selected' : null  ?>>
                      <?php echo strtoupper($agent['company_name']) . " - " . $agent['agent_name'] ?>
                    </option>
                  <?php } ?>
                <?php } ?>
                <option value="null">
                  <?php echo lang('not exist', $lang_file) ?>
                </option>
              </select>
              <label for="agent">
                <?php echo lang("agents", $lang_file) ?>
              </label>
            </div>
          </div>
        </div>

        <!-- third row that contain company info -->
        <div class="mb-4 row row-cols-sm-1 justify-content-center">
          <div class="section-header">
            <h4 class="h4">
              <?php echo lang("personal info", $lang_file) ?>
            </h4>
          </div>
          <div class="signup-row">
            <!-- admin fullname -->
            <div class="mb-3 form-floating">
              <input class="form-control w-100" type="text" name="fullname" id="fullname" placeholder="<?php echo lang("FULLNAME", $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['fullname'] : null ?>" required>
              <label for="fullname">
                <?php echo lang("FULLNAME", $lang_file) ?>
              </label>
            </div>
            <!-- admin phone -->
            <div class="form-floating">
              <input class="form-control w-100" type="text" name="admin-phone" id="admin-phone" placeholder="<?php echo lang("PHONE", $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['admin-phone'] : null ?>" required>
              <label for="admin-phone">
                <?php echo lang("PHONE", $lang_file) ?>
              </label>
            </div>
            <!-- admin email -->
            <div class="form-floating">
              <input class="form-control w-100" type="email" name="admin-email" id="admin-email" placeholder="<?php echo lang("EMAIL", $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['admin-email'] : null ?>" required>
              <label for="admin-email">
                <?php echo lang("EMAIL", $lang_file) ?>
              </label>
            </div>
            <!-- admin gender -->
            <div class="mb-3 form-floating">
              <select class="form-select" name="gender" id="gender" required>
                <option value="default" disabled selected>
                  <?php echo lang("SELECT GENDER", $lang_file) ?>
                </option>
                <option value="0" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['gender'] == 0 ? 'selected' : null  ?>>
                  <?php echo lang("MALE", $lang_file) ?>
                </option>
                <option value="1" <?php echo isset($_SESSION['request_data']) && $_SESSION['request_data']['gender'] == 1 ? 'selected' : null  ?>>
                  <?php echo lang("FEMALE", $lang_file) ?>
                </option>
              </select>
              <label for="gender">
                <?php echo lang("GENDER", $lang_file) ?>
              </label>
            </div>
          </div>
        </div>

        <!-- third row that contain company info -->
        <div class="mb-4 row row-cols-sm-1 justify-content-center" id="admin-info">
          <div class="section-header">
            <h4 class="h4">
              <?php echo lang("admin login info", $lang_file) ?>
            </h4>
          </div>
          <div class="signup-row">
            <!-- admin username -->
            <div class="mb-3 form-floating">
              <input class="form-control w-100" type="text" name="username" id="username" placeholder="<?php echo lang("USERNAME", $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['username'] : null ?>" onblur="is_valid(this, 'username');" required>
              <label for="username">
                <?php echo lang("USERNAME", $lang_file) ?>
              </label>
            </div>
            <!-- admin password -->
            <div class="mb-3 form-floating">
              <input class="form-control w-100" type="password" name="password" id="password" placeholder="<?php echo lang("PASSWORD", $lang_file) ?>" value="<?php echo isset($_SESSION['request_data']) ? $_SESSION['request_data']['password'] : null ?>" onblur="confirm_password(confirm_pass, this, 'admin-info')" data-no-validation="true" required>
              <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
              <label for="password">
                <?php echo lang("PASSWORD", $lang_file) ?>
              </label>
            </div>
            <!-- confirm_pass -->
            <div class="mb-3 form-floating">
              <input class="form-control w-100" type="password" name="confirm_pass" id="confirm_pass" placeholder="<?php echo lang("CONFIRM PASSWORD", $lang_file) ?>" onblur="confirm_password(this, password, 'admin-info')" data-no-validation="true" required>
              <i class="bi bi-eye-slash show-pass show-pass-left text-dark" id="show-pass" onclick="show_pass(this)"></i>
              <label for="confirm_pass">
                <?php echo lang("CONFIRM PASSWORD", $lang_file) ?>
              </label>
            </div>
          </div>
        </div>

        <div class="hstack gap-3 justify-content-end">
          <div>
            <!-- submit -->
            <button type="button" form="signup-form" class="btn btn-primary text-capitalize bg-gradient py-1 fs-12 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="signup-form-btn" onclick="form_validation(this.form, 'submit')">
              <?php echo lang('SIGNUP', $lang_file) ?>
            </button>
          </div>
          <div>
            <!-- submit -->
            <a href="./login.php" class="text-decoration-none text-capitalize bg-gradient py-1 fs-12 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="login-form-btn">
              <?php echo lang('LOGIN', $lang_file) ?>
            </a>
          </div>
          <div>
            <!-- home page -->
            <a href="./" class="text-decoration-none text-capitalize bg-gradient py-1 fs-12 <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'me-auto' : 'ms-auto' ?>" id="login-form-btn">
              <?php echo lang('HOME') ?>
            </a>
          </div>
        </div>
      </form>
      <hr>
      <div>
        <p>
          <span>
            <?php echo lang('VISIT WEBSITE', $lang_file) ?>
          </span>
          <a href="<?php echo $conf['app_url'] ?>" target="_blank">
            <?php echo lang('FROM HERE', $lang_file) ?>&nbsp;<i class="bi bi-arrow-up-left-square"></i>
          </a>
        </p>

        <p class="mt-4">
          <?php
          $target_lang = $page_dir == 'ltr' ? 'ar' : 'en';
          $target_flag = $page_dir == 'ltr' ? 'sa' : 'us';
          ?>
          <?php if (false) { ?>
            <a href="?lang=<?php echo $target_lang ?>">
              <img src="<?php echo "{$treenet_assets}countries_flags/4x3/{$target_flag}.svg" ?>" width="20" alt="<?php echo $target_lang ?>">
              <span><?php echo lang($target_lang) ?></span>
            </a>
          <?php } ?>
        </p>
      </div>
    </div>
  </div>
</div>