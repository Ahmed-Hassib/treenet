<?php
// create an object of Database class
$db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");
// get next company id and next user id
$company_id = $db_obj->get_next_id('jsl_db', 'companies');
$license_id = $db_obj->get_next_id('jsl_db', 'license');
$user_id = $db_obj->get_next_id('jsl_db', 'users');
// get company info
$company_name = isset($_POST['company-name']) && !empty(trim($_POST['company-name'])) ? trim($_POST['company-name']) : null;
$company_code = isset($_POST['company-code']) && !empty(trim($_POST['company-code'])) ? trim($_POST['company-code']) : null;
$manager_name = isset($_POST['fullname']) && !empty(trim($_POST['fullname'])) ? trim($_POST['fullname']) : null;
$company_phone = isset($_POST['company-phone']) && !empty(trim($_POST['company-phone'])) ? trim($_POST['company-phone']) : null;
$country = isset($_POST['country']) && !empty($_POST['country']) ? $_POST['country'] : null;
$agent = $_POST['agent'];
// admin of this company info
$fullname = $manager_name;
$username = isset($_POST['username']) && !empty(trim($_POST['username'])) ? trim($_POST['username']) : null;
$password = isset($_POST['password']) && !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
$confirm_password = isset($_POST['confirm_pass']) && !empty(trim($_POST['confirm_pass'])) ? $_POST['confirm_pass'] : null;
$admin_phone = isset($_POST['admin-phone']) && !empty(trim($_POST['admin-phone'])) ? trim($_POST['admin-phone']) : null;
$admin_email = isset($_POST['admin-email']) && !empty($_POST['admin-email']) ? $_POST['admin-email'] : null;
$enc_password = sha1($password);
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;

// array of error
$err_arr = [];

// check company name
if (is_null($company_name)) {
  $err_arr[] = 'company empty';
}

// check manager name
if (is_null($manager_name)) {
  $err_arr[] = 'manager empty';
}

if (!is_triple_parts_name($manager_name)) {
  $err_arr[] = 'manager not triple';
}

// check manager phone
if (is_null($company_phone)) {
  $err_arr[] = 'phone empty';
}

// check country
if (is_null($country)) {
  $err_arr[] = 'country empty';
}

// check fullname
if (is_null($fullname)) {
  $err_arr[] = 'fullname empty';
}

// // check manager name if contains 3 parts
// if (!preg_match('/\w+\s\w+\s\w+/', $fullname)) {
//   $err_arr[] = 'admin not triple';
// }

// check username
if (is_null($username)) {
  $err_arr[] = 'username empty';
}

// check password
if (is_null($password)) {
  $err_arr[] = 'password empty';
} elseif ($password != $confirm_password) {
  $err_arr[] = 'password not equal';
}

// check email
if (is_null($admin_email)) {
  $err_arr[] = 'email empty';
} elseif (filter_var($_POST['admin-email'], FILTER_VALIDATE_EMAIL) === false) {
  $err_arr[] = 'invalid email';
} elseif($db_obj->is_exist("`email`", "`users`", $admin_email)) {
  $err_arr[] = 'email duplicated';
}

// check gender
if (is_null($gender) && $gender != 0) {
  $err_arr[] = 'gender empty';
}

if (empty($err_arr)) {
  // array of success message
  $succ_arr = array();
  // check company name is exists
  $is_exist_company_name = $db_obj->is_exist("`company_name`", "`companies`", $company_name);
  // if name was exist
  if (!$is_exist_company_name) {
    // create an object of Registration class
    $reg_obj =  new Registration();
    // add new company
    $is_inserted_company = $reg_obj->add_new_company(array($company_name, $company_code, $manager_name, $company_phone, $country, $agent, get_date_now()));
    // check if company was added
    if ($is_inserted_company) {
      // add a success message
      $succ_arr[] = 'company inserted';
      // calculate expire date after one month
      // date of today
      $today = Date("Y-m-d");
      // license period
      $period = ' + 1months';
      // expire date
      $expire_date = Date("Y-m-d", strtotime($today . $period));
      // add license
      $is_inserted_license = $reg_obj->add_company_license(array($company_id, get_date_now(), $expire_date));
      // check if license was inserted
      if ($is_inserted_license) {
        // add a success message
        $succ_arr[] = 'license inserted';
        // insert admin info
        $is_inserted_admin_info = $reg_obj->add_company_admin(array($company_id, $username, $enc_password, $admin_email, $fullname, $admin_phone, $gender));
        // check if admin info is inserted
        if ($is_inserted_admin_info) {
          // assign a success message 
          $succ_arr[] = 'admin inserted';
          // add admin permission
          $is_inserted_admin_permission = $reg_obj->add_admin_permission($user_id);
          // check if permission was inserted
          if ($is_inserted_admin_permission) {
            // assign success message
            $succ_arr[] = 'permission inserted';
            // redirect to url
            $url = "./login.php?username=$username&password=$password&company-code=$company_code";
            // assign session flash messages
            assign_message($succ_arr, 'bi-check-circle-fill', 'success', true, 'login');
          } else {
            // assign an error
            $err_arr[] = 'QUERY PROBLEM';
            // delete company
            $reg_obj->delete_company($company_id);
            // delete license
            $reg_obj->delete_company_license($license_id);
            // delete license
            $reg_obj->delete_company_admin($user_id);
          }
        } else {
          // assign an error
          $err_arr[] = 'QUERY PROBLEM';
          // delete company
          $reg_obj->delete_company($company_id);
          // delete license
          $reg_obj->delete_company_license($license_id);
        }
      } else {
        // assign an error
        $err_arr[] = 'QUERY PROBLEM';
        // delete company
        $reg_obj->delete_company($company_id);
      }
    } else {
      // assign an error
      $err_arr[] = 'QUERY PROBLEM';
    }
  } else {
    $err_arr[] = 'NAME EXIST';
  }

  if (!empty($err_arr)) {
    // assign POST variable values to session
    $_SESSION['request_data'] = $_POST;
    // assign session flash messages
    assign_message($err_arr, 'bi-exclamation-triangle-fill', 'danger', false, 'global_');
  }
} else {
  // assign POST variable values to session
  $_SESSION['request_data'] = $_POST;
  // assign session flash messages
  assign_message($err_arr, 'bi-exclamation-triangle-fill', 'danger', false, 'login');
}

// redirect to previous page
redirect_home(null, isset($url) && !empty($url) ? $url : 'back', 0);

function assign_message($arr, $icon, $class, $flag, $lang_file)
{
  // loop on form error array
  foreach ($arr as $key => $error) {
    $_SESSION['flash_message'][$key] = strtoupper($error);
    $_SESSION['flash_message_icon'][$key] = $icon;
    $_SESSION['flash_message_class'][$key] = $class;
    $_SESSION['flash_message_status'][$key] = $flag;
    $_SESSION['flash_message_lang_file'][$key] = $lang_file;
  }
}
