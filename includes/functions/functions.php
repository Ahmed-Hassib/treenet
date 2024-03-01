<?php

/**
 * get_page_tilte function v2.0.5
 * This function not accept parameters
 * Contain global variable can be access from anywhere
 * get title page from the page and display it
 */
function get_page_tilte($lang_file)
{
  global $page_title; // page title
  global $page_subtitle; // page title
  // check if set or not
  if (isset($page_title)) {
    $title = strtoupper(lang(strtoupper($page_title), $lang_file));
    // check sub title
    if (isset($page_subtitle) && !empty($page_subtitle)) {
      $title .= " | " . strtoupper(lang(strtoupper($page_subtitle), $lang_file));
    }
  } else {
    $title = lang('NOT ASSIGNED');
  }
  // display title
  echo $title;
}

/**
 * redirect_home function v2
 * This function accepts parameters`````` 
 * $msg => echo the error message
 * $seconds => seconds before redirect
 */
function redirect_home($msg = null, $url = null, $seconds = 3)
{
  // check the url
  if ($url == null) {
    $target_url = '../dashboard/index.php';
  } else {
    if ($url == 'back') {
      $target_url = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../dashboard/index.php';
    } else {
      $target_url = $url;
    }
  }
  // redirect page
  header("refresh:$seconds;url=$target_url");
  // check if empty message
  if (!empty($msg) && $msg != null) {
    echo $msg;
  }
  // show redirect messgae
  echo "<div dir='" . (@$_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr') . "' >" . lang('REDIRECT AUTO') . " $seconds " . lang('SECOND') . "</div>";
  // exit
  exit();
}


/**
 * build_direction_tree function v1
 * This function used to build a tree view function
 * $arr => data array from the database
 * $parent => parent id
 * $level => tree level [0 is default]
 * $prelevel => tree prelevel [-1 is default]
 */
function build_direction_tree($arr, $parent, $level = 0, $prelevel = -1, $nav_up_level = 1)
{
  foreach ($arr as $id => $data) {
    if ($parent == $data['source_id']) {
      // check if this record is main
      $data['src'] = $parent == 0 ? $data['ip'] : $arr[$parent]['ip'];
      // check tree level
      if ($level > $prelevel) {
        if ($level == 0 && count($arr) < 15) {
          echo "<ul class='justify-content-center'>";
        } else {
          echo "<ul>";
        }
      }
      if ($level == $prelevel) {
        echo "</li>";
      }

      $node_url = str_repeat("../", $nav_up_level) . "pieces/index.php?do=show-piece&dir-id=" . base64_encode($data['direction_id']) . "&src-id=" . base64_encode($data['id']);

      // show data
      echo "<li>";
      echo "<a href='$node_url'>";
      if ($data['ip'] != '0.0.0.0') {
        echo "<span class='device-status'>";
        echo "<span class='ping-preloader ping-preloader-table position-relative'>";
        echo "<span class='ping-spinner ping-spinner-table spinner-grow spinner-border'></span>";
        echo "</span>";
        echo "<span class='ping-status'></span>";
        echo "<span class='pcs-ip' data-pcs-ip=" . $data['ip'] . " id=" . $data['ip'] . ">" . $data['full_name'] . "<br>" . $data['ip'] . "</span>";
        echo '</span>';
      } else {
        echo "<span id=" . $data['ip'] . ">" . $data['full_name'] . "<br>" . $data['ip'] . "</span>";
      }
      echo "</a>";

      if ($level > $prelevel) {
        $prelevel = $level;
      }

      $level++;
      build_direction_tree($arr, $id, $level, $prelevel);
      $level--;
    }
  }
  if ($level == $prelevel) {
    echo "</li></ul>";
  }
}


/**
 * restore_backup function v1
 * used to restore the backup
 * 
 */
function restore_backup($file)
{
  // set limit for execution process
  set_time_limit(5000);
  global $con; // connection to database
  // check if the file is exist or not 
  if (file_exists($file)) {
    // empty query
    $query = "";
    // try .. catch
    try {
      // open the file with read mode
      $handle = fopen($file, "r");
      // append the content to the query
      $query = fread($handle, filesize($file));
      // prepare the query
      $stmt = $con->prepare($query);
      // execute the query
      $stmt->execute();
      // echo true
      return true;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
}




/**
 * // create_logs function v1
 * accepts 2 param
 * $username => username of owner of the log
 * $msg      => log message
 * $type     => [1] info -> default case
 *              [2] warning
 *              [3] danger
 */
function create_logs($username, $msg, $type = 1)
{
  // get type of log
  switch ($type) {
    case 1:
      $typeName = "info";
      break;
    case 2:
      $typeName = "warning";
      break;
    case 3:
      $typeName = "danger";
      break;
  }
  // log
  $log = "[" . $username . "@" . Date('d/m/Y h:ia') . " ~ " . $typeName . " msg]:" . $msg . ".\n";
  // location
  $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

  // check file location
  if (file_exists($DOCUMENT_ROOT . "/app/data/log/") && is_dir($DOCUMENT_ROOT . "/app/data/log/")) {
    $fileLocation = $DOCUMENT_ROOT . "/app/data/log/";
  } elseif (file_exists($DOCUMENT_ROOT . "data/log/") && is_dir($DOCUMENT_ROOT . "data/log/")) {
    $fileLocation = $DOCUMENT_ROOT . "data/log/";
  }

  // check the fileLocation
  if (!file_exists($fileLocation) && !is_dir($fileLocation)) {
    mkdir($fileLocation);
  }
  $filename = "log-" . Date('Ymd') . "-" . Date('Ymd') . ".txt";
  $file = $fileLocation . $filename;
  // open file with append mode
  $handle = fopen($file, "aw+");
  // write in file
  fwrite($handle, $log);
  // close the file
  fclose($handle);
}



/**
 * convert_ip function
 */
function add_zeros($ipSlice)
{
  return substr('000' . $ipSlice, -3);
}

function convert_ip($ip)
{
  return join("", array_map('add_zeros', explode(".", $ip)));
}


/**
 * bg_progress function
 * return background color depend on value
 */
function bg_progress($val)
{
  // get the progress bar color
  if ($val >= 0 && $val <= 10) {
    $bg_color = "bg-danger";
  } elseif ($val > 10 && $val <= 25) {
    $bg_color = "bg-warning";
  } elseif ($val > 25 && $val < 70) {
    $bg_color = "bg-primary";
  } else {
    $bg_color = "bg-success";
  }
  // return bg_color
  return $bg_color;
}

/**
 * get_time_now function
 * return the current time
 */
function get_time_now($formate = null)
{
  $timestamp = strtotime(date('H:i:s')) + 60 * 60; // for summer time
  $timestamp = strtotime(date('H:i:s')); // for winter time
  return $formate != null ? date($formate, $timestamp) : date('H:i:s', $timestamp);
}

/**
 * get_date_now function
 * return the current date
 */
function get_date_now($formate = null)
{
  return $formate != null ? date($formate) : date('Y-m-d');
}

/**
 * random_digits function
 * accepts length of random digits
 */
function random_digits($length = 5)
{
  $digits = '';
  $numbers = range(0, 9);
  shuffle($numbers);
  for ($i = 0; $i < $length; $i++)
    $digits .= $numbers[$i];
  return $digits;
}

function generate_random_string($length = 5)
{
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[random_int(0, $charactersLength - 1)];
  }
  return $randomString;
}


// // ping to an ip and read ping result line by line
// function ping($ip, $c = 1)
// {
//   // Set the maximum execution time to 5 minutes
//   set_time_limit(300);

//   // check operating system
//   if (strtolower(PHP_OS) == 'winnt') {
//     $ping_cmd = "ping -n $c $ip";
//   } else {
//     $ping_cmd = "ping -c $c $ip";
//   }

//   // execute the ping command
//   $ping = exec($ping_cmd, $output, $status);

//   // return result
//   return array(
//     "ping" => $ping,
//     "output" => $output,
//     "status" => $status
//   );
// }

/**
 * function prepare_pcs_datatables v1
 * is used to prepared data and remove all key numbers
 * accepts 1 param => all_data
 */
function prepare_pcs_datatables($all_data, $lang_file)
{
  // create parent array
  $res_arr = array();
  // loop on data
  foreach ($all_data as $key_ => $data) {
    // loop on child data
    foreach ($data as $key => $value) {
      // chekc if key is string
      if (is_string($key)) {
        // check key
        if ($key == 'direction_id') {
          $res_arr[$key_]['direction_name'] = get_dir_name($value);
        } elseif ($key == 'source_id') {
          $res_arr[$key_]['source_name'] = $value == 0 ? get_src_name($data['id']) : get_src_name($value);
        } elseif ($key == 'alt_source_id' && $value != -1) {
          $res_arr[$key_]['alt_source_name'] = $value == 0 ? get_src_name($data['id']) : get_src_name($value);
        } elseif ($key == 'is_client' && $value == 0) {
          if ($data['device_type'] == 1) {
            $type = lang('TRANSMITTER', $lang_file);
          } elseif ($data['device_type'] == 2) {
            $type = lang('RECEIVER', $lang_file);
          } else {
            $type = lang('NOT ASSIGNED');
          }
          $res_arr[$key_]['type'] = $type;
        } elseif ($key == 'device_id' && $value > 0) {
          $res_arr[$key_]['device_name'] = get_device_name($value);
        } elseif ($key == 'device_model' && $value > 0) {
          $res_arr[$key_]['model_name'] = get_model_name($data['device_id']);
        } elseif ($key == 'visit_time' && $value > 0) {
          $res_arr[$key_]['visit_time_name'] = get_visit_time_name($value);
        } elseif ($key == 'connection_type' && $value > 0) {
          $res_arr[$key_]['conn_name'] = get_conn_name($value);
        }
        // push data into parent array
        $res_arr[$key_][$key] = $value;
      }
    }
  }
  // print data
  return $res_arr;
}

/**
 * function get_dir_name v1
 * is used to get direction name
 * accepts 1 param => dir_id
 */
function get_dir_name($dir_id)
{
  global $db_obj;
  // get result
  $res = $db_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = $dir_id");
  // get direction name
  return count($res) > 0 ? $res[0]['direction_name'] : null;
}

/**
 * function get_src_name v1
 * is used to get source name
 * accepts 1 param => src_id
 */
function get_src_name($src_id)
{
  global $db_obj;
  // get result
  $res = $db_obj->select_specific_column("`full_name`", "`pieces_info`", "WHERE `id` = $src_id");
  // get source name
  return count($res) > 0 ? $res[0]['full_name'] : null;
}

/**
 * function get_device_name v1
 * is used to get source name
 * accepts 1 param => dev_id
 */
function get_device_name($dev_id)
{
  global $db_obj;
  // get result
  $res = $db_obj->select_specific_column("`device_name`", "`devices_info`", "WHERE `device_id` = $dev_id");
  // get source name
  return count($res) > 0 ? $res[0]['device_name'] : null;
}

/**
 * function get_model_name v1
 * is used to get source name
 * accepts 1 param => dev_id
 */
function get_model_name($dev_id)
{
  global $db_obj;
  // get result
  $res = $db_obj->select_specific_column("`model_name`", "`devices_model`", "WHERE `device_id` = $dev_id");
  // get source name
  return count($res) > 0 ? $res[0]['model_name'] : null;
}

/**
 * function get_conn_name v1
 * is used to get source name
 * accepts 1 param => conn_id
 */
function get_conn_name($conn_id)
{
  global $db_obj;
  // get result
  $res = $db_obj->select_specific_column("`connection_name`", "`connection_types`", "WHERE `id` = $conn_id");
  // get source name
  return count($res) > 0 ? $res[0]['connection_name'] : null;
}

/**
 * function get_visit_time_name v1
 * is used to get source name
 * accepts 1 param => time_id
 */
function get_visit_time_name($time_id, $lang_file = 'pieces')
{
  if ($time_id == 1) {
    $visit_msg = lang('ANY TIME', $lang_file);
  } elseif ($time_id == 2) {
    $visit_msg = lang('ADV CONN', $lang_file);
  } else {
    $visit_msg = lang('NO DATA');
  }
  // get time name
  return $visit_msg;
}


/**
 * function resize_img v1
 * is used to resize image
 */
function resize_img($img_location, $img_name)
{
  // allowed images
  $allowed_types = ['png', 'jpeg', 'jpg'];
  // specifying the image
  $image_filename = $img_location . $img_name;
  // check resized directory
  if (!file_exists($img_location . "resized/") && !is_dir($img_location . "resized/")) {
    mkdir($img_location . "resized/");
  }
  // resized file location
  $resized_image_filename = $img_location . "resized/" . $img_name;
  // get img ext
  $img_ext = explode(".", $img_name)[1];

  // get source image size
  list($w, $h) = getimagesize($image_filename);
  // specifying new image size
  $new_width = 580;
  $new_height = 580;
  // creating a black destination image with the required size
  $dst = imagecreatetruecolor($new_width, $new_height);
  // check current image in allowed types
  if (in_array($img_ext, $allowed_types)) {
    // check file type
    if ($img_ext == 'png') {
      // loading the image
      $src = imagecreatefrompng($image_filename);
      // making the destination image transparent
      imagecolortransparent($dst, imagecolorallocate($dst, 0, 0, 0));
      imagealphablending($dst, false);
      imagesavealpha($dst, true);
      // using the imagecopyresampled function
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $w, $h);
      // previewing the resized transparent image
      $save = imagepng($dst, $resized_image_filename);
    } else {
      // loading the source image
      $src = imagecreatefromjpeg($image_filename);
      // creating a thumbnail
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $w, $h);
      // saving the thumbnail in your current folder
      $save = imagejpeg($dst, $resized_image_filename);
    }
  } else {
    // false flag
    $save = false;
  }
  // return flag
  return $save ? true : null;
}

/**
 * facebook_validation function v1
 * used to facebook link validation
 */
function facebook_validation($link)
{
  return preg_match('/^(https?|ftp):\/\/(?:www\.)?facebook\.com\/(?:[\w\d]*\/)?(?:profile\.php\?id=)?/i', $link);
}

/**
 * instagram_validation function v1
 * used to instagram link validation
 */
function instagram_validation($link)
{
  return preg_match('/^(https?|ftp):\/\/(?:www\.)?(instagram\.com|instagr\.am)\/((?:[\w\d_](?:(?:[\w\d_]|(?:\.(?!\.))){0,28}(?:[\w\d_]))?)|p\/([a-zA-Z0-9_](?:(?:[a-zA-Z0-9_]|(?:\.(?!\.))){0,28}(?:[a-zA-Z0-9_]))?))/i', $link);
}

/**
 * twitter_validation function v1
 * used to twitter link validation
 */
function twitter_validation($link)
{
  return preg_match('/^(https?|ftp):\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)$/i', $link);
}

/**
 * linkedin_validation function v1
 * used to linkedin link validation
 */
function linkedin_validation($link)
{
  return preg_match('/^https:\\/\\/[a-z]{2,3}\\.linkedin\\.com\\/.*$/i', $link);
}

/**
 * youtube_validation function v1
 * used to youtube link validation
 */
function youtube_validation($link)
{
  return preg_match('/^(?:https?:\/\/)?(?:www\.)?youtube\.com(?:\/watch\?v=[\w-]+|\/v\/[\w-]+|\/embed\/[\w-]+|\/user\/[\w-]+|\/channel\/[\w-]+|\/c\/[\w-]+)$/i', $link);
}

// Function to check string starting 
// with given substring 
function starts_with($string, $startString)
{
  $len = strlen($startString);
  return (substr($string, 0, $len) === $startString);
}


/**
 * is_triple_parts_name function v1
 * used to check if name is triple parts or not
 * accepts one param is name
 */
function is_triple_parts_name($name)
{
  // Split the name into separate words.
  $words = explode(' ', $name);

  // Check if the name has three words.
  if (count($words) !== 3) {
    return false;
  }

  // // Check if each word is in Arabic or English.
  // foreach ($words as $word) {
  //   if (!preg_match('/^[\p{Arabic}\p{Latin}]+$/u', $word)) {
  //     return false;
  //   }
  // }

  // The name is in triple parts in either Arabic or English.
  return true;
}

/**
 * str_replace_whitespace function
 * used to replace all white spaces with dash "-" 
 */
function str_replace_whitespace($string)
{
  $words = preg_split('/\s+/', $string);
  $words = array_map(function ($word) {
    return str_replace(' ', '-', $word);
  }, $words);
  $result = implode('-', $words);
  return $result;
}

/**
 * get 
 */
function get_page_active_link($target)
{
  // get url
  $url = explode("/", $_SERVER['PHP_SELF']);

  return $url[3] == $target;
  // // return true or false
  // return preg_match("/{$target}/i", $url);
}
