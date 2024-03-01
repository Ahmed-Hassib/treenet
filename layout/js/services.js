
function check_mikrotik_info(evt, form) {
  // get modal body if
  let modal_id = evt.dataset.bsTarget;
  // get mikrotik ip or hostname
  let host = form.elements['mikrotik-ip'].value;
  // get mikrotik port
  let port = form.elements['mikrotik-port'].value;
  // get mikrotik password
  let password = form.elements['mikrotik-password'].value;
  // get mikrotik username
  let username = form.elements['mikrotik-username'].value;

  let data = [host, port, username, password];

  evt.classList.add('disabled');
  evt.children[0].classList.add('d-none');
  evt.children[1].classList.remove('d-none');

  $.get(`../requests/index.php?do=check-mikrotik-info&data[]=${JSON.stringify(data)}`, function (response) {
    // convert response
    let is_connected = JSON.parse(response);
    // hide loader
    document.querySelector(`${modal_id} .modal-header`).children[1].classList.remove('d-none');
    document.querySelector(`${modal_id} .modal-body`).children[0].classList.add('d-none');
    document.querySelector(`${modal_id} .modal-footer button`).classList.remove('disabled');
    document.querySelector(`${modal_id} .modal-footer button`).children[0].classList.remove('d-none');
    document.querySelector(`${modal_id} .modal-footer button`).children[1].classList.add('d-none');
    // reset check connection button
    evt.classList.remove('disabled');
    evt.children[0].classList.remove('d-none');
    evt.children[1].classList.add('d-none');
    // update modal content
    update_modal_body(modal_id, is_connected);
  });
}


function clear_modal_body(modal_id) {
  // get modal header
  let modal_header = document.querySelector(`${modal_id} .modal-header`);
  // get modal body
  let modal_body = document.querySelector(`${modal_id} .modal-body`);
  // get modal footer
  let modal_footer_button = document.querySelector(`${modal_id} .modal-footer button`);
  // clear modal body
  if (modal_body.childElementCount > 1) {
    // reset modal header
    modal_header.children[1].classList.add('d-none');
    // reset modal body
    modal_body.children[0].classList.remove('d-none');
    modal_body.children[1].remove();
    // reset modal footer
    modal_footer_button.classList.add('disabled');
    modal_footer_button.children[0].classList.add('d-none');
    modal_footer_button.children[1].classList.remove('d-none');
  }
}


function update_modal_body(modal_id, status) {
  // get modal body
  let modal_body = document.querySelector(`${modal_id} .modal-body`);
  // create a div for put content
  let div = document.createElement('div');
  div.classList.add(status ? 'text-success' : 'text-danger');
  div.textContent = status ? lang.connected : lang.failed_connection;
  // append div into modal body
  modal_body.appendChild(div);
}