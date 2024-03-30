var modal_close_btn = document.querySelector("#media-modal-close");


function add_media(btn) {
  // get form
  let form = btn.parentElement;
  // get media number
  let media_name = `media ${Number(btn.dataset.mediaNum) + 1}`;
  // get media number
  let media_number = `device-media-${Number(btn.dataset.mediaNum) + 1}`;
  // create label
  let label = document.createElement('label');
  label.classList.add('text-capitalize', 'media-label');
  label.setAttribute('for', media_number);
  label.textContent = media_name;

  // create a delete icon
  let trash_icon = document.createElement('i')
  trash_icon.classList.add('bi', 'bi-trash');

  // create a delete button
  let del_btn = document.createElement('button');
  del_btn.classList.add('btn', 'btn-danger', 'w-100');
  del_btn.setAttribute('type', 'button');
  del_btn.appendChild(trash_icon)

  // create a delete button container
  let del_btn_container = document.createElement('div')
  del_btn_container.classList.add('col-sm-2');
  del_btn_container.appendChild(del_btn);

  // create media container
  let media_container = document.createElement('div')
  media_container.classList.add('media-container')

  // append media content into container
  media_container.appendChild(label);
  media_container.appendChild(del_btn_container);

  // // create the image src
  // var src = URL.createObjectURL(evt.files[i]);

  del_btn.addEventListener("click", (evt) => {
    evt.preventDefault();

    // remove media field
    media_container.remove();

    // get medias labels
    let media_labels = document.querySelectorAll('.media-label');
    // loop on it to modify text
    media_labels.forEach((label, key) => {
      // set text
      label.textContent = `media ${key + 1}`;
    });

    // reset medias number
    btn.dataset.mediaNum = Number(btn.dataset.mediaNum) - 1;
  })

  // select media preview container
  let media_preview = document.querySelector('#media-preview')
  
  // append media to media container preview
  media_preview.appendChild(media_container);

  // append media preview into form
  form.insertBefore(media_preview, btn)

  btn.dataset.mediaNum = Number(btn.dataset.mediaNum) + 1;
}


function create_input_file() {
  // create a media input
  let input = document.createElement('input');
  input.type = 'file';  // input type
  input.name = 'media[]';   // input name
  input.setAttribute('multiple', 'multiple');
  input.setAttribute('form', 'edit-combination-info');
  // input.setAttribute('accept', 'image/*')
  // input.classList.add('d-none');
  // add event
  input.addEventListener('change', (evt) => {
    evt.preventDefault();
    // check files
    if (input.files.length > 0) {
      // show media
      show_media_preview(input);
    }
  })
  // return input
  return input;
}


function add_media(btn, preview_id) {
  // get preview el
  prev_el = document.querySelector(`#${preview_id}`);
  // uploaded type
  let type = btn.files[0]['type'].includes('video') ? 'video' : 'img';
  // get size
  total_size = btn.files[0]['size'];
  // create the image src
  var src = URL.createObjectURL(btn.files[0]);
  // create image
  img_element = document.createElement('img');
  img_element.setAttribute('src', src);
  img_element.setAttribute('class', 'w-100 h-100');
  img_element.style.cursor = 'pointer';
  img_element.style.borderRadius = '16px';
  img_element.style.objectFit = 'contain';
  media_type = 'jpg';

  // check container children counter
  if (prev_el.childElementCount > 0) {
    // replace old element with new element
    prev_el.replaceChild(img_element, prev_el.children[0])
  } else {
    // append img element into preview container
    prev_el.appendChild(img_element)
  }

  if (prev_el.classList.contains('d-none')) {
    prev_el.classList.remove('d-none')
  }
}

function open_media(src, type) {
  // check type
  switch (type) {
    case 'jpg':
      // create image
      element = document.createElement('img');
      element.setAttribute('src', src);
      break;

    case 'mp4':
      element = create_video_element(src);
      break;
  }

  // select modal
  var modal = document.querySelector("#media-modal");
  // select modal content
  var modal_content = modal.querySelector("#media-modal-content");
  // clear modal content
  modal_content.innerHTML = '';
  modal.style.display = "block";
  element.classList.add('media-modal-content');
  modal_content.appendChild(element);
}


if (modal_close_btn != null) {
  modal_close_btn.addEventListener('click', (evt) => {
    modal_close_btn.parentElement.style.display = "none";
  })
}
