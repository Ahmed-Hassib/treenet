/**
 * form_validation function
 * is used to check the required fields in form
 */
function form_validation(form = null, btn = null) {
  // error array
  let errorArray = Array();

  if (form != null) {
    // get all required inputs in the form
    var inputs = document.querySelectorAll(`#${form.getAttribute('id')} input`);
    // get all required select in the form
    var selects = document.querySelectorAll(`#${form.getAttribute('id')} select`);
  } else {
    // get all required inputs in the form
    var inputs = document.querySelectorAll("input");
    // get all required select in the form
    var selects = document.querySelectorAll("select");
  }

  // loop on inputs
  inputs.forEach(input => {
    // get input type
    let type = input.getAttribute('type');
    // check the required
    if (input.hasAttribute('required')) {
      // check if type of input is text
      switch (type) {
        case 'text': case 'email': case 'password': case 'date':
          input_validation(input);
          break;
      }
    } else {
      // check if type of input is text
      switch (type) {
        case 'text': case 'email': case 'password': case 'date':
          // check if empty
          if (input.value.length > 0) {
            input_validation(input);
          }
          break;
      }
    }
  })

  // loop on selects
  selects.forEach(select => {
    // check the required
    if (select.hasAttribute('required')) {
      // check if user not select anything
      if (select.selectedIndex == 0 || select.dataset.valid == "false") {
        errorArray.push(select);
      } else {
        input_validation(select);
      }
    }
  })

  // check array of the error
  if (errorArray.length > 0) {
    // loop on inputs to validate it
    errorArray.forEach(el => {
      if ((el.hasAttribute('onkeyup') && el.value.length == 0) || el.dataset.valid != "true") {
        input_validation(el);
      } else if (el.hasAttribute('onkeyup') && el.value.length > 0) {
        el.focus();
        el.blur();
      }
    })

    form.dataset.valid = false;
    // scroll on the top of the page
    document.body.scrollTo(0, 0);
  } else {
    form.dataset.valid = true
    // no error => check if the form is null
    // if not null submit it
    if (btn != null && form != null && form.dataset.valid == "true") {
      form.submit();
    }
  }
}


/**
 * input_validation function
 * is used to check the specific required input in form
 */
function input_validation(input) {
  if ((input.tagName.toLowerCase() == 'input' && input.value.length == 0) || (input.tagName.toLowerCase() == 'select' && input.selectedIndex == 0)) {
    // check if have an valid class
    input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
    localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')
    input.dataset.valid = "false";
  } else {
    input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid');
    localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')
    input.dataset.valid = "true";
  }
}

/**
 * invalid_input function
 * used to make input invalid
*/
function invalid_input(input) {
  // check if have an valid class
  input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
  localStorage.getItem('lang') == 'ar' ? input.classList.add('is-invalid-left') : input.classList.add('is-invalid-right')
  input.dataset.valid = "false";
}

/**
 * valid_input function
 * used to make input valid
*/
function valid_input(input) {
  // check if have an valid class
  input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid');
  localStorage.getItem('lang') == 'ar' ? input.classList.add('is-valid-left') : input.classList.add('is-valid-right')
  input.dataset.valid = "true";
}


function validate_password(input, is_valid = null) {
  if (input.value.length > 0 && is_valid != null) {
    if (is_valid) {
      input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid');
      put_correct_class_validation(input, true);
      input.dataset.valid = "true";
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
      put_correct_class_validation(input, false);
      input.dataset.valid = "false";
    }
  } else {
    input.classList.remove('is-valid*', 'is-invalid*')
    input.dataset.valid = '';
  }
}

function validate_email(email) {
  return email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);
}