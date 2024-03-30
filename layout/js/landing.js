// variables
var landing_section = document.querySelector('.landing-container');
var animate_sections = document.querySelectorAll('.animate-section');
var sections_header = document.querySelectorAll('header.section-header');
var nav_links = document.querySelectorAll(".nav-link:not(.not-nav-link)");
var features_sections = document.querySelectorAll(".features-row");
var agents_content = document.querySelectorAll('.agents-container__content');
var scroll_top_btn = document.querySelector(".scroll-top-btn");

(function () {

  window.onload = function () {
    landing_section.querySelector('.landing-content').classList.add('animated');
    landing_section.querySelector('.landing-carousel').classList.add('animated');
  }

  window.addEventListener('scroll', (evt) => {
    let top = window.scrollY;   // windows scroll value
    // scroll spy
    animate_sections.forEach(sec => {
      let offset = sec.offsetTop;   // current section offset top
      let height = sec.offsetHeight;    // current section offset height

      if (top >= offset - 100 && top < offset + height) {
        nav_links[sec.dataset.navLink].classList.add('active')
      } else {
        nav_links[sec.dataset.navLink].classList.remove('active')
      }
    });

    // scroll spy
    features_sections.forEach((sec, _key) => {
      let offset = sec.offsetTop;   // current section offset top
      let height = sec.offsetHeight;    // current section offset height
      let increased = parseInt(sec.dataset.increased);

      if (top >= offset + increased && top < offset + increased + height) {
        sec.classList.add('feature-animate')
      }
    });

    // scroll spy
    sections_header.forEach((header, _key) => {
      let offset = header.offsetTop;   // current section offset top
      let height = header.offsetHeight;    // current section offset height
      let increased = parseInt(header.dataset.increased) ?? 0;

      if (top >= offset + increased && top < offset + increased + height) {
        header.classList.add('header-animate')

        if (header.nextElementSibling.classList.contains('agents-container')) {
          agents_content.forEach(agent => {
            agent.classList.add('agent-animate')
          });
        }
      }
    });

    // check scroll value to show scroll top button or hide it
    if (top >= 600) {
      scroll_top_btn.classList.add('show')
      scroll_top_btn.classList.add(localStorage.getItem('lang') == 'ar' ? 'left' : 'right')
    } else {
      scroll_top_btn.classList.remove('show')
    }
  });

  // add event to scroll top button to go top of the page
  scroll_top_btn.addEventListener('click', (evt) => {
    console.log(window.scrollTo(0, 0));
  });
})();