<?php
// check if license was ended
if (isset($_SESSION['sys']['isLicenseExpired']) && $_SESSION['sys']['isLicenseExpired'] == 1 && !isset($no_navbar)) {
  // license file
  include_once $globmod . 'license-ended.php';
}
// // create an object of Alerts class
// $alerts_obj = new Alerts();

// // get all alerts of company
// $alerts = $alerts_obj->get_all_alerts(0, "OR `company_id` = " . base64_decode($_SESSION['sys']['company_id']) . " AND `expire_at` > '" . get_date_now() . "'");
?>

<?php if (isset($_SESSION['sys']['isLicenseExpired']) && $_SESSION['sys']['isLicenseExpired'] == 1 && !isset($no_navbar)) {?>
<!-- <div class="container">
  <div class="alert alert-info">
    <h4 class="h4 text-capitalize">
      <i class="bi bi-exclamation-triangle-fill"></i>
      برجاء العلم أننا نقوم ببعض الأعمال لتحسين مستوى الخدمة فقد لا تعمل بعض العمليات كالحذف!
    </h4>
  </div>
</div> -->
<?php } ?>