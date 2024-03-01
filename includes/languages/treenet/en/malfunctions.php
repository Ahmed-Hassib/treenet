<?php

/**
 * function of words in arabic
 */
function malfunctions($phrase)
{
  static $lang = array(
    // words
    'MAL'               => 'عطل',
    'MALS'              => 'أعطال',
    'THE MAL'           => 'العطل',
    'THE MALS'          => 'الأعطال',
    'TOTAL'             => 'إجمالي',
    'FINISHED'          => 'إنتهي',
    'UNFINISHED'        => 'لم ينتهي',
    'DELAYED'           => 'مؤجل',
    'TOTAL MAL'         => 'إجمالى الأعطال',
    'MALS RATING'       => 'تقييم الأعطال',
    'SOME MALS TODAY'   => 'بعض أعطال اليوم',
    'LATEST MALS'       => 'آخر الأعطال المُضافة',
    'NAME'              => 'إسم المتضرر',
    'ADDR'              => 'العنوان',
    'PHONE'             => 'التليفون',
    'TECH NAME'         => 'إسم الفنى',
    'SELECT TECH NAME'  => 'إختر إسم الفنى',
    'ADMIN NAME'        => 'إسم المسئول',
    'STATUS'            => 'حالة العطل',
    'SELECT STATUS'     => 'إختر حالة العطل',
    'MEDIA'             => 'الصور/الفيديوهات',
    'NO MEDIA'          => 'لا توجد صور/فيديوهات',
    'HAVE MEDIA'        => 'تم الإرفاق',
    'RESP MAL'          => 'المسئول عن العطل',
    'MAL DESC'          => 'وصف العطل',
    'DELETE MAL'        => 'حذف عطل',
    'VICTIM INFO'       => 'بيانات المتضرر',
    'MAL REVIEW'        => 'تقييم العطل',
    'DATE & TIME INFO'  => 'معلومات الوقت والتاريخ',
    'SELECT QTY'        => 'إختر الجودة',
    'TECH QTY'          => 'جودة الفنى',
    'MAL INFO'          => 'بيانات العطل',
    'MAL COST'          => 'تكلفة العطل',
    'TECH COMMENT'      => 'تعليق الفنى',
    'SERVICE QTY'       => 'جودة الخدمة',
    'COST REVIEW'       => 'مراجعة التكلفة',
    'WAS DELETED'       => 'تم حذفه',
    
    // large words
    'CONFIRM DELETE'              => 'هل أنت متأكد من حذف العطل',
    'TODAY NOTE'                  => 'إحصائيات عن أعطال اليوم',
    'MONTH NOTE'                  => 'إحصائيات عن أعطال الشهر',
    'PREV MONTH NOTE'             => 'إحصائيات عن أعطال الشهر السابق',
    'TOTAL MAL NOTE'              => 'إحصائيات عن إجمالى الأعطال ',
    'MALS RATING NOTE'            => 'يعتمد تقييم الأعطال على المقارنة بين الأعطال المنتهية وغير المنتهية والمتأخرة وجميع الأعطال',
    'SOME MALS NOTE'              => 'يتم عرض بعض الأعطال المضافة اليوم',
    'LATEST MALS NOTE'            => 'يتم عرض آخر 10 أعطال مضافة حديثاً',
    'MALS FINISHED'               => 'أعطال إنتهت',
    'MALS UNFINISHED'             => 'أعطال لم تنتهي',
    'MALS DELAYED'                => 'أعطال مؤجلة',
    'MALS TODAY'                  => 'أعطال اليوم',
    'MALS FINISHED TODAY'         => 'أعطال إنتهت اليوم',
    'MALS UNFINISHED TODAY'       => 'أعطال لم تنتهي اليوم',
    'MALS DELAYED TODAY'          => 'أعطال مؤجلة اليوم',
    'MALS MONTH'                  => 'أعطال الشهر',
    'MALS FINISHED MONTH'         => 'أعطال إنتهت هذا الشهر',
    'MALS UNFINISHED MONTH'       => 'أعطال لم تنتهي هذا الشهر',
    'MALS DELAYED MONTH'          => 'أعطال مؤجلة هذا الشهر',
    'MALS PREV MONTH'             => 'أعطال الشهر السابق',
    'MALS FINISHED PREV MONTH'    => 'أعطال إنتهت الشهر السابق',
    'MALS UNFINISHED PREV MONTH'  => 'أعطال لم تنتهي الشهر السابق',
    'MALS DELAYED PREV MONTH'     => 'أعطال مؤجلة الشهر السابق',
    'NOT SHOWED'                  => 'لم يراها الفنى',
    'REVIEW ERROR'                => 'لا يمكن تقييم العطل إلا بعد الإنتهاء منه',
    '' => '',


    // messages
    '*TECH REQUIRED'  => 'لا يمكنك إضافة أى عطل لأنك لم تقُم بإضافة أى فنى',
    '*CLTS & PCS'     => 'لا يمكنك إضافة أى عطل لأنك لم تقُم بإضافة أى جهاز أو عميل',
    'INSERTED'        => 'تم إضافة العطل بنجاح',
    'UPDATED'         => 'تم تعديل العطل بنجاح',
    'DELETED'         => 'تم حذف العطل بنجاح',
    'MEDIA DELETED'   => 'تم حذف الصورة/الفيديو بنجاح',
    'MEDIA UPDATED'   => 'تم تعديل الصورة/الفيديو بنجاح',
    '' => '',
    '' => '',

    // buttons words
    'ADD NEW'   => 'إضافة عطل جديد',
    'ADD MEDIA' => 'إضافة صورة/فيديو',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
