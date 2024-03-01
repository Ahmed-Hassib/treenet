<?php

/**
 * function of words in arabic
 */
function combinations($phrase)
{
  static $lang = array(
    // words
    'COMB'              => 'تركيبه',
    'COMBS'             => 'تركيبات',
    'THE COMB'          => 'التركيبة',
    'THE COMBS'         => 'التركيبات',
    'TOTAL'             => 'إجمالي',
    'FINISHED'          => 'إنتهي',
    'UNFINISHED'        => 'لم ينتهي',
    'DELAYED'           => 'مؤجل',
    'TOTAL COMBS'       => 'إجمالى التركيبات',
    'COMBS RATING'      => 'تقييم التركيبات',
    'SOME COMBS TODAY'  => 'بعض تركيبات اليوم',
    'LATEST COMBS'      => 'آخر التركيبات المُضافة',
    'NAME'              => 'إسم المستفيد',
    'ADDR'              => 'العنوان',
    'PHONE'             => 'التليفون',
    'TECH NAME'         => 'إسم الفنى',
    'SELECT TECH NAME'  => 'إختر إسم الفنى',
    'ADMIN NAME'        => 'إسم المسئول',
    'STATUS'            => 'حالة التركيبة',
    'SELECT STATUS'     => 'إختر حالة التركيبة',
    'MEDIA'             => 'الصور/الفيديوهات',
    'NO MEDIA'          => 'لا توجد صور/فيديوهات',
    'HAVE MEDIA'        => 'تم الإرفاق',
    'RESP COMB'         => 'المسئول عن التركيبة',
    'COMB DESC'         => 'وصف التركيبة',
    'DELETE COMB'       => 'حذف تركيبه',
    'BENEFICIARY INFO'  => 'بيانات المستفيد',
    'BENEFICIARY NAME'  => 'إسم المستفيد',
    'COMB REVIEW'       => 'تقييم التركيبة',
    'DATE & TIME INFO'  => 'معلومات الوقت والتاريخ',
    'SELECT QTY'        => 'إختر الجودة',
    'TECH QTY'          => 'جودة الفنى',
    'COMB INFO'         => 'بيانات التركيبة',
    'COMB COST'         => 'تكلفة التركيبة',
    'TECH COMMENT'      => 'تعليق الفنى',
    'SERVICE QTY'       => 'جودة الخدمة',
    'COST REVIEW'       => 'مراجعة التكلفة',
    'WAS DELETED'       => 'تم حذفه',

    // large words
    'CONFIRM DELETE'              => 'هل أنت متأكد من حذف التركيبة',
    'TODAY NOTE'                  => 'إحصائيات عن تركيبات اليوم',
    'MONTH NOTE'                  => 'إحصائيات عن تركيبات الشهر',
    'PREV MONTH NOTE'             => 'إحصائيات عن تركيبات الشهر السابق',
    'TOTAL COMBS NOTE'            => 'إحصائيات عن إجمالى التركيبات ',
    'COMBS RATING NOTE'           => 'يعتمد تقييم التركيبات على المقارنة بين التركيبات المنتهية وغير المنتهية والمتأخرة وجميع التركيبات',
    'SOME COMBS NOTE'             => 'يتم عرض بعض التركيبات المضافة اليوم',
    'LATEST COMBS NOTE'           => 'يتم عرض آخر 10 تركيبات مضافة حديثاً',
    'COMBS FINISHED'              => 'تركيبات إنتهت',
    'COMBS UNFINISHED'            => 'تركيبات لم تنتهي',
    'COMBS DELAYED'               => 'تركيبات مؤجلة',
    'COMBS TODAY'                 => 'تركيبات اليوم',
    'COMBS FINISHED TODAY'        => 'تركيبات إنتهت اليوم',
    'COMBS UNFINISHED TODAY'      => 'تركيبات لم تنتهي اليوم',
    'COMBS DELAYED TODAY'         => 'تركيبات مؤجلة اليوم',
    'COMBS MONTH'                 => 'تركيبات الشهر',
    'COMBS FINISHED MONTH'        => 'تركيبات إنتهت هذا الشهر',
    'COMBS UNFINISHED MONTH'      => 'تركيبات لم تنتهي هذا الشهر',
    'COMBS DELAYED MONTH'         => 'تركيبات مؤجلة هذا الشهر',
    'COMBS PREV MONTH'            => 'تركيبات الشهر السابق',
    'COMBS FINISHED PREV MONTH'   => 'تركيبات إنتهت الشهر السابق',
    'COMBS UNFINISHED PREV MONTH' => 'تركيبات لم تنتهي الشهر السابق',
    'COMBS DELAYED PREV MONTH'    => 'تركيبات مؤجلة الشهر السابق',
    'NOT SHOWED'                  => 'لم يراها الفنى',
    'REVIEW ERROR'                => 'لا يمكن تقييم التركيبة إلا بعد الإنتهاء منها',


    // messages
    '*TECH REQUIRED'  => 'لا يمكنك إضافة أى تركيبه لأنك لم تقُم بإضافة أى فنى',
    '*CLTS & PCS'     => 'لا يمكنك إضافة أى تركيبه لأنك لم تقُم بإضافة أى جهاز أو عميل',
    'INSERTED'        => 'تم إضافة التركيبة بنجاح',
    'UPDATED'         => 'تم تعديل التركيبة بنجاح',
    'DELETED'         => 'تم حذف التركيبة بنجاح',
    'MEDIA DELETED'   => 'تم حذف الصورة/الفيديو بنجاح',
    'MEDIA UPDATED'   => 'تم تعديل الصورة/الفيديو بنجاح',
    '' => '',

    // buttons words
    'ADD NEW'   => 'إضافة تركيبه جديد',
    'ADD MEDIA' => 'إضافة صورة/فيديو',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
