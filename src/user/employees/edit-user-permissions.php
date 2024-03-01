<div class="user_info">
  <div class="permission">
    <div class="permission_header"><?php echo lang('EMPLOYEES') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['user_add'] == 1 ? 'checked' : '' ?> value="1" name="userAdd" id="usersPage1">
        <label class="form-check-label" for="usersPage1">
          <?php echo lang("ADD") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['user_update'] == 1 ? 'checked' : '' ?> value="1" name="userUpdate" id="usersPage2">
        <label class="form-check-label" for="usersPage2">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['user_delete'] == 1 ? 'checked' : '' ?> value="1" name="userDelete" id="usersPage3">
        <label class="form-check-label" for="usersPage3">
          <?php echo lang("DELETE") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['user_show'] == 1 ? 'checked' : '' ?> value="1" name="userShow" id="usersPage4">
        <label class="form-check-label" for="usersPage4">
          <?php echo lang("SHOW") ?>
        </label>
      </div>
    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('PIECES') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['pcs_add'] == 1 ? 'checked' : '' ?> value="1" name="pcsAdd" id="pcsPage1">
        <label class="form-check-label" for="pcsPage1">
          <?php echo lang("ADD") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['pcs_update'] == 1 ? 'checked' : '' ?> value="1" name="pcsUpdate" id="pcsPage2">
        <label class="form-check-label" for="pcsPage2">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['pcs_delete'] == 1 ? 'checked' : '' ?> value="1" name="pcsDelete" id="pcsPage3">
        <label class="form-check-label" for="pcsPage3">
          <?php echo lang("DELETE") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['pcs_show'] == 1 ? 'checked' : '' ?> value="1" name="pcsShow" id="pcsPage4">
        <label class="form-check-label" for="pcsPage4">
          <?php echo lang("SHOW") ?>
        </label>
      </div>
    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('CLIENTS') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['clients_add'] == 1 ? 'checked' : '' ?> value="1" name="clientsAdd" id="clientsPage1">
        <label class="form-check-label" for="clientsPage1">
          <?php echo lang("ADD") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['clients_update'] == 1 ? 'checked' : '' ?> value="1" name="clientsUpdate" id="clientsPage2">
        <label class="form-check-label" for="clientsPage2">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['clients_delete'] == 1 ? 'checked' : '' ?> value="1" name="clientsDelete" id="clientsPage3">
        <label class="form-check-label" for="clientsPage3">
          <?php echo lang("DELETE") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['clients_show'] == 1 ? 'checked' : '' ?> value="1" name="clientsShow" id="clientsPage4">
        <label class="form-check-label" for="clientsPage4">
          <?php echo lang("SHOW") ?>
        </label>
      </div>

    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('CONNECTION TYPES') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['connection_add'] == 1 ? 'checked' : '' ?> value="1" name="connectionAdd" id="connectionPage1">
        <label class="form-check-label" for="connectionPage1">
          <?php echo lang("ADD") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['connection_update'] == 1 ? 'checked' : '' ?> value="1" name="connectionUpdate" id="connectionPage2">
        <label class="form-check-label" for="connectionPage2">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['connection_delete'] == 1 ? 'checked' : '' ?> value="1" name="connectionDelete" id="connectionPage3">
        <label class="form-check-label" for="connectionPage3">
          <?php echo lang("DELETE") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['connection_show'] == 1 ? 'checked' : '' ?> value="1" name="connectionShow" id="connectionPage4">
        <label class="form-check-label" for="connectionPage4">
          <?php echo lang("SHOW") ?>
        </label>
      </div>

    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('DIRECTIONS') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : ''  ?> <?php echo $user_info['dir_add'] == 1 ? 'checked' : '' ?> value="1" name="dirAdd" id="dirPage1">
        <label class="form-check-label" for="dirPage1">
          <?php echo lang("ADD") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['dir_update'] == 1 ? 'checked' : '' ?> value="1" name="dirUpdate" id="dirPage2">
        <label class="form-check-label" for="dirPage2">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['dir_delete'] == 1 ? 'checked' : '' ?> value="1" name="dirDelete" id="dirPage3">
        <label class="form-check-label" for="dirPage3">
          <?php echo lang("DELETE") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['dir_show'] == 1 ? 'checked' : '' ?> value="1" name="dirShow" id="dirPage4">
        <label class="form-check-label" for="dirPage4">
          <?php echo lang("SHOW") ?>
        </label>
      </div>

    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('MALS') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['mal_add'] == 1 ? 'checked' : '' ?> value="1" name="malAdd" id="malAdd">
        <label class="form-check-label" for="malAdd">
          <?php echo lang("ADD") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['mal_update'] == 1 ? 'checked' : '' ?> value="1" name="malUpdate" id="malUpdate">
        <label class="form-check-label" for="malUpdate">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['mal_delete'] == 1 ? 'checked' : '' ?> value="1" name="malDelete" id="malDelete">
        <label class="form-check-label" for="malDelete">
          <?php echo lang("DELETE") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['mal_show'] == 1 ? 'checked' : '' ?> value="1" name="malShow" id="malShow">
        <label class="form-check-label" for="malShow">
          <?php echo lang("SHOW") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['mal_review'] == 1 ? 'checked' : '' ?> value="1" name="malReview" id="malReview">
        <label class="form-check-label" for="malReview">
          <?php echo lang("RATING") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['mal_media_delete'] == 1 ? 'checked' : '' ?> value="1" name="malMediaDelete" id="malMediaDelete">
        <label class="form-check-label" for="malMediaDelete">
          <?php echo lang("DELETE MEDIA") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['mal_media_download'] == 1 ? 'checked' : '' ?> value="1" name="malMediaDownload" id="malMediaDownload">
        <label class="form-check-label" for="malMediaDownload">
          <?php echo lang("DOWNLOAD MEDIA") ?>
        </label>
      </div>
    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('COMBS') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['comb_add'] == 1 ? 'checked' : '' ?> value="1" name="combAdd" id="combAdd">
        <label class="form-check-label" for="combAdd">
          <?php echo lang("ADD") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['comb_update'] == 1 ? 'checked' : '' ?> value="1" name="combUpdate" id="combUpdate">
        <label class="form-check-label" for="combUpdate">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['comb_delete'] == 1 ? 'checked' : '' ?> value="1" name="combDelete" id="combDelete">
        <label class="form-check-label" for="combDelete">
          <?php echo lang("DELETE") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['comb_show'] == 1 ? 'checked' : '' ?> value="1" name="combShow" id="combShow">
        <label class="form-check-label" for="combShow">
          <?php echo lang("SHOW") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['comb_review'] == 1 ? 'checked' : '' ?> value="1" name="combReview" id="combReview">
        <label class="form-check-label" for="combReview">
          <?php echo lang("RATING") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['comb_media_delete'] == 1 ? 'checked' : '' ?> value="1" name="combMediaDelete" id="combMediaDelete">
        <label class="form-check-label" for="combMediaDelete">
          <?php echo lang("DELETE MEDIA") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['comb_media_download'] == 1 ? 'checked' : '' ?> value="1" name="combMediaDownload" id="combMediaDownload">
        <label class="form-check-label" for="combMediaDownload">
          <?php echo lang("DOWNLOAD MEDIA") ?>
        </label>
      </div>
    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('MIKROTIK INFO', 'settings') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['change_mikrotik'] == 1 ? 'checked' : '' ?> value="1" name="changeMikrotikInfo" id="changeMikrotikInfo">
        <label class="form-check-label" for="changeMikrotikInfo">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('COMPANY IMG') ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['change_company_img'] == 1 ? 'checked' : '' ?> value="1" name="changeCompanyImg" id="changeCompanyImg">
        <label class="form-check-label" for="changeCompanyImg">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
    </div>
  </div>
  <div class="permission">
    <div class="permission_header"><?php echo lang('PERMISSIONS', $lang_file) ?></div>
    <div class="permission_content">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['permission_update'] == 1 ? 'checked' : '' ?> value="1" name="permissionUpdate" id="permissionUpdate">
        <label class="form-check-label" for="permissionUpdate">
          <?php echo lang("EDIT") ?>
        </label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" <?php echo $_SESSION['sys']['user_update'] == 0 || $_SESSION['sys']['permission_update'] == 0 ? 'disabled' : '' ?> <?php echo $user_info['permission_show'] == 1 ? 'checked' : '' ?> value="1" name="permissionShow" id="permissionShow">
        <label class="form-check-label" for="permissionShow">
          <?php echo lang("SHOW") ?>
        </label>
      </div>
    </div>
  </div>
</div>