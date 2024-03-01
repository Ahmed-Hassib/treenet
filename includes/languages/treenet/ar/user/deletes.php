<?php

/**
 * function of words in arabic
 */
function deletes($phrase)
{
  static $lang = array(
  // words
  'TRASH' => 'سلة المهملات',
  'DELETED CLIENTS' => 'العملاء المحذوفة',
  'RESTORE CLIENTS' => 'استرجاع العملاء',
  'DELETED PIECES' => 'الأجهزة المحذوفة',
  'RESTORE PIECES' => 'استرجاع الأجهزة',
  'DELETED EMPLOYEES' => 'الموظفين المحذوفين',
  'RESTORE EMPLOYEES' => 'استرجاع الموظفين',
  'DELETED COMBINATIONS' => 'التركيبات المحذوفة',
  'RESTORE COMBINATIONS' => 'استرجاع التركيبة',
  'DELETED MALFUNCTIONS' => 'الأعطال المحذوفة',
  'RESTORE MALFUNCTIONS' => 'استرجاع العطل',


  // large words


  // messages
  'EMPLOYEE RESTORED' => 'تم استرجاع بيانات الموظف بنجاح',
  'CLIENT RESTORED' => 'تم استرجاع بيانات العميل بنجاح',
  'PIECE RESTORED' => 'تم استرجاع بيانات الجهاز بنجاح',
  'COMBINATION RESTORED' => 'تم استرجاع بيانات التركيبة بنجاح',
  'MALFUNCTION RESTORED' => 'تم استرجاع بيانات العطل بنجاح',
  'UPDATED' => 'تم تعديل بيانات بنجاح',
  'DELETED' => 'تم حذف بيانات بنجاح',

  // buttons words
  'ADD NEW' => 'إضافة طريقة الدفع',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
