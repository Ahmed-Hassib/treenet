<?php

/**
 * function of words in arabic
 */
function errors($phrase)
{
  static $lang = array(
    // words
    'PAGE NOT FOUND' => 'صفحة غير موجودة',
    'ACCESS DENIED' => 'تم رفض الوصول',

    '403 WARNING' => 'نأسف! ليس لديك الإذن للوصول إلى العنوان السابق',
    '404 WARNING' => 'أُووبس! الصفحة التي تريدها لم يتم العثور عليها، يمكنك تجربة صفحة أخرى أو العودة إلى الصفحة الرئيسية',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
