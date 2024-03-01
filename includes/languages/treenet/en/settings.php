<?php

/**
 * function of words in arabic
 */
function settings($phrase)
{
  static $lang = array(
    // words
    'COMPANY BRAND'   => 'company brand',
    'CHANGE IMG'      => 'change image',
    'OTHER'           => 'other',
    'PING COUNTER'    => 'ping messages counter',
    'SYSTEM INFO'     => 'system info',
    'FOREVER'         => 'forever',
    'MONTHLY'         => 'monthly',
    '3 MONTH'         => '3 months',
    '6 MONTH'         => '6 months',
    'YEARLY'          => 'yearly',
    'TRIAL'           => 'trial',
    'COMPANY NAME'    => 'company name',
    'COMPANY CODE'    => 'company code',
    'APP VERSION'     => 'app version',
    'LICENSE'         => 'license type',
    'EXPIRY'          => 'expiry',
    'SYSTEM LANG'     => 'language',
    'MIKROTIK INFO'   => 'mikrotik info',

    // large words
    'DEFAULT IMG' => 'this is default image for system',
    
    // messages
    'IMG UPDATED'       => 'the company image has been successfully changed',
    'SETTINGS UPDATED'  => 'settings updated successfully',
    'IP EMPTY'          => 'the IP address is empty',
    'PORT EMPTY'        => 'port is empty',
    'USERNAME EMPTY'    => 'username is empty',
    'PASSWORD EMPTY'    => 'password is empty',
    'MIKROTIK UPDATED'  => 'mikrotik data has been updated successfully',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
