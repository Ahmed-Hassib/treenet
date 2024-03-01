<?php

/**
 * function of words in arabic
 */
function dashboard_root($phrase, $param = null)
{
  static $lang = array(
  // words
  'DASHBOARD' => 'لوحة التحكم',
  'WORKING' => 'في العمل',
  'COMPANY' => 'شركة',
  'THE COMPANY' => 'الشركة',
  'COMPANIES' => 'شركات',
  'THE COMPANIES' => 'الشركات',
  '#COMPANIES' => 'عدد الشركات',
  '#REGISTERED COMPANIES' => 'عدد الشركات المُسجلة',
  'ACTIVE' => 'نشط',

  // large words

  // messages
  'STATUS REQUIRED' => 'حالة النظام مطلوبة! يجب ادخالها',
  'SYSTEM ACTIVATED' => 'تم تفعيل حالة النظام (الحالة نشط)',
  'SYSTEM DEACTIVATED' => 'تم تفعيل حالة النظام (تحت التطوير)',

  // buttons words

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}