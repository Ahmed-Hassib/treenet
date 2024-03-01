// table words in arabic
let table_words_ar = {
  "emptyTable": "لا توجد بيانات للعرض",
  "info": "عرض _START_ الي _END_ من _TOTAL_ صف",
  "infoEmpty": "عرض 0 الي 0 من 0 صف",
  "infoFiltered": "(تم البحث من خلال _MAX_ صف)",
  "lengthMenu": "عرض _MENU_ صفوف",
  "loadingRecords": "جارى تحميل البيانات...",
  "search": "البحث",
  "zeroRecords": "لا توجد بيانات متطابقة للبحث المطلوب",
  "paginate": {
    "first": "الاول",
    "last": "الاخير",
    "next": "التالى",
    "previous": "السابق"
  },
}

// table words in english
let table_words_en = {
  "emptyTable": "no data to show",
  "info": "show _START_ to _END_ from _TOTAL_ entries",
  "infoEmpty": "show 0 to 0 from 0 entries",
  "infoFiltered": "search was happened in _MAX_ entries",
  "lengthMenu": "show _MENU_ entries",
  "loadingRecords": "data loading...",
  "search": "search",
  "zeroRecords": "there is no data with your search words",
  "paginate": {
    "first": "first",
    "last": "last",
    "next": "next",
    "previous": "previous"
  },
}

// buttons words in arabic
var btn_words_ar = {
  excel: 'تحميل الجدول',
  colVis: 'رؤية الأعمدة'
}

// buttons words in english
var btn_words_en = {
  excel: 'excel',
  colVis: 'col visible'
}

$(document).ready(function () {
  // get table columns
  let dataTable = $('table.display');
  var lang = 'ar';

  // get language
  if (localStorage['lang'] != null) {
    lang = localStorage['lang'] == 'ar' ? 'ar' : 'en';
  }
  // check lang
  let curr_table_arr = lang == 'ar' ? table_words_ar : table_words_en;
  let curr_btn_arr = lang == 'ar' ? btn_words_ar : btn_words_en;

  if (dataTable != null) {
    // get the table
    var table = $('table.display').DataTable({
      scrollX: dataTable.data('scrollX'),
      scrollY: dataTable.data('scrollY') !== undefined ? dataTable.data('scrollY') : 500,
      responsive: true,
      autoWidth: false,
      ordering: true,
      stateSave: true,
      stateDuration: -1,
      lengthMenu: [
        [10, 50, 100, 500, -1],
        [10, 50, 100, 500, 'All'],
      ],
      dom: '<"#datatables-buttons.w-auto mb-2"B><".row g-3"<".col-sm-12 col-lg-6"f><".col-sm-12 col-lg-6 text-start"l>>tip',
      buttons: [
        { extend: 'excel', className: 'btn btn-outline-primary fs-12 py-1', text: curr_btn_arr.excel },
        { extend: 'colvis', className: 'btn btn-outline-primary fs-12 py-1', columns: ':not(.noVis)', text: curr_btn_arr.colVis }
      ],
      columnDefs: [
        { className: 'noVis', targets: [0, 1, -1] },
        { className: 'fs-12', targets: '_all' },
        { className: 'custome-td', targets: dataTable.data('lastTd') }
      ],

      "language": curr_table_arr
    });


    $('div.dataTables_scrollHead table.table-bordered').css('width', '100%!important');
  }

  let dataTable_container = $("#datatables-buttons");
  dataTable_container.css('direction', 'ltr')

  // select all data tables controls
  let dataTable_control_btn = $('.dt-buttons button');
  // loop on it
  dataTable_control_btn.each(function () {
    if (dataTable_control_btn.hasClass('btn-secondary')) {
      dataTable_control_btn.removeClass('btn-secondary')
    }
  })

  // get previous button
  let prev_btn = $('button.scroll-prev');
  // add click event
  prev_btn.click(function () {
    // get scroll value
    let scroll_value = $('.dataTables_scrollBody').scrollLeft();
    $('.dataTables_scrollBody').scrollLeft(scroll_value - 150)
  })

  // get next button
  let next_btn = $('button.scroll-next');
  // add click event
  next_btn.click(function () {
    // get scroll value
    let scroll_value = $('.dataTables_scrollBody').scrollLeft();
    $('.dataTables_scrollBody').scrollLeft(scroll_value + 150)
  })

});
