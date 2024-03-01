// arabic words
var ar = {
  confirm: 'هل أنت متأكد؟',
  delete_confirm: 'هل أنت متأكد من الحذف؟',
  success_del_emp_img: 'تم حذف الصورة بنجاح! برجاء تحديث الجلسة لتطبيق التغييرات',
  save_changes_please: 'برجاء حفظ التغييرات',
  type: 'النوع',
  internet_src: 'مصدر الانتر نت',
  not_assign: 'لم يُحدد',
  notes: 'الملاحظات',
  visit_time: 'وقت الزيارة',
  direction_name: 'إسم الإتجاه',
  source_name: 'إسم المصدر',
  alt_source_name: 'إسم المصدر البديل',
  device_type_name: 'نوع الجهاز',
  model_name: 'الموديل',
  conn_name: 'نوع الإتصال',
  ip: 'IP',
  port: 'PORT',
  mac: 'MAC',
  username: 'إسم المستخدم',
  ssid: 'SSID',
  freq: 'التردد',
  wave: 'الموجة',
  delete_feature_faild: 'فشل حذف تفاصيل الميزة',
  delete_feature_succ: 'تم حذف تفاصيل الميزة بنجاح',
  connected: 'تم تحقيق الاتصال بميكروتيك الخاص بك بنجاح!',
  failed_connection: 'فشل تحقيق الإتصال بميكروتيك الخاص بك!',
  phone_number: 'رقم التليفون',
  max_num_phones: 'لقد تخطيت الحد الأقصى من عدد التليفونات..!',
  ip_null: 'لم يتم تحديد عنوان IP',
}

// english words
var en = {
  confirm: 'Are you sure?',
  delete_confirm: 'Are you sure for delete?',
  success_del_emp_img: 'Image has been deleted successfully! please, update session to apply chnages',
  save_changes_please: 'Please, save changes',
  type: 'type',
  internet_src: '',
  not_assign: '',
  notes: '',
  visit_time: '',
  direction_name: '',
  source_name: '',
  alt_source_name: '',
  device_type_name: '',
  model_name: '',
  conn_name: '',
  ip: '',
  port: '',
  mac: '',
  username: '',
  ssid: '',
  freq: '',
  wave: '',
  delete_feature_faild: '',
  delete_feature_succ: '',
  connected: '',
  faild_connection: '',
  phone_number: '',
  max_num_phones: '',
}

// default language
var lang = ar;
// get language
if (localStorage['lang'] != null) {
  lang = localStorage['lang'] == 'ar' ? ar : en;
}