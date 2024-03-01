<?php 
// check permission
if (isset($_SESSION['sys']) && $_SESSION['sys']['is_tech'] == 0) {
  // get new version id
  $new_version_id = $_GET['new-version-id'];
  // compare between current version and new version
  if ($new_version_id != $_SESSION['sys']['curr_version_id']) {
    // create an object of Companies class
    $cmp_obj = new Company();
    // call upgrade version function
    $upgrade_info = $cmp_obj->upgrade_version($new_version_id, base64_decode($_SESSION['sys']['company_id']));
    // is_upgraded
    $is_upgraded = $upgrade_info[0];
    // number of effected rows
    $eff_rows = $upgrade_info[1];
    // check if upgraded
    if ($is_upgraded == true) {
      $msg = '<div>'.lang('THE VERSION HAS BEEN UPGRADED SUCCESSFULLY', @$_SESSION['sys']['lang']).'</div>';
    } else {
      $msg = '<div>'.lang('A PROPLEM HAS BEEN HAPPEND WHILE UPGRADING VERSION', @$_SESSION['sys']['lang']).'</div>';
    }

    if (!isset($session_obj)) {
      // create an object of Session class
      $session_obj = new Session();
    }
    // get user info
    $user_info = $session_obj->get_user_info($_SESSION['sys']['UserID']);
    // check if done
    if ($user_info[0] == true) {
      // set user session
      $session_obj->set_user_session($user_info[1]);
    }
  } else {
    $msg = '<div>'.lang('THE VERSION IS UP TO DATE', @$_SESSION['sys']['lang']).'</div>';
  }
  // call redirect home function
  redirect_home($msg, "back");
} else {
  // include_once error page 
  include_once $globmod . 'permission-error.php';
}