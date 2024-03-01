<?php

/**
 * function of words in arabic
 */
function directions($phrase)
{
  static $lang = array(
    // words
    'LIST'                => 'directions list',
    'DIR NAME'            => 'direction name',
    'DIRECTION'           => 'direction',
    'SELECT DIRECTION'    => 'select direction',
    'SHOW DIR PCS'        => 'show direction devices',
    'SHOW DIR UNK'        => 'show unknown in direction',
    
    // large words
    'CANNOT DELETE' => 'this direction cannot be deleted because there is more than one device or client on it',

    // messages
    'DIRECTION ERROR' => 'direction name cannot be empty',
    'NAME EXIST'      => 'direction name already exists',
    'INSERTED'        => 'new direction was added successfully',
    'UPDATED'         => 'direction was updated successfully',
    'DELETED'         => 'direction was deleted successfully',
    
    // buttons words
    'ADD NEW'     => 'add new direction',
    'EDIT DIR'    => 'edit direction',
    'DELETE DIR'  => 'delete direction',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
