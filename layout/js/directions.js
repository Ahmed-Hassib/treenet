(function () {
  // direction tree body
  let dir_tree_body = document.querySelector('.genealogy-body');
  // direction tree
  let dir_tree = document.querySelector('#direction_tree');
  // get updated dir select box
  let updated_dir = document.getElementById("updated-dir-name");
  // get updated dir id input
  let updated_dir_id = document.getElementById('updated-dir-id');
  // get new dir name input
  let new_dir_name = document.getElementById('new-direction-name');
  // zoom in button
  let zoom_in_btn = document.querySelector('#zoom_in_btn');
  // zoom out button
  let zoom_out_btn = document.querySelector('#zoom_out_btn');

  if (updated_dir != null) {
    // add event on updated direction select box
    updated_dir.addEventListener("change", (evt) => {
      evt.preventDefault();
      // set updated dir id 
      updated_dir_id.value = updated_dir.value;

      // set new dir name
      new_dir_name.value = updated_dir[updated_dir.selectedIndex].textContent;

      // assign dir id as an attribute to new dir
      // to check if new name is exist or not
      new_dir_name.dataset.id = updated_dir.value;
    })
  }

  // get previous button
  let prev_btn = document.querySelector(".scroll-button.scroll-prev");
  // get next button
  let next_btn = document.querySelector(".scroll-button.scroll-next");

  if (prev_btn != null && next_btn != null) {
    // add event when click on previous button
    prev_btn.addEventListener("click", (evt) => {
      evt.preventDefault();
      // get tree container
      let tree_container = next_btn.parentElement.parentElement;
      // increase scroll left value
      tree_container.scrollLeft -= 100;
    })
    // add event when click on previous button
    next_btn.addEventListener("click", (evt) => {
      evt.preventDefault();
      // get tree container
      let tree_container = next_btn.parentElement.parentElement;
      // increase scroll left value
      tree_container.scrollLeft += 100;
    })
  }

  if (dir_tree_body != null) {
    dir_tree_body.scrollLeft = dir_tree_body.offsetWidth / 2 * 3;
    // tree initialization
    tree_int(dir_tree, zoom_in_btn, zoom_out_btn);

    const directionOptionsEl = document.getElementById('directionOptions')
    directionOptionsEl.addEventListener('hidden.bs.modal', event => {
      event.preventDefault();
      // get modal label
      let modal_label = document.querySelector(`#directionOptionsLabel`);
      // get modal label
      let visit_device_btn = directionOptionsEl.querySelector(`#visit-device-btn`);
      // get modal label
      let details_btn = directionOptionsEl.querySelector(`#show-details-btn`);

      // clear modal label
      modal_label.textContent = '';
      // clear href from visit device button and details button
      visit_device_btn.href = '';
      details_btn.href = '';
    })
  }

})()

/**
 * put_updated_dir_info function
 * is used to classify the operations wants to do on directions
 */
function put_dir_info(btn, type) {
  switch (type) {
    case 'update':
      put_updated_data(btn);
      break;

    case 'delete':
      put_deleted_data(btn);
      break;

    default:
      break;
  }
}


/**
 * put_updated_data function
 * is used to put direction info into update form
 */
function put_updated_data(btn) {
  // id
  var id = document.getElementById("updated-dir-id");
  // old ip
  var old_dir_name = document.getElementById("updated-dir-name");
  // new name
  var new_dir_name = document.getElementById("new-direction-name");
  // new ip
  var new_ip_addr = document.getElementById("new-direction-ip");

  // put values
  id.value = btn.dataset.directionId;
  old_dir_name.value = btn.dataset.directionId;
  new_dir_name.value = btn.dataset.directionName;
  new_dir_name.dataset.id = btn.dataset.directionId;
  // new_ip_addr.value = btn.dataset.directionIp;
}

/**
 * put_deleted_dir function
 * is used to put direction info into delete form
 */
function put_deleted_data(btn) {
  // id
  var id = document.getElementById("deleted-dir-id");
  // old ip
  var deleted_dir_name = document.getElementById("deleted-dir-name");

  // put values
  id.value = btn.dataset.directionId;
  deleted_dir_name.value = btn.dataset.directionId;
}

function tree_int(tree, zoom_in_btn, zoom_out_btn) {
  // get cached scale from localStorage
  let tree_scale = restore_scale_value();
  // check value
  if (tree_scale != null) {
    // set tree scale
    tree.style['transform'] = `scale(${tree_scale})`;
    tree.style['transform-origin'] = '20% 50% 0px';
    // update buttons scale value
    update_buttons_scale_value(zoom_in_btn, zoom_out_btn, tree_scale);
  }
}

function zoom_in(input_in, input_out, tree) {
  // get zoom value
  let zoom_value = Number(input_in.dataset.zoomValue) + 0.1;
  // add scale to tree
  tree.style['transform'] = `scale(${zoom_value})`
  // update zoom value of zoom in button
  input_in.dataset.zoomValue = zoom_value;
  input_out.dataset.zoomValue = zoom_value;
  // store new value of tree scale
  store_scale_value(zoom_value);
}

function zoom_out(input_out, input_in, tree) {
  // get zoom value
  let zoom_value = Number(input_out.dataset.zoomValue) - 0.1;
  // add scale to tree
  tree.style['transform'] = `scale(${zoom_value})`
  // update zoom value of zoom in button
  input_in.dataset.zoomValue = zoom_value;
  input_out.dataset.zoomValue = zoom_value;
  // store new value of tree scale
  store_scale_value(zoom_value);
}

function reset_zoom(input_in, input_out, tree) {
  // get zoom value
  let zoom_value = 1;
  // update zoom value of zoom in button
  input_in.dataset.zoomValue = zoom_value;
  input_out.dataset.zoomValue = zoom_value;
  tree.style['transform'] = `scale(${zoom_value})`
  // store new value of tree scale
  store_scale_value(zoom_value);
}

function add_transform_origin(tree) {
  tree.style['transform-origin'] = '20% 50% 0px';
}

function remove_transform_origin(tree) {
  tree.style['transform-origin'] = 'unset';
}

function restore_scale_value() {
  return localStorage.getItem('tree_scale');
}

function store_scale_value(scale_value) {
  localStorage.setItem('tree_scale', Number(scale_value).toFixed(2));
}

function update_buttons_scale_value(input_in, input_out, scale_value) {
  input_in.dataset.zoomValue = scale_value;
  input_out.dataset.zoomValue = scale_value;
}

function show_modal_options(button) {
  // get modal id
  let modal_id = button.dataset.modalId;
  // get modal
  let modal = document.querySelector(`#${modal_id}`);
  // get modal label
  let modal_label = document.querySelector(`#${modal_id}Label`);
  // get modal label
  let visit_device_btn = modal.querySelector(`#visit-device-btn`);
  // get modal label
  let details_btn = modal.querySelector(`#show-details-btn`);
  // get piece href
  let target_href = button.dataset.href;
  // get piece info
  let pcs_info = button.querySelector('.pcs-info');
  // get piece ip
  let pcs_ip = pcs_info.dataset.pcsIp ?? null;
  // get piece name
  let pcs_name = pcs_info.dataset.pcsName ?? null;;

  // put modal label
  modal_label.textContent = pcs_name ?? null;

  // put details button href
  details_btn.href = target_href;

  // check ip
  if (pcs_ip == null) {
    visit_device_btn.classList.add('d-none');
  } else {
    visit_device_btn.classList.contains('d-none') ? visit_device_btn.classList.remove('d-none') : null;
    visit_device_btn.href = `http://${pcs_ip}`;
  }
}