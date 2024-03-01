<?php

/**
 * function of words in arabic
 */
function payment($phrase)
{
  static $lang = array(
    // words
    'PAYMENTS' => 'المدفوعات',
    'PRICING PLANS' => 'خطط الاسعار',
    'VODAFONE CASH' => 'vodafone cash',
    'TRANSACTIONS' => 'عمليات الدفع',
    'TRANSACTION DETAILS' => 'تفاصيل عملية الدفع',
    'TRANSACTION ID' => 'رقم العملية',
    'ORDER ID' => 'رقم الطلب',
    'PRICE' => 'السعر',
    'STATUS' => 'حالة العملية',
    'CURRENCY' => 'نوع العملة',
    'ERRORS OCCURED' => 'حدثت اخطاء',
    'TRANSACTION TYPE' => 'نوع العملية',
    'DATA SOURCE' => 'المصدر',
    'RESPONSE CODE' => 'رمز الاستجابة',
    'TRANSACTION DESCRIPTION' => 'وصف العملية',
    'CREATED AT' => 'تاريخ الإنشاء',
    'UPDATED AT' => 'تاريخ التعديل',
    'LICENSE INFO' => 'بيانات الاشتراك',

    
    // large words
    'PLAN DOSN`T SUIT YOU' => 'هذه الخطه لا تتناسب معك',


    // messages
    'INSERTED' => 'تم إضافة بيانات  بنجاح',
    'UPDATED' => 'تم تعديل بيانات  بنجاح',
    'DELETED' => 'تم حذف بيانات  بنجاح',

    // buttons words
    'ADD NEW' => 'إضافة طريقة الدفع',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
