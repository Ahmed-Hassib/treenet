<?php
// sections of reports
$sections = [
  '1' => [
    'title' => 'the employees',
    'code' => 'emp',
    'lang_file' => 'employees'
  ],
  '2' => [
    'title' => 'the directions',
    'code' => 'dir',
    'lang_file' => 'directions'
  ]
];
?>
<!-- start home stats container -->
<div class="container" dir="<?php echo $page_dir ?>">
  <!-- start stats -->
  <div class="stats">
    <div class="reports-container">
      <div class="section-block p-sm-1">
        <header class="section-header">
          <h2 class="h2 text-capitalize">
            <?php echo lang('THE REPORTS', $lang_file) ?>
          </h2>
          <p class="text-muted d-none d-sm-block d-md-none">
            <?php echo lang('REPORTS NOTE', $lang_file) ?>
          </p>
          <hr>
        </header>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="report-form" name="report-form"
          class="report-form">
          <!-- select section -->
          <div class="form-floating">
            <select class="form-select" id="sectionsSeclectBox" name="section"
              aria-label="select a section to generate the report of it" required>
              <option value="default" disabled selected>
                <?php echo lang('SELECT SECTION', $lang_file) ?>
              </option>
              <?php foreach ($sections as $key => $section) { ?>
                <option value="<?php echo base64_encode($section['code']) ?>" <?php echo isset($_POST['section']) && $_POST['section'] == base64_encode($section['code']) ? 'selected' : '' ?>>
                  <?php echo lang(strtoupper($section['title']), $section['lang_file']) ?>
                </option>
              <?php } ?>
            </select>
            <label for="sectionsSeclectBox">
              <?php echo lang('THE SECTIONS', $lang_file) ?>
            </label>
          </div>

          <div class="hstack gap-2">
            <!-- submit button -->
            <button type="submit" class="btn btn-primary fs-12">
              <i class="bi bi-graph-up"></i>
              <span>&nbsp;
                <?php echo lang('GENERATE REPORT', $lang_file) ?>
              </span>
            </button>
            <?php if (isset($_POST) && !empty($_POST)) { ?>
              <!-- button to reload page to clear report parameters -->
              <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn btn-outline-primary fs-12">
                <?php echo lang('CLEAR', $lang_file) ?>
                <i class="bi bi-x"></i>
              </a>
            <?php } ?>
          </div>
        </form>
      </div>

      <?php
      if (isset($_POST) && !empty($_POST)) {
        // get parameters
        $section = isset($_POST['section']) && !empty($_POST['section']) ? base64_decode(trim($_POST['section'], "\n\r\t\v\x")) : null;
        // switch case for choose report file
        switch ($section) {
          case 'emp':
            $report_title = 'EMPLOYEES';
            $report_file = 'emp-report.php';
            break;

          case 'dir':
            $report_title = 'DIRECTIONS';
            $report_file = 'dir-report.php';
            break;
          default:
            # code...
            break;
        }
        ?>
        <!-- show reports container -->
        <div class="section-block p-sm-1">
          <header class="section-header">
            <h2 class="h2 text-capitalize">
              <?php echo lang('REPORT OF', $lang_file) . " " . lang($report_title) ?>
            </h2>
            <hr>
          </header>
          <section class="show-reports-container">
            <?php include_once $report_file; ?>
          </section>
        </div>
      <?php } ?>
    </div>
  </div>
</div>