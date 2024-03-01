<?php

/**
 * function of words in arabic
 */
function directions($phrase)
{
  static $lang = array(
    // words
    'LIST' => 'قائمة الإتجاهات',
    'DIR NAME' => 'إسم الإتجاه',
    'DIRECTION' => 'إتجاه',
    'DIRECTIONS' => 'إتجاهات',
    'THE DIRECTION' => 'الإتجاه',
    'THE DIRECTIONS' => 'الإتجاهات',
    'SELECT DIRECTION' => 'إختر الإتجاه',
    'SHOW DIR PCS' => 'عرض أجهزة إتجاه',
    'SHOW DIR UNK' => 'عرض غير معروف في إتجاه',
    'CURRENT DIRECTION' => 'الإتجاه الحالى',
    'DIRECTIONS TREE' => 'شجرة الاتجاهات',
    'DIRECTIONS MAP' => 'خرطة الاتجاهات',
    'SHOW TREE' => 'رؤية شجرة الاتجاه',
    'UPDATE COORDINATES' => 'تحديث الاحداثيات',

    // large words
    'CANNOT DELETE' => 'لا يمكن حذف هذا الإتجاه لوجود أكتر من جهاز أو عميل عليه',
    'SELECT DIR MAP NOTE' => 'برجاء اختيار الإتجاه المطلوب لعرض جميع النقاط والعملاء الخاصة به علي خريطة جوجل',

    // messages
    'DIRECTION ERROR' => 'إسم الإتجاه لا يمكن أن يكون فارغاً',
    'NAME EXIST' => 'إسم هذا الإتجاه موجود بالفعل',
    'INSERTED' => 'تم إضافة إتجاه جديد بنجاح',
    'UPDATED' => 'تم تعديل بيانات الإتجاه بنجاح',
    'DELETED' => 'تم حذف الإتجاه بنجاح',
    'COORDINATES UPDATED' => 'تم تحديث جميع الاحداثيات بنجاح',
    'SOME COORDINATES UPDATED' => 'تم تحديث بعض الاحداثيات بنجاح وحدث خطأ في تحديث البعض الآخر',

    // buttons words
    'ADD NEW' => 'إضافة إتجاه جديد',
    'EDIT DIR' => 'تعديل إتجاه',
    'DELETE DIR' => 'حذف إتجاه',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
