<?php

/**
 * function of words in arabic
 */
function login($phrase)
{
  static $lang = array(
  // global words
  'LOGIN' => 'تسجيل الدخول',
  'SIGNUP' => 'تسجيل جديد',
  'START NOW' => 'ابدأ الآن',
  'RESET PASSWORD' => 'إعادة تعيين كلمة المرور',

  // signup words
  'COMPANY INFO' => 'بيانات الشركة',
  'COMPANY NAME' => 'إسم الشركة',
  'COMPANY CODE' => 'كود الشركة',
  'MANAGER NAME' => 'إسم المدير',
  'COUNTRY' => 'الدولة',
  'SELECT COUNTRY' => 'إختر الدولة',
  'ADDRESS' => 'العنوان',
  'PHONE' => 'التليفون',
  'ADMIN LOGIN INFO' => 'بيانات مدير الشركة لتسجيل الدخول',
  'USERNAME' => 'إسم المستخدم',
  'PASSWORD' => 'الرقم السرى',
  'CONFIRM PASSWORD' => 'تأكيد الرقم السرى',
  'FULLNAME' => 'الإسم كامل',
  'GENDER' => 'النوع',
  'SELECT GENDER' => 'إختر النوع',
  'MALE' => 'ذكر',
  'FEMALE' => 'أنثى',
  'FROM HERE' => 'من هنا',
  'RESET CODE' => 'الكود المُرسل',

  // large global words
  'DON`T HAVE ACCOUNT' => 'لا تمتلك حساب',
  'VISIT WEBSITE' => 'يمكنك زيارة موقعنا الإلكترونى',

  // global messages
  'COMPANY EMPTY' => 'إسم الشركة فارغ',
  'MANAGER EMPTY' => 'إسم المدير فارغ',
  'PHONE EMPTY' => 'رقم التليفون فارغ',
  'COUNTRY EMPTY' => 'الدولة لم تُحدد',
  'FULLNAME EMPTY' => 'الإسم الكامل فارغ',
  'USERNAME EMPTY' => 'إسم المستخدم فارغ',
  'PASSWORD EMPTY' => 'الرقم السري فارغ',
  'CODE EMPTY' => 'كود الشركة فارغ',
  'GENDER EMPTY' => 'النوع لم يُحدد',
  'LOGIN SUCCESS' => 'تسجيل دخول ناجح',
  'LOGIN FAILED' => 'تسجيل دخول خاطئ',
  'COMPANY INSERTED' => 'تم إضافة بيانات الشركة بنجاح',
  'LICENSE INSERTED' => 'تم تفعيل نسخة مجانية تجريبية لمدة شهر',
  'ADMIN INSERTED' => 'تم إضافة بيانات مدير الشركة بنجاح',
  'PERMISSION INSERTED' => 'تم أعطاء كافة الصلاحيات للمدير بنجاح',
  'MANAGER NOT TRIPLE' => 'إسم المدير يجب أن يكون ثلاثي الأجزاء',
  'ADMIN NOT TRIPLE' => 'إسم الأدمن يجب أن يكون ثلاثي الأجزاء',
  'PASSWORD RESET CODE MSG' => 'هذا الكود مصحوب برابط خاص بإسترجاع كلمة المرور الخاصة بنظام',
  'PASSWORD RESET CODE ALERT' => 'إذا لم تقم بطلب إعادة تعيين كلمة المرور فتجاهل هذة الرسالة',
  'PASSWORD RESET CODE EXPIRE' => 'برجاء الضغط علي الرابط لإعادة تعيين كلمة المرور مع العلم انه ينتهي صلاحيتة بعد 15 دقيقة من الآن وعدم مشاركتة مع احد',
  'PASSWORD RESET CODE SENT BEFORE' => 'تم إرسال كود ورابط إعادة تعيين كلمة المرور الخاص بك من قبل',
  'RESET PASS CODE SENT' => 'تم ارسال رابط إعادة تعيين كلمة المرور علي رقم الواتس آب الخاص بك',
  'LINK EXPIRED' => 'تم انتهاء صلاحية هذا الرابط برجاء المحاولة في وقت لاحق',
  'TOKEN NOT EQUAL' => 'رمز المصادقة غير صحيح',
  'PHONE NOT EXIST' => 'رقم التليفون هذا غير مُسجل لدينا',
  'PASSWRD NOT EQUAL' => 'كلمة المرور غير متطابقة',
  'PASSWORD UPDATED' => 'تم إعادة تعيين كلمة المرور الخاصة بك',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}