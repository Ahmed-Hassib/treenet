<?php

/**
 * function of words in arabic
 */
function companies_root($phrase, $param = null)
{
  static $lang = array(
    // words
    'COMPANY' => 'شركة',
    'THE COMPANY' => 'الشركة',
    'COMPANIES' => 'شركات',
    'THE COMPANIES' => 'الشركات',
    'ACTIVE' => 'يعمل',
    'ACTIVATE' => 'تفعيل',
    'DEACTIVATE' => 'إلغاء التفعيل',
    'LIST' => 'قائمة الشركات',
    'EDIT COMPANY' => 'تعديل بيانات شركة',
    'COMPANY DETAILS' => 'عرض بيانات شركة',
    'SELECT LICENSE TYPE' => 'إختر نوع الاشتراك',
    'LICENSE TYPE' => 'نوع الاشتراك',
    'SELECT LICENSE STATUS' => 'إختر حالة الاشتراك',
    'LICENSE STATUS' => 'حالة الاشتراك',
    'LICENSE ACTIVE' => 'الاشتراك مُفعل',
    'LICENSE EXPIRED' => 'الاشتراك إنتهي',
    'LICENSE SUSPENDED' => 'الاشتراك مُعلق',
    'PLAN TYPE' => 'نوع الخطة',
    'SELECT PLAN TYPE' => 'اختر الخطة',
    'COMPANY STATISTICS' => 'أرقام وإحصائيات الشركة',
    'COMPANY LICENSES' => 'اشتراكات الشركة',

    // large words
    'LICENSE DATE EXPIRED' => 'تم إنتهاء مدة الاشتراك، تم تعديل حالة الشتراك الي الوضع (اشتراك منتهي) بنجاح',

    // buttons words
    'UPDATED' => 'تم تعديل بيانات الاشتراك بنجاح',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
