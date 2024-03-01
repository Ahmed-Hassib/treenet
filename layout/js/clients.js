
let deleted_client_name_in_modal = document.querySelector('#deleted-client-name');
let deleted_client_url_in_modal = document.querySelector('#deleted-client-url');

function confirm_delete_client(btn, will_back = null, deleted = false) {
  // get client info
  let client_id = btn.dataset.clientId;
  let client_name = btn.dataset.clientName;
  // prepare url
  let url = (deleted == false ? `?do=temp-delete` : `?do=delete`) + `&client-id=${client_id}` + (will_back == null ? '' : '&back=true');
  // put it into the modal
  deleted_client_name_in_modal.textContent = `'${client_name}'`;
  deleted_client_url_in_modal.href = url;
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