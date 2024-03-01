<?php
if (isset($page_category) && !isset($no_footer)) {
  // check session of user
  if (isset($_SESSION['sys']['UserID']) && $_SESSION['sys']['is_root']) {
    $treenet_footer = get_page_dependencies("" . $page_category . "_global", 'footer')['root'];
    $tpl_type = "root_tpl";
  } else {
    if ($is_developing == false) {
      $treenet_footer = get_page_dependencies("" . $page_category . "_global", 'footer')['user'];
      $tpl_type = "user_tpl";
    }
  }

  // check if footer set
  if (isset($treenet_footer)) {
    // include footer
    include_once $$tpl_type . $treenet_footer;
  }
}
