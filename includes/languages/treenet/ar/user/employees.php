<?php

/**
 * function of words in arabic
 */
function employees($phrase)
{
  static $lang = array(
    // employees words
    'EMPLOYEE' => 'موظف',
    'EMPLOYEES' => 'موظفين',
    'THE EMPLOYEE' => 'الموظف',
    'THE EMPLOYEES' => 'الموظفين',
    'GENERAL INFO' => 'المعلومات العامة',
    'FULLNAME' => 'الإسم كامل',
    'GENDER' => 'النوع',
    'SELECT GENDER' => 'إختر النوع',
    'MALE' => 'ذكر',
    'FEMALE' => 'أنثى',
    'ADDRESS' => 'العنوان',
    'PERSONAL INFO' => 'المعلومات الشخصية',
    'EMAIL' => 'البريد الإلكتروني',
    'PHONE' => 'التليفون',
    'BIRTH' => 'تاريخ الميلاد',
    'JOB INFO' => 'اختصاص الموظف',
    'JOB TITLE' => 'الوظيفة',
    'NOT JOB TITLE' => 'الوظيفة لم تُحدد',
    'ALL EMPLOYEES' => 'جميع الموظفين',
    'SOCIAL MEDIA' => 'وسائل التواصل الاجتماعى',
    'PERMISSIONS' => 'الصلاحيات',
    'LIST' => 'قائمة الموظفين',
    'PROFILE' => 'الصفحة الشخصية',
    'PERMANENT DELETE' => 'حذف دائم',
    'DELETES' => 'المحذوفات',
    'RESTORE' => 'استرجاع الموظف',

    
    
    // employees job title
    'THE MANAGER' => 'المدير',
    'MALF & COMB TECHNICAL' => 'فنى أعطال وتركيبات',
    'CUSTOMER SERVICES' => 'خدمة عملاء',
    'AFTER SALES' => 'خدمة ما بعد البيع',
    'ACCOUNTANT' => 'محاسب',
    'STOREKEEPER' => 'أمين مخزن',
    
    // messages
    'NO EMPLOYEES' => 'لا يوجد موظفين لعرضهم برجاء اضافة البعض',
    'INSERTED' => 'تم إضافة بيانات الموظف بنجاح',
    'UPDATED' => 'تم تعديل بيانات الموظف بنجاح',
    'TEMP DELETED' => 'تم حذف بيانات الموظف مؤقتاً بنجاح',
    'DELETED' => 'تم حذف بيانات الموظف نهائياً بنجاح',
    'RESTORED' => 'تم استرجاع بيانات الموظف بنجاح',
    'USERNAME EXIST' => 'اسم المستخدم موجود بالفعل',
    'USERNAME LENGTH' => 'اسم المستخدم لا يمكن أن يقل عن 4 أحرف',
    'USERNAME EMPTY' => 'إسم المستخدم لا يمكن أن يكون فارغاً',
    'FULLNAME EMPTY' => 'لإسم الموظف لا يمكن أن يكون فارغاً',
    'PASSWORD EMPTY' => 'الرقم السري لا يمكن أن يكون فارغاً',
    'IMG ERROR' => 'توجد مشكلة في تحميل الصورة الشخصية لك',
    'PHONE NOT ACTIVATED' => 'رقم التليفون غير مفعل',
    'USERNAME LOGIN' => 'يستخدم إسم المستخدم في تسجيل الدخول',
    'PERMISSION UPDATE FAILED' => 'ليس لديك الصلاحية للتعديل',
    
    // large messages
    'ENTER NEW PASSSWORD' => 'ادخل الرقم السري الجديد لحفظه',
    'ACTIVATION CODE MSG' => 'هذا هو كود تفعيل رقم الهاتف الخاص بك علماً بأن كود التفعيل تنتهي صلاحيته خلال 10دقائق من الآن',
    'ACTIVATION CODE SENT' => 'تم ارسال كود التفعيل الي الواتس اب الخاص بك',
    'ACTIVATION CODE EXPIRED' => 'تم انتهاء صلاحية كود التفعيل الخاص بك',
    'ACTIVATION CODE VALID' => 'كود التفعيل الخاص بك سارى حتي الآن',
    'RESEND ACTIVATION CODE' => 'إعادة إرسال كود التفعيل',
    'WRONG PHONE' => 'عذراً! رقم هاتفكم غير صحيح برجاء التأكد من ادخال رقم هاتف صحيح',
    'INVALID WHATSAPP ACCOUNT' => 'عذراً هذا الرقم ليس لديه حساب علي واتس اب لكي يتم تفعيله',
    'MOBILE ACTIVATED' => 'تم تفعيل رقم هاتفك بنجاح يمكنك الآن تلقي بعض الاشعارات عن طريق واتس اب شكراً لك!',
    
    // buttons words
    'EDIT' => 'تعديل موظف',
    'ADD NEW' => 'اضافة موظف جديد',
    'CONFIRM DELETE' => 'تأكيد الحذف',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
