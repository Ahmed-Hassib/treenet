<?php

/**
 * function of words in arabic
 */
function services($phrase)
{
  static $lang = array(
    // words
    'THE SERVICES' => 'الخدمات',
    'MIKROTIK SERVICE' => 'خدمة ميكروتك',
    'CHECK CONNECTION' => 'فحص الإتصال',
    'MIKROTIK CONNECTION STATUS' => 'حالة الإتصال بميكروتيك الخاص بك',
    'WHATSAPP SERVICE' => 'خدمة واتس اب',

    // large words
    'DEFAULT IMG' => 'هذة الصورة الإفتراضية للنظام',

    // messages
    'IP EMPTY' => 'عنوان IP فارغ',
    'PORT EMPTY' => 'Port فارغ',
    'USERNAME EMPTY' => 'إسم المستخدم فارغ',
    'PASSWORD EMPTY' => 'الرقم السري فارغ',
    'MIKROTIK UPDATED' => 'تم تعديل بيانات ميكروتيك بنجاح',
    'MIKROTIK SERVICE STATUS ACTIVATED' => 'تم تفعيل خدمة ميكروتيك الخاص بك بنجاح ',
    'MIKROTIK SERVICE STATUS DEACTIVATED' => 'تم الغاء تفعيل خدمة ميكروتيك الخاص بك بنجاح ',
    'UPDATE MIKROTIK PORT 444' => 'برجاء تعديل port الخاص بهذا sstp-client الي 444',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
