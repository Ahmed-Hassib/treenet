
(function () {
})()

function put_correct_class_validation(input, is_valid) {
  if (is_valid) {
    if (localStorage['lang'] == 'ar') {
      input.classList.contains('is-invalid-left') ? input.classList.replace('is-invalid-left', 'is-valid-left') : input.classList.add('is-valid-left');
    } else {
      input.classList.contains('is-invalid-right') ? input.classList.replace('is-invalid-right', 'is-valid-right') : input.classList.add('is-valid-right');
    }
  } else {
    if (localStorage['lang'] == 'ar') {
      input.classList.contains('is-valid-left') ? input.classList.replace('is-valid-left', 'is-invalid-left') : input.classList.add('is-invalid-left');
    } else {
      input.classList.contains('is-valid-right') ? input.classList.replace('is-valid-right', 'is-invalid-right') : input.classList.add('is-invalid-right');
    }
  }
}

function is_valid(input, type) {
  // switch ... case
  switch (type) {
    case 'company':
      check_company_name(input);
      break;

    case 'username':
      username_validation(input);
      break;

    default:
      break;
  }
}

// function to check if comapny name is exist
function check_company_name(input) {
  // get input value
  let value = input.value;
  // get addon wrapping 
  let alerts = document.querySelector("div.alert");

  // check value
  if (value.length > 0) {
    // get request to check if comapny name is exits
    $.get(`src/requests/index.php?do=check-company-name&name=${value}`, (data) => {
      // converted data
      let response = $.parseJSON(data);
      // check data length
      if (response.status == true) {
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
        put_correct_class_validation(input, false);
        input.dataset.valid = "false";
        alert = create_alert('warning', 'اسم الشركة موجود بالفعل!', 'w-100');
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        put_correct_class_validation(input, true);
        input.dataset.valid = "true";
        alert = create_alert('success', 'اسم الشركة صالح!', 'w-100');
      }

      // delete all company alerts if exxists
      delete_alerts(input.parentElement);
      // append new alert
      input.parentElement.appendChild(alert)
    })
  } else {
    input.classList.remove('is-valid', 'is-invalid')
  }
}

function username_validation(input) {
  // get input value
  let value = input.value;
  // get addon wrapping 
  let alerts = document.querySelector("div.alert");
  // check value length
  if (value.length > 0) {
    // check if name has a white space
    // if (value.match(/^[a-z\-]+$/)) {
    // get request to check if comapny name is exits
    $.get(`src/requests/index.php?do=check-username&username=${value}`, (data) => {
      // converted data
      let response = $.parseJSON(data);
      // if exist
      if (response.status) {
        // add valid class to input
        input.classList.contains("is-valid") ? input.classList.replace("is-valid", "is-invalid") : input.classList.add("is-invalid")
        put_correct_class_validation(input, false);
        // set valid attribute true
        input.dataset.valid = true;
        alert = create_alert('warning', 'اسم مستخدم موجود بالفعل!', 'w-100');
      } else {
        // add valid class to input
        input.classList.contains("is-invalid") ? input.classList.replace("is-invalid", "is-valid") : input.classList.add("is-valid")
        put_correct_class_validation(input, true);
        // set valid attribute true
        input.dataset.valid = true;
        alert = create_alert('success', 'اسم مستخدم صالح!', 'w-100');
      }
      // delete all username alerts if exxists
      delete_alerts(input.parentElement);
      // append new alert
      input.parentElement.appendChild(alert)
    })
    // } else {
    //   // add invalid class to input
    //   input.classList.contains("is-valid") ? input.classList.replace("is-valid", "is-invalid") : input.classList.add("is-invalid")
    //   // set valid attribute false
    //   input.dataset.valid = false;
    // }
  } else {
    // remove all classes
    input.classList.remove('is-valid', 'is-invalid')
  }
}

function showing_instruction(input) {
  // get input checked value
  let is_checked = input.checked;
  // store it in browser storage
  localStorage.setItem('showing_instruction', is_checked);
}

function create_alert(type, message, width = 'w-50') {
  // create alert container
  let alert_container = document.createElement('div');
  // add alert classes
  alert_container.classList.add('alert', (type == 'warning' ? 'alert-warning' : 'alert-success'), width, 'mx-auto', 'my-1', 'signup-alert');
  // add alert role
  alert_container.role = 'alert';
  // create a text node
  let alert_text_node = document.createTextNode(message)
  // append text node to alert container
  alert_container.appendChild(alert_text_node);
  // create a dismiss button
  let dismiss_btn = document.createElement('button');
  // add button attribute
  dismiss_btn.type = 'button';
  dismiss_btn.classList.add('btn-close');
  dismiss_btn.dataset.bsDismiss = 'alert';
  dismiss_btn.ariaLabel = 'Close';
  dismiss_btn.style.position = 'absolute';
  dismiss_btn.style.left = '10px';
  // append dismiss button to alert container
  alert_container.appendChild(dismiss_btn);
  // return alert
  return alert_container;
}


function delete_alerts(container) {
  let alerts = document.querySelectorAll('div.alert')

  if (alerts != null) {
    alerts.forEach((alert) => {
      if (container.contains(alert)) {
        alert.remove()
      }
    })
  }
}