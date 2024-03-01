<?php

/**
 * function of words in arabic
 */
function sugg_comp($phrase)
{
  static $lang = array(
  // complaints
  'COMP' => 'شكوى',
  'COMPS' => 'شكاوى',
  'THE COMP' => 'الشكوى',
  'THE COMPS' => 'الشكاوى',

  // suggesstions
  'SUGG' => 'إقتراح',
  'SUGGS' => 'إقتراحات',
  'THE SUGG' => 'الإقتراح',
  'THE SUGGS' => 'الإقتراحات',

  // all
  'COMP & SUGG' => 'شكوى وإقتراح',
  'THE COMP & SUGG' => 'الشكوى والإقتراح',
  'COMPS & SUGGS' => 'شكاوى وإقتراحات',
  'THE COMPS & SUGGS' => 'الشكاوى والإقتراحات',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
