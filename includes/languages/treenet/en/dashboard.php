<?php

/**
 * function of words in arabic
 */
function dashboard($phrase)
{
  static $lang = array(
    'LOGIN'             => 'log in',
    'SIGNUP'            => 'sign up',

    // large global words
    'DON`T HAVE ACCOUNT'  => 'don`t have an account',

    // global messages
    'LOGIN SUCCESS'     => 'successful login',
    'LOGIN FAILED'      => 'wrong login',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
