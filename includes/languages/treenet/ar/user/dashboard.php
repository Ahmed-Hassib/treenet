<?php

/**
 * function of words in arabic
 */
function dashboard($phrase)
{
  static $lang = array(
    'DASHBOARD' => 'لوحة التحكم',
    'LOGIN' => 'تسجيل الدخول',
    'SIGNUP' => 'تسجيل جديد',
    'SEARCH FEATURE' => 'خاصية البحث',
    'CONTACT US' => 'تواصل معنا',

    // large global words
    'INVALID EMAIL' => 'بريد الكتروني غير صالح',
    'EMPTY MESSAGE' => 'رسالتك فارغة، برجاء كتابة رساله واضحة',
    'SEARCH HERE' => 'ابحث عن ما تريد هنا',
    'GO TO INTRO VIDEO' => 'الذهاب لفيديو التعريف',
    'SEARCH FEATURE NOTE' => 'يتيح لك البرنامج امكانية البحث عن ما تريد حيث يعتمد البحث في البرنامج علي البحث في كافة اقسام النظام مما يسهل علي المستخدم الوصول السريع لما يريد.',
    'PUT YOUR MESSAGE HERE' => 'اكتب استفسارك/رسالتك هنا',
    'MESSAGE WAS SENT' => 'تم إرسال رسالتكم بنجاح وسيتم الرد عليها في اقرب وقت',

    // global messages
    'LOGIN SUCCESS' => 'تسجيل دخول ناجح',
    'LOGIN FAILED' => 'تسجيل دخول خاطئ',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
