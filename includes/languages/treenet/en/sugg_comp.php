<?php

/**
 * function of words in arabic
 */
function sugg_comp($phrase)
{
  static $lang = array(
    // complaints
    'COMP'        => 'complaint',
    'COMPS'       => 'complaints',
    'THE COMP'    => 'the complaint',
    'THE COMPS'   => 'the complaints',
    
    // suggesstions
    'SUGG'        => 'suggestion',
    'SUGGS'       => 'suggestions',
    'THE SUGG'    => 'the suggestion',
    'THE SUGGS'   => 'the suggestions',

    // all
    'COMP & SUGG'         => 'complaint & suggestion',
    'THE COMP & SUGG'     => 'the complaint & suggestion',
    'COMPS & SUGGS'       => 'complaints & suggestions',
    'THE COMPS & SUGGS'   => 'the complaints & suggestions',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
