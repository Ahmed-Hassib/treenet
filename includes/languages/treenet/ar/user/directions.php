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
    'DIR CODE' => 'كود الإتجاه',
    'DIRS CODES' => 'أكواد الإتجاهات',
    'DIRECTIONS TREE' => 'شجرة الاتجاهات',
    'DIRECTIONS MAP' => 'خريطة الاتجاهات',
    'SHOW TREE' => 'رؤية شجرة الاتجاه',
    'UPDATE COORDINATES' => 'تحديث الاحداثيات',
    'UPLOAD DATA' => 'إرفاق بيانات الإتجاهات',
    'UPLOAD DATA BY FILE' => 'إرفاق بيانات الإتجاهات عن طريق ملف اكسيل',
    
    // large words
    'CANNOT DELETE' => 'لا يمكن حذف هذا الإتجاه لوجود أكتر من جهاز أو عميل عليه',
    'SELECT DIR MAP NOTE' => 'برجاء اختيار الإتجاه المطلوب لعرض جميع النقاط والعملاء الخاصة به علي خريطة جوجل',
    'INSTRUCTION 1' => 'تحميل الملف التالي عن طريق الضغط علي صورة الملف',
    'INSTRUCTION 2' => 'ادخال البيانات في العمود المحدد فقط',
    'INSTRUCTION 3' => 'عدم تغيير اسم الملف في حالة ارفاق الملف ببيانات الإتجاهات الخاصة بك',
    'INSTRUCTION 4' => 'انه في حالة ارفاق اي بيانات زيادة عن العمود المرفق سيتم تجاهلها تماماً',

    // messages
    'DIRECTION ERROR' => 'إسم الإتجاه لا يمكن أن يكون فارغاً',
    'NAME EXIST' => 'إسم هذا الإتجاه موجود بالفعل',
    'INSERTED' => 'تم إضافة إتجاه جديد بنجاح',
    'FILE INSERTED' => 'تم اضافة بيانات الاتجاهات المرفقة بنجاح مع تجاهل المخالف منها',
    'UPDATED' => 'تم تعديل بيانات الإتجاه بنجاح',
    'DELETED' => 'تم حذف الإتجاه بنجاح',
    'COORDINATES UPDATED' => 'تم تحديث جميع الاحداثيات بنجاح',
    'SOME COORDINATES UPDATED' => 'تم تحديث بعض الاحداثيات بنجاح وحدث خطأ في تحديث البعض الآخر',

    // buttons words
    'ADD NEW' => 'إضافة إتجاه جديد',
    'EDIT DIR' => 'تعديل إتجاه',
    'DELETE DIR' => 'حذف إتجاه',
    'DOWNLOAD DIRS FILE' => 'تحميل ملف الإتجاهات',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
