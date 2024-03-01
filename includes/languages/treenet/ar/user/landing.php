<?php

function landing($phrase)
{
  static $lang = array(
    'HOME' => 'الصفحة الرئيسية',
    'HOME DESC' => 'افضل سيستم متكامل لإدارة الشبكات',

    'USERS AND COMPANIES USES SYSTEM' => 'عميل وشركة يستخدمون',
    'AGENTS RECOMMEND SYSTEM' => 'وكيل معتمد يوصي بإستخدام',
    'TREENET PRODUCTION READY' => 'سيستم إداري متكامل سهل وسريع الإستخدام',
    'BECOME AGENT' => 'يمكنك أن تصبح وكيلنا المعتد بكل سهولة',
    'KNOW AGENTS' => 'تعرف علي وكلائنا المعتمدون',
  );

  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
