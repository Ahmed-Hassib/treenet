<?php

/**
 * function of words in arabic
 */
function login($phrase)
{
  static $lang = array(
    // global words
    'LOGIN'             => 'تسجيل الدخول',
    'SIGNUP'            => 'تسجيل جديد',

    // signup words
    'COMPANY INFO'    => 'بيانات الشركة',
    'COMPANY NAME'    => 'إسم الشركة',
    'COMPANY CODE'    => 'كود الشركة',
    'MANAGER NAME'    => 'إسم المدير',
    'COUNTRY'         => 'الدولة',
    'SELECT COUNTRY'  => 'إختر الدولة',
    'ADDRESS'         => 'العنوان',
    'PHONE'           => 'التليفون',
    'ADMIN LOGIN INFO'=> 'بيانات مدير الشركة لتسجيل الدخول',
    'USERNAME'        => 'إسم المستخدم',
    'PASSWORD'        => 'الرقم السرى',
    'CONFIRM PASSWORD'=> 'تأكيد الرقم السرى',
    'FULLNAME'        => 'الإسم كامل',
    'GENDER'          => 'النوع',
    'SELECT GENDER'   => 'إختر النوع',
    'MALE'            => 'ذكر',
    'FEMALE'          => 'أنثى',
    'FROM HERE'       => 'من هنا',

    // large global words
    'DON`T HAVE ACCOUNT'  => 'لا تمتلك حساب',
    'VISIT WEBSITE'       => 'يمكنك زيارة موقعنا الإلكترونى',

    // global messages
    'COMPANY EMPTY'     => 'إسم الشركة فارغ',
    'MANAGER EMPTY'     => 'إسم المدير فارغ',
    'PHONE EMPTY'       => 'رقم التليفون فارغ',
    'COUNTRY EMPTY'     => 'الدولة لم تُحدد',
    'FULLNAME EMPTY'    => 'الإسم الكامل فارغ',
    'USERNAME EMPTY'    => 'إسم المستخدم فارغ',
    'PASSWORD EMPTY'    => 'الرقم السري فارغ',
    'CODE EMPTY'        => 'كود الشركة فارغ',
    'GENDER EMPTY'      => 'النوع لم يُحدد',
    'LOGIN SUCCESS'     => 'تسجيل دخول ناجح',
    'LOGIN FAILED'      => 'تسجيل دخول خاطئ',
    'COMPANY INSERTED'  => 'تم إضافة بيانات الشركة بنجاح',
    'LICENSE INSERTED'  => 'تم تفعيل نسخة مجانية تجريبية لمدة شهر',
    'ADMIN INSERTED'    => 'تم إضافة بيانات مدير الشركة بنجاح',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
