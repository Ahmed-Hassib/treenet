<?php

/**
 * function of words in arabic
 */
function employees($phrase)
{
  static $lang = array(
    // employees words
    'ADD NEW'           => 'اضافة موظف جديد',
    'EDIT'              => 'تعديل موظف',
    'GENERAL INFO'      => 'المعلومات العامة',
    'FULLNAME'          => 'الإسم كامل',
    'GENDER'            => 'النوع',
    'SELECT GENDER'     => 'إختر النوع',
    'MALE'              => 'ذكر',
    'FEMALE'            => 'أنثى',
    'ADDRESS'           => 'العنوان',
    'PERSONAL INFO'     => 'المعلومات الشخصية',
    'EMAIL'             => 'الايميل',
    'PHONE'             => 'التليفون',
    'BIRTH'             => 'تاريخ الميلاد',
    'JOB INFO'          => 'ملومات العمل',
    'JOB TITLE'         => 'الوظيفة',
    'NOT JOB TITLE'     => 'الوظيفة لم تُحدد',
    'ALL EMPLOYEES'     => 'جميع الموظفين',
    'SOCIAL MEDIA'      => 'وسائل التواصل الاجتماعى',
    'PERMISSIONS'       => 'الصلاحيات',
    'LIST'              => 'قائمة الموظفين',
    'CONFIRM DELETE'    => 'تأكيد الحذف',


    // employees job title
    'THE MANAGER'             => 'المدير',
    'MALF & COMB TECHNICAL'   => 'فنى أعطال وتركيبات',
    'CUSTOMER SERVICES'       => 'خدمة عملاء',
    'AFTER SALES'             => 'خدمة ما بعد البيع',
    'ACCOUNTANT'              => 'محاسب',
    'STOREKEEPER'             => 'أمين مخزن',

    // messages
    'NO EMPLOYEES'          => 'لا يوجد موظفين لعرضهم برجاء اضافة البعض',
    'INSERTED'              => 'تم إضافة بيانات الموظف بنجاح',
    'UPDATED'               => 'تم تعديل بيانات الموظف بنجاح',
    'DELETED'               => 'تم حذف بيانات الموظف بنجاح',
    'USERNAME EXIST'        => 'اسم المستخدم موجود بالفعل',
    'USERNAME LENGTH'       => 'اسم المستخدم لا يمكن أن يقل عن 4 أحرف',
    'USERNAME EMPTY'        => 'إسم المستخدم لا يمكن أن يكون فارغاً',
    'FULLNAME EMPTY'        => 'لإسم الموظف لا يمكن أن يكون فارغاً',
    'PASSWORD EMPTY'        => 'الرقم السري لا يمكن أن يكون فارغاً',
    'IMG ERROR'             => 'يوجد مشكلة في تحميل الصورة الشخصية لك',
    'PHONE NOT ACTIVATED'   => 'رقم التليفون غير مفعل',
    'USERNAME LOGIN'        => 'يستخدم إسم المستخدم في تسجيل الدخول',

    // large messages
    'ENTER NEW PASSSWORD' => 'ادخل الرقم السري الجديد لحفظه',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
