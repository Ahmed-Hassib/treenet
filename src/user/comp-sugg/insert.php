<pre dir='ltr'><?php print_r($_POST) ?></pre>
<pre dir='ltr'><?php print_r($_FILES) ?></pre>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = base64_decode($_SESSION['sys']['UserID']);
  $company_id = base64_decode($_SESSION['sys']['company_id']);
  $type = isset($_POST['type']) && !empty($_POST['type']) ? base64_decode(trim($_POST['type'])) : null;
  $comment = isset($_POST['comment']) && !empty($_POST['comment']) ? trim($_POST['comment']) : null;
  
  // available types
  $available_types = ['comp', 'sugg'];
  
  // validate the form
  $err_arr = array();   // error array
  
  // check type
  if (is_null($type)) {
    $err_arr[] = 'type null';
  } elseif (!in_array($type, $available_types)) {
    $err_arr[] = 'type not right';
  }

  // check comment
  if (is_null($comment)) {
    $err_arr[] = 'comment null';
  }

  if (empty($err_arr)) {
    // create an object of CompSUgg class
    $comp_sugg_obj = new CompSugg();
    // get next id
    $id = $comp_sugg_obj->get_next_id("`jsl_db`", "`comp_sugg`");
    // insert a new comp or sugg
    $is_inserted = $comp_sugg_obj->insert_new(array($company_id, $user_id, $comment, $type));
    // check if inserted
    if ($is_inserted) {
      // prepare flash session variables
      $_SESSION['flash_message'] = "{$type} inserted";
      $_SESSION['flash_message_icon'] = 'bi-check-circle-fill';
      $_SESSION['flash_message_class'] = 'success';
      $_SESSION['flash_message_status'] = true;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    } else {
      // prepare flash session variables
      $_SESSION['flash_message'] = 'query problem';
      $_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'] = 'danger';
      $_SESSION['flash_message_status'] = false;
      $_SESSION['flash_message_lang_file'] = $lang_file;
    }

    // assign media files to variable
    $media_arr = isset($_FILES['comp-sugg-media']) ? $_FILES['comp-sugg-media'] : null;

    // chekc if any media have been added
    if (!is_null($media_arr)) {
      // extract media array
      extract($media_arr);
      // check file size and max file size and error
      if ($size > 0 && $error == 0 && $size <= $comp_sugg_obj->max_file_size) {
        // root media path
        $media_path = $uploads . "comp-sugg/";
        // check path
        if (!file_exists($media_path) && !is_dir($media_path)) {
          mkdir($media_path);
        }
        // assign current user company folder
        $media_path .= base64_decode($_SESSION['sys']['company_id']) . "/";
        // check if current user company folder was exists
        if (!file_exists($media_path) && !is_dir($media_path)) {
          mkdir($media_path);
        }
        // process new comp_sugg
        $media_temp = explode('.', $name);
        $media_temp[0] = 'comp_sugg_' . date('dmY') . '_' . date('His') . '_' . rand(00000000, 99999999);
        $media_name = join('.', $media_temp);
        // move media to comp/sugg folder
        move_uploaded_file($tmp_name, $media_path . $media_name);
        // check id
        if (!is_null($id)) {
          // insert comp & sugg media into database
          $comp_sugg_obj->insert_media($id, $media_name, strpos($type, 'image') !== false ? 'img' : 'video');
        } 
      }
    }
  } else {
    foreach ($err_arr as $key => $error) {
      $_SESSION['flash_message'][$key] = strtoupper($error);
      $_SESSION['flash_message_icon'][$key] = 'bi-exclamation-triangle-fill';
      $_SESSION['flash_message_class'][$key] = 'danger';
      $_SESSION['flash_message_status'][$key] = false;
      $_SESSION['flash_message_lang_file'][$key] = $lang_file;
    }
  }
  // redirect to the previous page
  redirect_home(null, 'back', 0);
} else {
  // include permission error module
  include_once $globmod . 'permission-error.php';
}
