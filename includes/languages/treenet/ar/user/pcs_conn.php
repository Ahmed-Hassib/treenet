<?php

/**
 * function of words in arabic
 */
function pcs_conn($phrase)
{
  static $lang = array(
  // words
  'DASHBOARD' => 'لوحة التحكم',
  'CONN NAME' => 'إسم نوع الإتصال',
  'CONN TYPE' => 'نوع الإتصال',
  'CONN TYPES' => 'انواع الإتصال',
  'SELECT CONN TYPE' => 'إختر نوع الإتصال',
  'EDIT CONN' => 'تعديل نوع إتصال',
  'DELETE CONN' => 'حذف نوع إتصال',
  'CONN STATISTICS' => 'إحصائيات أنواع الإتصال',
  'OLD NAME' => 'الإسم القديم',
  'NEW NAME' => 'الإسم الجديد',

  // large words
  'CONN NOTE' => 'يُعرض هنا بعض الأرقام والإحصائيات عن أنواع الإتصال',

  // messages
  'INSERTED' => 'تم إضافة نوع إتصال جديد بنجاح',
  'UPDATED' => 'تم تعديل نوع الإتصال بنجاح',
  'DELETED' => 'تم حذف نوع إتصال بنجاح',
  'CONN NULL' => 'الإسم الجديد لا يمكن أن يكون فارغاً',

  // buttons words
  'ADD NEW' => 'إضافة نوع إتصال جديد',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
