// sidebar menu
let sidebar = document.querySelector(".sidebar-menu");

// sidebar menu button
let sidebar_menubtn = document.querySelector(".sidebar-menubtn");

// submenu arrow button
let arrows_down = document.querySelectorAll(".icon-link");

// close sidenavbar button
let close_btn = document.querySelector("span.close-btn");

// check close button
if (close_btn != null) {
  close_btn.addEventListener("click", evt => {
    evt.preventDefault();
    open_close_sidebar();
  })
}

// loop on arrows
arrows_down.forEach((el) => {
  // add event on every arrow
  el.addEventListener("click", evt => {
    if (!sidebar_menubtn.classList.contains('close')) {
      // parent element
      let parent_el = evt.target.parentElement;
      // check the target
      switch (parent_el.tagName.toLowerCase()) {
        case 'section':
          li_el = parent_el.parentElement.parentElement;
          break;
        case 'div':
          li_el = parent_el.parentElement;
          break;
      
        default:
          break;
      }
      // add show-menu class to li element
      li_el.classList.toggle("show-menu");
    }
  })
})

if (sidebar != null) {
    // check localStorage variable to open or close sidebar menu
    restore_sidebar();
}

if (sidebar_menubtn != null) {
    // add click event on sidebar menu button
    sidebar_menubtn.addEventListener("click", evt => {
        evt.preventDefault();
        open_close_sidebar();
    })
}

// open or close sidebar
function open_close_sidebar() {
    // toggle on close class
    sidebar.classList.toggle("close");
    // update session value
    localStorage['sidebarMenuClosed'] = check_sidebar_action();
}

// check if sidebar containe "close" class or not 
function check_sidebar_action() {
    return sidebar.classList.contains("close");
}

// restore last vision of sidebar menu
function restore_sidebar() {
    // check if localStorage variable is set or not
    // and side bar contains close class or not
    if (localStorage['sidebarMenuClosed'] !== 'false') {
        sidebar.classList.add("close");
    } else {
        sidebar.classList.remove("close");
    }
}


// get all menu that have sub menu
let sub_menu_containers = document.querySelectorAll(".nav-links li .icon-link .bi-arrow-down-short")

sub_menu_containers.forEach(sub_menu => {
    // select li element
    const li_element = sub_menu.parentElement.parentElement;
    // show li sub menu
    // li_element.classList.add("show-menu")
})
