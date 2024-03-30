

/**
 * fullname_validation function
 * used for full name validation  
 */
function fullname_validation(input, id = null, is_combination = false) {
  // get input value
  let value = input.value;
  let container = input.parentElement;

  // check vallue
  if (value.length > 0) {
    // type of message
    let is_valid = false;
    // check id is set
    if (id != null) {
      url_content = `../requests/index.php?do=check-piece-fullname&fullname=${value}&id=${id}`;
    } else {
      url_content = `../requests/index.php?do=check-piece-fullname&fullname=${value}`;
    }
    // get request to check if full name is exist or not
    $.get(url_content, (res) => {
      // convert result
      let result = $.parseJSON(res);
      // is_exist variable
      let is_exist = result[0];
      // counter variable
      let counter = result[1];
      // delete all alerts
      delete_alerts(container);
      // check if exist
      if (is_exist == true && counter > 0) {
        // add invalid class to input
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

        // set boolean variable false
        input.dataset.valid = "false";
        // add alert
        container.appendChild(create_alert('warning', 'الاسم موجود من قبل'))
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

        // set boolean variable true
        input.dataset.valid = "true";
        // add alert
        container.appendChild(create_alert('success', 'الاسم صالح'))
      }
    });
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';
    // delete all alerts
    delete_alerts(container);
  }

  setTimeout(() => {
    // if this is a combination check 
    // check client name in combinations
    if (is_combination) {
      check_combination_client_name(input)
    }
  }, 10);
}

/**
 * ip_validation function
 * used for full name validation  
 */
function ip_validation(input, id = null) {
  // get input value
  let value = input.value;
  let container = input.parentElement;
  // delete all alerts
  delete_alerts(container)
  // check vallue
  if (value.length > 0) {
    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(value)) {
      // type of message
      let is_valid = false;
      // check id is set
      if (id != null) {
        url_content = `../requests/index.php?do=check-piece-ip&ip=${value}&id=${id}`;
      } else {
        url_content = `../requests/index.php?do=check-piece-ip&ip=${value}`;
      }

      if (value != '0.0.0.0' && value.length > 0) {
        // get request to check if full name is exist or not
        $.get(url_content, (res) => {
          // converted data
          let result = $.parseJSON(res);
          // is_exist
          let is_exist = result[0];
          // counter
          let counter = result[1];
          // check if exist
          if (is_exist == true && counter > 0) {
            // add invalid class to input
            input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
            localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

            input.dataset.valid = "false";
            // set boolean variable false
            is_valid = false;
            // add alert
            container.appendChild(create_alert('warning', 'عنوان بروتوكول الانترنت موجود بالفعل'))
          } else {
            input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
            localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

            input.dataset.valid = "true";
            // set boolean variable true
            is_valid = true;
            // add alert
            container.appendChild(create_alert('success', 'عنوان بروتوكول الانترنت صالح'))
          }
        });
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

        input.dataset.valid = "true";
      }
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
      localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

      input.dataset.valid = "false";
      // add alert
      container.appendChild(create_alert('warning', 'عنوان بروتوكول الانترنت غير صالح'))
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';;
  }
}

/**
 * mac_validation function
 * used for full name validation  
 */
function mac_validation(input, id = null) {
  // get input value
  let value = input.value;
  let container = input.parentElement;
  // delete all alerts
  delete_alerts(container)

  if (value.length > 0) {
    if (/^[0-9a-f]{1,2}([.:-])[0-9a-f]{1,2}(?:\1[0-9a-f]{1,2}){4}$/i.test(value)) {
      // check vallue
      // type of message
      let is_valid = false;
      // check id is set
      if (id != null) {
        url_content = `../requests/index.php?do=check-piece-macadd&mac_add=${value}&id=${id}`;
      } else {
        url_content = `../requests/index.php?do=check-piece-macadd&mac_add=${value}`;
      }
      // get request to check if full name is exist or not
      $.get(url_content, (res) => {
        // converted data
        let result = $.parseJSON(res);
        // is_exist
        let is_exist = result[0];
        // counter
        let counter = result[1];
        // check if exist
        if (is_exist == true && counter > 0) {
          // add invalid class to input
          input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
          localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

          input.dataset.valid = "false";
          // set boolean variable false
          is_valid = false;
          // add alert
          container.appendChild(create_alert('warning', 'MAC Address موجود بالفعل'))
        } else {
          input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
          localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

          input.dataset.valid = "true";
          // set boolean variable true
          is_valid = true;
          // add alert
          container.appendChild(create_alert('success', 'MAC Address صالح'))
        }
      });
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
      localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

      input.dataset.valid = "false";
      // add alert
      container.appendChild(create_alert('warning', 'MAC Address غير صالح'))
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';;
  }
}

function double_input_validation(input) {
  // get input value
  let value = input.value;
  let container = input.parentElement;
  // delete all alerts
  delete_alerts(container)
  // check value length
  if (value.length > 0) {
    // check value
    if (/^\d{0,4}(\.\d{0,2}){0,1}$/.test(value)) {
      input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
      localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

      input.dataset.valid = "true";
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
      localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

      input.dataset.valid = "false";
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';;
  }
}

function integer_input_validation(input) {
  // get input value
  let value = input.value;

  // check value length
  if (value.length > 0) {
    // check value
    if (/^\d{0,5}$/.test(value)) {
      input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
      localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

      input.dataset.valid = "true";
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
      localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

      input.dataset.valid = "false";
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';;
  }
}


// function to check if username is exist
function check_username(input, id = null) {
  // get input value
  let value = input.value;
  let container = input.parentElement;
  // delete all alerts
  delete_alerts(container)
  // check value
  if (value.length >= 4) {
    // get request to check if username is exits
    $.get(`../requests/index.php?do=check-username&username=${value}`, (res) => {
      // converted res
      let result = $.parseJSON(res);
      // is_exist
      let is_exist = result[0];
      // counter
      let counter = result[1];
      // check data length
      if (is_exist == true && counter > 0) {
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

        input.dataset.valid = "false";
        input.form.dataset.valid = "false";
        // add alert
        container.appendChild(create_alert('warning', 'اسم المستخدم موجود بالفعل'))
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

        input.dataset.valid = "true";
        input.form.dataset.valid = "true";
        // add alert
        container.appendChild(create_alert('success', 'اسم المستخدم صالح'))
      }
    })
  } else {
    container.appendChild(create_alert('warning', 'اسم المستخدم لا يمكن ان يقل عن 4 حروف'))
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';
  }
}

function direction_validation(input) {
  // get input value
  let value = input.value;
  // get direction id 
  let id = input.dataset.id;
  let container = input.parentElement;
  // delete all alerts
  delete_alerts(container)
  // check value
  if (value.length > 0) {
    // check id is set
    if (id != null) {
      url_content = `../requests/index.php?do=check-direction&direction-name=${value}&id=${id}`;
    } else {
      url_content = `../requests/index.php?do=check-direction&direction-name=${value}`;
    }

    // get request to check if direction is exits
    $.get(url_content, (res) => {
      // converted res
      let result = $.parseJSON(res);
      // is_exist
      let is_exist = result[0];
      // counter
      let counter = result[1];
      // console.log(is_exist)
      // check data length
      if (is_exist == true && counter > 0) {
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

        input.dataset.valid = "false";
        input.form.dataset.valid = "false";
        // add alert
        container.appendChild(create_alert('warning', 'اسم الاتجاه موجود بالفعل'))
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

        input.dataset.valid = "true";
        input.form.dataset.valid = "true";
        // add alert
        container.appendChild(create_alert('success', 'اسم إتجاه صالح'))
      }
    })
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';
  }
}



function change_company_alias(input) {
  // get input value
  let value = input.value;
  // get addon wrapping 
  let addon_wrapping = document.querySelector("#addon-wrapping");
  // check value length
  if (value.length > 0) {
    // check if name has a white space
    if (value.match(/^[a-z.\-\_]+$/)) {
      // get request to check if copany is exits
      $.get(`../requests/index.php?do=check-company-alias&company-alias=${value}`, (res) => {
        // converted res
        let result = $.parseJSON(res);
        // is_exist
        let is_exist = result[0];
        // counter
        let counter = result[1];
        // check data length
        if (is_exist == true && counter > 0) {
          input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
          localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

          input.dataset.valid = "false";
        } else {
          if (addon_wrapping != null) {
            // put company alias into addo wrapping
            addon_wrapping.textContent = `@${value.trim()}`;
          }
          // add valid class to input
          input.classList.contains("is-invalid") ? input.classList.replace("is-invalid", "is-valid") : input.classList.add("is-valid")
          localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

          // set valid attribute true
          input.dataset.valid = true;
        }
      })
    } else {
      // add invalid class to input
      input.classList.contains("is-valid") ? input.classList.replace("is-valid", "is-invalid") : input.classList.add("is-invalid")
      localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

      // set valid attribute false
      input.dataset.valid = false;
    }
  } else if (value.length > 0 && value.length < 12) {
    // add invalid class
    input.classList.contains("is-valid") ? input.classList.replace("is-valid", "is-invalid") : input.classList.add("is-invalid")
    localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

  } else {
    if (addon_wrapping != null) {
      // remove company alias from addo wrapping
      addon_wrapping.textContent = '';
    }
    // remove all classes
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';
  }
}


function check_combination_client_name(input) {
  // get input value
  let value = input.value;

  // check vallue
  if (value.length > 0) {
    // type of message
    let is_valid = false;

    // url content
    url_content = `../requests/index.php?do=check-combination-client-name&client-name=${value}`;
    // get request to check if full name is exist or not
    $.get(url_content, (res) => {
      // convert result
      let result = $.parseJSON(res);
      // is_exist variable
      let is_exist = result[0];
      // counter variable
      let counter = result[1];
      // check if exist
      if (is_exist == true && counter > 0) {
        // add invalid class to input
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')

        // set boolean variable false
        input.dataset.valid = "false";
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')

        // set boolean variable true
        input.dataset.valid = "true";
      }
    });
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';;
  }
}

function create_alert(type, message) {
  // create alert container
  let alert_container = document.createElement('div');
  // get alert type class
  switch (type) {
    case 'warning':
      alert_type = 'alert-warning';
    case 'success':
      alert_type = 'alert-success';
    case 'info':
      alert_type = 'alert-info';
    case 'danger':
      alert_type = 'alert-danger';
    default:
      alert_type = '';
  }
  // add alert classes
  alert_container.classList.add('alert', alert_type, 'mt-1');
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

