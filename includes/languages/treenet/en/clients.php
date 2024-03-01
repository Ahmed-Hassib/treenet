<?php

/**
 * function of words in arabic
 */
function clients($phrase)
{
  static $lang = array(
    // words
    'CLT'             => 'client',
    'LIST'            => 'clients list',
    'CLT INFO'        => 'client info',
    'CLT NAME'        => 'client name',
    'ADDR'            => 'client address',
    'PHONE'           => 'client phone',
    'CLT STATISTICS'  => 'clients statistics',
    'LATEST'          => 'latest added clients',
    'DELETE CLT'      => 'delete client',
    'PCS CLT INFO'    => 'client`s device info',
    'ALL CLTS'        => 'all clients',
    'CLT MALS'        => 'client`s malfunctions',
    'DIR CLTS'        => 'clients of direction',

    // large words
    'CLT NOTE'    => 'some client numbers and statistics are presented here',
    'LATEST NOTE' => 'the last 10 clients added are displayed here',


    // messages
    'INSERTED'    => 'client data has been added successfully',
    'UPDATED'     => 'client data has been updated successfully',
    'DELETED'     => 'client data has been deleted successfully',
    'NAME EXIST'  => 'client name already exists',
    'IP EXIST'    => 'IP Address already exists',
    'MAC EXIST'   => 'MAC Address already exists',

    // buttons words
    'ADD NEW' => 'add new client',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
