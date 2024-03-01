
function put_data_into_modal(btn, type, id, name, will_back = null) {
  // get inputs
  let id_input = document.getElementById(id);
  let name_input = document.getElementById(name);

  // put values
  id_input.value = btn.dataset.id;
  // check type
  switch(type){
    case 'edit':
      name_input.value = btn.dataset.name;
      break;
      
    case 'delete':
      name_input.textContent = btn.dataset.name;

      // get form action
      let form_action = id_input.form.getAttribute('action');
      if (will_back != null) {
        id_input.form.setAttribute('action', `${form_action}&back=true`);

        console.log(id_input.form.getAttribute('action'))
      } 
      break;
  }
}

function add_model(btn) {
  // get form
  let form = btn.parentElement;
  // get model number
  let model_name = `model ${Number(btn.dataset.modelNum) + 1}`;
  // get model number
  let model_number = `device-model-${Number(btn.dataset.modelNum) + 1}`;
  // create label
  let label = document.createElement('label');
  label.classList.add('col-sm-12', 'col-md-4', 'col-form-label', 'text-capitalize', 'model-label');
  label.setAttribute('for', model_number);
  label.textContent = model_name;

  // create input
  let input = document.createElement('input')
  input.classList.add('form-control');
  input.setAttribute('type', 'text');
  input.setAttribute('id', model_number);
  input.setAttribute('name', 'model[]');
  input.setAttribute('autocomplete', 'off');
  input.setAttribute('required', 'required');

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

  // create input container
  let input_container = document.createElement('div');
  input_container.classList.add('col-sm-12', 'col-md-6');

  // create model container
  let model_container = document.createElement('div')
  model_container.classList.add('mb-sm-2', 'mb-md-3', 'row', 'justify-content-start')

  // append input into container
  input_container.appendChild(input);

  // append model content into container
  model_container.appendChild(label)
  model_container.appendChild(input_container)
  model_container.appendChild(del_btn_container)

  del_btn.addEventListener("click", (evt) => {
    evt.preventDefault();

    // remove model field
    model_container.remove();

    // get models labels
    let model_labels = document.querySelectorAll('.model-label');
    // loop on it to modify text
    model_labels.forEach((label, key) => {
      // set text
      label.textContent = `model ${key + 1}`;
    });
    
    // reset models number
    btn.dataset.modelNum = Number(btn.dataset.modelNum) - 1;
  })
  // append model container into form
  form.insertBefore(model_container, btn)

  btn.dataset.modelNum = Number(btn.dataset.modelNum) + 1;
}

function get_devices_models(btn, location) {
  // get device id
  let device_id = btn.value;
  // url
  let url = `../requests/index.php?do=get-device-models&device-id=${device_id}`;

  // get request to get backup of data
  $.get(url, (json_file_data) => {
    if (json_file_data != false) {
      // assign json file name to the variable
      json_file_name = $.parseJSON(json_file_data);

      // get data from json file
      $.ajax({
        url: `${location}/${json_file_name}`,
        dataType: 'json',
        cache: false,
        success: function (data, status) {
          put_data_into_select(data, status, 'device-model', 'model');
        },
        error: function (_xhr, _textStatus) {
          // for error message
        }
      })
    } else {
    }
  });

}