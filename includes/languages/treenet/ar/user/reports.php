<?php

/**
 * function of words in arabic
 */
function reports($phrase)
{
  static $lang = array(
  // words
  'CLEAR' => 'clear',
  'REPORTS' => 'تقارير',
  'THE REPORTS' => 'التقارير',
  'SECTION' => 'قسم',
  'SECTIONS' => 'أقسام',
  'THE SECTION' => 'القسم',
  'THE SECTIONS' => 'الأقسام',
  'REPORT OF' => 'تقرير عن',
  'EMPLOYEE' => 'موظف',
  'EMPLOYEES' => 'موظفين',
  'DIRECTION' => 'إتجاه',
  'DIRECTIONS' => 'إتجاهات',
  'DEVICE' => 'جهاز',
  'DEVICES' => 'أجهزة',
  'CLIENT' => 'عميل',
  'CLIENTS' => 'عملاء',
  'YOU HAVE' => 'يعمل لديك',
  'DIVIDED INTO' => 'مقسمين إلى',
  'YOUR NETWORK CONTAINS' => 'تحتوى شبكتك علي',
  'THIS DIR CONTAINS' => 'يحتوى هذا الإتجاه علي',


  // statements
  'REPORTS NOTE' => 'يمكنك من خلال قسم التقارير ان ترى تقارير عن جميع اقسام السيستم من خلال بعض الارقام والبيانات التى تُعرض بناءً علي نشاط وتفاعل موظفى شركتك',

  // buttons
  'SELECT SECTION' => 'إختر القسم المطلوب',
  'GENERATE REPORT' => 'إنشاء التقرير',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
