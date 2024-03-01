<?php

/**
 * function of words in arabic
 */
function not_found($phrase)
{
  static $lang = array(
    // words
    'PAGE NOT FOUND' => 'صفحة غير موجودة',
    'ACCESS DENIED' => 'تم رفض الوصول',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
