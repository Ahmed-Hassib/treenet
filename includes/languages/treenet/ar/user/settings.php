<?php

/**
 * function of words in arabic
 */
function settings($phrase)
{
  static $lang = array(
  // words
  'SETTINGS' => 'الاعدادات',
  'COMPANY BRAND' => 'شعار الشركة',
  'CHANGE IMG' => 'تغيير الصورة',
  'OTHER' => 'أخرى',
  'PING COUNTER' => 'عدد رسائل Ping',
  'SYSTEM INFO' => 'بيانات النظام',
  'FOREVER' => 'مدى الحياة',
  'MONTHLY' => 'شهرى',
  '3 MONTH' => '3 أشهر',
  '6 MONTH' => '6 أشهر',
  'YEARLY' => 'سنوى',
  'ACTIVE' => 'نشط',
  'TRIAL' => 'نسخة تجريبية',
  'COMPANY NAME' => 'إسم الشركة',
  'COMPANY CODE' => 'كود الشركة',
  'APP VERSION' => 'إصدار البرنامج',
  'LICENSE' => 'نوع الاشتراك',
  'START DATE' => 'تاريخ البدء',
  'EXPIRY' => 'تاريخ الإنتهاء',
  'SYSTEM LANG' => 'لغة النظام',
  'LICENSE STATUS' => 'حالة الاشتراك',

  // large words
  'DEFAULT IMG' => 'هذة الصورة الإفتراضية للنظام',
  'IMG ERROR' => 'توجد مشكلة في تحميل صورة الشركة الخاصة بك',

  // messages
  'IMG UPDATED' => 'تم تغيير صورة الشركة بنجاح',
  'SETTINGS UPDATED' => 'تم حفظ الإعدادات بنجاح',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}