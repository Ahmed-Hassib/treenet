let company_img_container = document.querySelector('#company-image-container');
let company_img_input = document.querySelector('#company-img-input');
let company_img = document.querySelector('#company-img');
let change_company_img_btn = document.querySelector('#change-company-img-btn');


function click_input() {
  company_img_input.click()
}

function change_company_img(btn) {
  // get image path
  let img_path = URL.createObjectURL(btn.files[0]);
  // upload image
  company_img.setAttribute("src", img_path);

  let company_img_status = document.querySelector('#company-img-status');
  if (company_img_status != null) {
    company_img_status.textContent = 'برجاة حفظ التغييرات';
    company_img_status.classList.remove('text-danger', 'text-muted')
    company_img_status.classList.add('text-success')
  } else {
    let status = create_company_img_status('برجاة حفظ التغييرات', 'text-success');
    company_img_container.appendChild(status)
  }

  change_company_img_btn.classList.remove('d-none')
}

function delete_company_image() {
  company_img.setAttribute("src", '../../../../data/uploads/assets/treenet.jpg');

  let confirm_delete = confirm(lang.confirm);

  if (confirm_delete) {
    // send request
    $.get(`../requests/index.php?do=delete-company-img`, (data) => {
      if (data) {
        let company_img_status = document.querySelector('#company-img-status');
        if (company_img_status != null) {
          console.log('deleted');
          company_img_status.textContent = 'تم حذف الصورة بنجاح!\n برجاء تحديث الجلسة لتطبيق التغييرات';
          company_img_status.classList.remove('text-danger', 'text-muted')
          company_img_status.classList.add('text-success')
        } else {
          let status = create_company_img_status('تم حذف الصورة بنجاح!\n برجاء تحديث الجلسة لتطبيق التغييرات', 'text-danger');
          company_img_container.appendChild(status)
        }
      }
    });
  }
}

function create_company_img_status(status_text, text_class) {
  // append text to save chnges
  let span = document.createElement('span')
  span.textContent = status_text;
  span.classList.remove('text-danger', 'text-muted', 'text-success')
  span.classList.add('text-center', text_class);
  span.id = 'company-img-status';

  return span;
}
