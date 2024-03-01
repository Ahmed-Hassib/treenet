<?php
// check if Get request userid is numeric and get the integer value
$dir_id = isset($_GET['dir-id']) && !empty($_GET['dir-id']) ? base64_decode($_GET['dir-id']) : 0;
// check if Direction class object was created or not
$dir_obj = new Direction();
// get direction name
$dir_name = $dir_obj->select_specific_column("`direction_name`", "`direction`", "WHERE `direction_id` = $dir_id")[0]['direction_name'];
// query select
$q = "SELECT `pieces_info`.`id`, `pieces_info`.`ip`, `pieces_info`.`full_name`, `pieces_info`.`source_id`, `pieces_coordinates`.`coordinates`, `direction`.`direction_name`, `direction`.`direction_id` FROM `pieces_info` LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id` LEFT JOIN `pieces_coordinates` ON `pieces_coordinates`.`id` = `pieces_info`.`id` WHERE `pieces_info`.`direction_id` = ? AND `pieces_info`.`is_client` != 1 AND `pieces_info`.`company_id` = ?";

$stmt = $con->prepare($q);          // select all users
$stmt->execute(array($dir_id, base64_decode($_SESSION['sys']['company_id'])));      // execute data
$rows = $stmt->fetchAll();          // assign all data to variable
$dataCount = $stmt->rowCount();     // count the row data

$sub_data = [];
$data = [];
$coordinates = [];
// loop on result ..
foreach ($rows as $row) {
  // get all information of pieces_info..
  $data[$row["id"]]["id"] = $row["id"];
  $data[$row["id"]]["ip"] = $row["ip"];
  $data[$row["id"]]["full_name"] = $row["full_name"];
  $data[$row["id"]]["source_id"] = $row["source_id"];
  $data[$row["id"]]["direction_name"] = $row["direction_name"];
  $data[$row["id"]]["direction_id"] = $row["direction_id"];
  $data[$row["id"]]["coordinates"] = $row["coordinates"];
}
?>
<!-- start add new user page -->
<div class="container" name="showDir" dir="<?php echo $page_dir ?>">
  <!-- start header -->
  <header class="header">
    <h3 class="h3 text-primary">
      <?php echo $dir_name ?>
    </h3>
  </header>
  <!-- end header -->
</div>
<?php if (count($data) > 0) { ?>

  <!-- start showing directions tree -->
  <div class="genealogy-body genealogy-scroll" dir="ltr">
    <div class="genealogy-tree text-center" id="direction_tree">
      <?php build_direction_tree($data, 0); ?>
    </div>

    <!-- scroll buttons -->
    <div class="fixed-scroll-btn">
      <!-- scroll left button -->
      <button type="button" role="button" class="scroll-button scroll-prev scroll-prev-right">
        <i class="carousel-control-prev-icon"></i>
      </button>
      <!-- scroll right button -->
      <button type="button" role="button"
        class="scroll-button scroll-next <?php echo $_SESSION['sys']['lang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
        <i class="carousel-control-next-icon"></i>
      </button>
    </div>

    <!-- zoom buttons -->
    <div class="fixed-zoom-btn">
      <div class="btn-group" role="group" aria-label="zoom-btns">
        <button type="button" class="btn btn-outline-primary py-1 fs-12" id="zoom_in_btn"
          onclick="zoom_in(this, zoom_out_btn, direction_tree); add_transform_origin(direction_tree)"
          data-zoom-value="1"><i class="bi bi-zoom-in"></i></button>
        <button type="button" class="btn btn-outline-primary py-1 fs-12" id="reset_zoom"
          onclick="reset_zoom(zoom_in_btn, zoom_out_btn, direction_tree); remove_transform_origin(direction_tree)"><i
            class="bi bi-x-lg"></i></button>
        <button type="button" class="btn btn-outline-primary py-1 fs-12" id="zoom_out_btn"
          onclick="zoom_out(this, zoom_in_btn, direction_tree); add_transform_origin(direction_tree)"
          data-zoom-value="1"><i class="bi bi-zoom-out"></i></button>
      </div>
    </div>
  </div>
  <!-- end showing directions tree -->
<?php } else {
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>