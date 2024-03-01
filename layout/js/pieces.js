
let deleted_piece_name_in_modal = document.querySelector('#deleted-piece-name');
let deleted_piece_url_in_modal = document.querySelector('#deleted-piece-url');

function confirm_delete_piece(btn, will_back = null, deleted = false) {
  // get piece info
  let piece_id = btn.dataset.pieceId;
  let piece_name = btn.dataset.pieceName;
  let page_title = btn.dataset.pageTitle;
  // prepare url
  let url = (deleted == false ? `?do=temp-delete` : `?do=delete`) + `&piece-id=${piece_id}` + (will_back == null ? '' : `&back=true`);
  // put it into the modal
  deleted_piece_name_in_modal.textContent = `'${piece_name}'`;
  deleted_piece_url_in_modal.href = url;
}


function add_new_port(id, container_id, btn) {
  // get container to append cloned card in it
  const cards_container = document.querySelector(`#${container_id}`);
  // get card that will take a clone from
  let card_content = document.querySelector(id);
  // check children
  if (cards_container.children.length < 10) {
    // take a clone
    let clone = card_content.cloneNode(true);
    // append clone
    cards_container.appendChild(clone);
    // check cloned element
    check_clone_element(clone)
    // update cards numbers
    update_card_header();
  } else {
    btn.disabled = true
  }
}

function check_clone_element(clone) {
  // get text inputs
  const text_inputs = clone.querySelectorAll('input[type=text]');
  // get hidden inputs
  const hidden_inputs = clone.querySelectorAll('input[type=hidden]');
  // get card footer
  const card_footer = clone.querySelector('.card-footer')

  // loop on text inputs
  for (const input of text_inputs) {
    // reset value of input
    input.value = '';
  }

  // loop on hidden inputs
  for (const input of hidden_inputs) {
    // remove hidden input
    input.remove();
  }

  if (card_footer != null) {
    // remove card footer
    card_footer.remove();
  }
}


function update_card_header() {
  // get all card headers
  let all_cards_headers = document.querySelectorAll('.card.available_ports_card >.card-header');
  // loop on cards headers
  all_cards_headers.forEach((header, key) => {
    header.textContent = `port #${(key + 1)}`.toUpperCase();
  });
}

function delete_port_card(btn) {
  console.log(btn)
}