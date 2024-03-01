<?php

/**
 * function of words in arabic
 */
function pcs_conn($phrase)
{
  static $lang = array(
    // words
    'CONN NAME'           => 'connection name',
    'CONN TYPE'           => 'connection type',
    'SELECT CONN TYPE'    => 'select connection type',
    'EDIT CONN'           => 'edit connection',
    'DELETE CONN'         => 'delete connection',
    'CONN STATISTICS'     => 'connections statistics',
    'OLD NAME'            => 'connection old name',
    'NEW NAME'            => 'connection new name',
    
    // large words
    'CONN NOTE' => 'some numbers and statistics on connection types are presented here',

    // messages
    'INSERTED'  => 'a new connection type has been added successfully',
    'UPDATED'   => 'connection type has been updated successfully',
    'DELETED'   => 'connection type has been deleted successfully',
    'CONN NULL' => 'new name cannot by empty',

    // buttons words
    'ADD NEW'     => 'add new connection',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
