/**
* get_point_style function
* used to return a color of stroke depending on point type
* accepts type parameter
*/
function get_point_style(is_client, type) {
  // default color
  let color = "#ff0000";
  // default color
  let borderColor = "#333333";
  // switch case to determine the color
  switch (is_client) {
    case '1':
      point_type = 'client';
      point_page_type = 'client';
      color = "#00c200";
      break;
    default:
      switch (type) {
        case '1':
          point_type = 'sender';
          point_page_type = 'piece';
          color = "#ff942e";
          break;
        case '2':
          point_type = 'receiver';
          point_page_type = 'piece';
          color = "#0061c7";
          break;
        default:
          point_type = 'sender';
          point_page_type = 'piece';
          color = "#ff0000";
      }
  }
  // return result
  return {
    color: color,
    borderColor: borderColor,
    point_type: point_type,
    point_page_type: point_page_type,
  };
}

// create_pin_icon function
// used to create an icon depending on point type
function create_pin_icon(type) {
  // create a div container
  const icon_container = document.createElement('div');

  // get icon
  switch (type) {
    case 'client':
      icon = 'bi-person-fill';
      break;
    case 'sender':
      icon = 'bi-wifi';
      break;
    case 'receiver':
      icon = 'bi-modem-fill';
      break;

    default:
      icon = 'bi-question-fill'
      break;
  }
  // put icon in container
  icon_container.innerHTML = `<i class="bi ${icon}"></i>`;

  // return icon container
  return icon_container;
}

// Attaches an info window to a marker with the provided message. When the
// marker is clicked, the info window will open with the secret message.
function attach_screen_message(marker, secretMessage) {
  const infowindow = new google.maps.InfoWindow({
    content: secretMessage,
  });

  // add event to marker
  marker.addListener("click", () => {
    // infowindow.open(marker.get("map"), marker); // for normal marker
    // infowindow.open(marker.map, marker);

    infowindow.open({
      anchor: marker,
      map,
    });
  });

}

// create path between 2 points
function create_points_path(map, src_point, points) {
  // loop on points to display it
  points.forEach(point => {
    // check source point coordinates
    if (typeof src_point == 'string' && src_point != null && src_point != '') {
      // check if point has coordinates
      if (point['coordinates'] != null && point['coordinates'] != '') {
        // get latitude and longitude as an object
        let pointLatLng = getLatLong(point['coordinates']);
        let srcPointLatLng = getLatLong(src_point);

        // get point style
        let point_style = get_point_style(point.is_client, point.device_type);

        // get target points
        const points_path_coordinates = [
          srcPointLatLng,
          pointLatLng
        ];

        // Define the symbol, using one of the predefined paths ('CIRCLE')
        // supplied by the Google Maps JavaScript API.
        const line_symbol = {
          path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
          scale: 3,
          strokeColor: point_style.color,
        };

        // initial path
        const points_path = new google.maps.Polyline({
          path: points_path_coordinates,
          geodesic: true,
          strokeColor: point_style.color,
          strokeOpacity: 1.0,
          strokeWeight: 3,
          editable: true,
          icons: [
            {
              icon: line_symbol,
              offset: "100%",
            }
          ]
        });
        // add points path to the map
        points_path.setMap(map);
        // set animation
        animate_line_symbol(points_path);
      }
    }
  })
}

function create_point_marker(map, points, up_level = '../', is_draged = true,) {
  // loop on points to display it
  points.forEach(point => {
    // check if point has coordinates
    if (point['coordinates'] != null && point['coordinates'] != '') {
      // get latitude and longitude as an object
      let latLng = getLatLong(point['coordinates']);

      // check latitude and longitude value
      // if not null create a pin element
      if (latLng != null) {
        // get point style
        const point_style = get_point_style(point['is_client'], point['device_type']);

        // request fro get encoded id
        $.post(`${up_level}requests/index.php?do=get-encoded-id`, { id: point['id'] }, (res_encoded_id) => {
          // get encoded id
          const encoded_id = res_encoded_id.replace(/['"]+/g, "");

          // prepare link
          const link = `${up_level}${point_style.point_page_type}s/index.php?do=edit-${point_style.point_page_type}&${point_style.point_page_type}-id=${encoded_id}`;

          // set marker page edit
          let point_screen_msg = `<a id='point-${point['id']}' href='${link}' target='_blank'>${point['full_name']}</a><br>`;

          if (point['ip'] == '0.0.0.0' || point['ip'].length == 0) {
            ip_msg = `<p class='lead text-danger mb-0'>${lang.ip_null}</p>`;
          } else {
            ip_msg = `<p class='lead mb-0' style="color: ${point_style.color}"><a href="${point['port'] == null ? 'https' : 'http'}://${point['ip']}" target="_blank">${point['ip']}</a></p>`;
          }
          point_screen_msg += ip_msg;
          // Change the background color.
          const pinStyle = new google.maps.marker.PinElement({
            glyph: create_pin_icon(point_style.point_type),
            glyphColor: "#f6f6f6",
            background: point_style.color,
            borderColor: point_style.borderColor,
          });

          // create point_marker
          const point_marker = new google.maps.marker.AdvancedMarkerElement({
            map,
            position: latLng,
            title: point['full_name'],
            content: pinStyle.element,
            gmpDraggable: is_draged,
          });

          // set point id to marker
          point_marker.setAttribute('data-point-id', point['id']);

          if (is_draged) {
            // add event when marker draged
            point_marker.addListener("dragend", (event) => {
              // get marker new position
              const position = point_marker.position;

              // check if input id was created
              if (document.querySelector(`#point${point_marker.dataset.pointId}`) === null) {
                // create input for id
                let input_id = craete_input(`${point_marker.dataset.pointId}`, 'id', `${point_marker.dataset.pointId}`);
                // create input for coordinates
                let input_coordinates = craete_input(`${point_marker.dataset.pointId}-coor`, 'coordinates', `${position.lat}, ${position.lng}`);
                // get form to push inputs
                let form = get_edit_coordinates_form('edit-coordinates-form');
                // push inputs to form
                form.appendChild(input_id)
                form.appendChild(input_coordinates)
              } else {
                // get input coordinates to update it
                let input_coordinates = document.querySelector(`#point${point_marker.dataset.pointId}-coor`);
                // update coordinates
                input_coordinates.value = `${position.lat}, ${position.lng}`;
              }
              // check form
              check_form_inputs('edit-coordinates-form', 'edit-coordinates-submit-form');
            });
          }

          // attach screen message
          attach_screen_message(point_marker, point_screen_msg);
        })
      }
    }
  });
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (let i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}


// Use the DOM setInterval() function to change the offset of the symbol
// at fixed intervals.
function animate_line_symbol(line) {
  let count = 0;

  window.setInterval(() => {
    count = (count + 1) % 200;

    const icons = line.get("icons");

    icons[0].offset = count / 2 + "%";
    line.set("icons", icons);
  }, 20);
}

//
function get_edit_coordinates_form(id) {
  return document.querySelector(`#${id}`);
}

function craete_input(id, name, value) {
  // create an input
  let input = document.createElement('input');
  // set input value
  input.value = `${value}`;
  // set input name
  input.name = `${name}[]`;
  // input id
  input.id = `point${id}`;
  // return input
  return input;
}

function check_form_inputs(form_id, submit_btn_id) {
  // get form
  let form = document.querySelector(`#${form_id}`);
  // get submit button
  var submit_btn = document.querySelector(`#${submit_btn_id}`);
  // check form elements
  if (form.elements.length > 2) {
    // display it
    submit_btn.classList.remove('d-none');
    submit_btn.type = "submit";
  } else {
    // hide it
    submit_btn.classList.add('d-none');
    submit_btn.type = "button";
  }
}
