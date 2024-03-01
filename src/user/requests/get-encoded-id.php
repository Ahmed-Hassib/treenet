<?php
// check id and license
if (isset($_POST['id']) && !empty($_POST['id']) && $_SESSION['sys']['isLicenseExpired'] == 0) {
  // return result
  echo json_encode(base64_encode($_POST['id']));
}
?>