
$('.renew-license-btn').on('click', function () {
  // select table
  var table_row = this.parentElement.parentElement;
  // get company data
  var data = table_row.children;

  // company id
  let company_id = data[0].textContent.trim();
  // company name
  let company_name = data[3].textContent.trim();

  // put it in the modal
  $('#company-id').val(company_id);
  $('#company-name').val(company_name);
  // reset value of the select box
  $('#license').val('default');
});


$('.delete-btn').on('click', function () {
  // select table
  var table_row = this.parentElement.parentElement;
  // get company data
  var data = table_row.children;

  // company id
  let company_id = data[0].textContent.trim();

  // put data 
  $('#deleted-company-id').val(company_id);
});