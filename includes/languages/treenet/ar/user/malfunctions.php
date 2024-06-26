<?php

/**
 * function of words in arabic
 */
function malfunctions($phrase)
{
  static $lang = array(
    // words
    'DASHBOARD' => 'لوحة التحكم',
    'MAL' => 'عطل',
    'MALS' => 'أعطال',
    'THE MAL' => 'العطل',
    'THE MALS' => 'الأعطال',
    'TOTAL' => 'إجمالي',
    'FINISHED' => 'إنتهي',
    'UNFINISHED' => 'لم ينتهي',
    'DELAYED' => 'مؤجل',
    'TOTAL MAL' => 'إجمالى الأعطال',
    'TOTAL MAL OF THE YEAR' => 'إجمالى الأعطال لسنة',
    'MALS RATING' => 'تقييم الأعطال',
    'MALS RATING OF THE YEAR' => 'تقييم الأعطال لسنة',
    'SOME MALS TODAY' => 'بعض أعطال اليوم',
    'LATEST MALS' => 'آخر الأعطال المُضافة',
    'NAME' => 'إسم المتضرر',
    'ADDR' => 'العنوان',
    'PHONE' => 'التليفون',
    'TECH NAME' => 'إسم الفنى',
    'SELECT TECH NAME' => 'إختر إسم الفنى',
    'ADMIN NAME' => 'إسم المسئول',
    'STATUS' => 'حالة العطل',
    'SELECT STATUS' => 'إختر حالة العطل',
    'MEDIA' => 'الصور/الفيديوهات',
    'NO MEDIA' => 'لا توجد صور/فيديوهات',
    'HAVE MEDIA' => 'تم ارفاق صور/فيديوهات',
    'RESP MAL' => 'المسئول عن العطل',
    'MAL DESC' => 'وصف العطل',
    'VICTIM INFO' => 'بيانات المتضرر',
    'MAL REVIEW' => 'تقييم العطل',
    'DATE & TIME INFO' => 'معلومات الوقت والتاريخ',
    'SELECT QTY' => 'إختر الجودة',
    'TECH QTY' => 'جودة الفنى',
    'MAL INFO' => 'بيانات العطل',
    'MAL COST' => 'تكلفة العطل',
    'TECH COMMENT' => 'تعليق الفنى',
    'SERVICE QTY' => 'جودة الخدمة',
    'COST REVIEW' => 'مراجعة التكلفة',
    'WAS DELETED' => 'تم حذفه',
    'COST RECEIPT' => 'إيصال التكلفة',
    'UPLOAD COST RECEIPT' => 'إرفاق إيصال التكلفة',
    'MAL UPDATES' => 'التعديلات الخاصة بالعطل',
    'UPDATED BY' => 'تم التعديل بواسطة',
    'UPDATED AT' => 'وقت التعديل',
    'UPDATES' => 'التعديلات',
    'ASSIGNED' => 'قام',
    'MALS DETAILS' => 'تفاصيل الاعطال',


    // large words
    'CONFIRM DELETE' => 'هل أنت متأكد من حذف العطل',
    'TODAY NOTE' => 'إحصائيات عن أعطال اليوم',
    'MONTH NOTE' => 'إحصائيات عن أعطال الشهر',
    'PREV MONTH NOTE' => 'إحصائيات عن أعطال الشهر السابق',
    'TOTAL MAL NOTE' => 'إحصائيات عن إجمالى الأعطال ',
    'MALS RATING NOTE' => 'يعتمد تقييم الأعطال على المقارنة بين الأعطال المنتهية وغير المنتهية والمتأخرة وجميع الأعطال',
    'SOME MALS NOTE' => 'يتم عرض بعض الأعطال المضافة اليوم',
    'LATEST MALS NOTE' => 'يتم عرض آخر 10 أعطال مضافة حديثاً',
    'TOTAL MALS FINISHED' => 'إجمالى أعطال إنتهت',
    'TOTAL MALS UNFINISHED' => 'إجمالى أعطال لم تنتهي',
    'TOTAL MALS DELAYED' => 'إجمالى أعطال مِجلة',
    'MALS OF THE YEAR' => 'إجمالى الأعطال لسنة',
    'MALS FINISHED OF THE YEAR' => 'أعطال إنتهت لسنة',
    'MALS UNFINISHED OF THE YEAR' => 'أعطال لم تنتهي لسنة',
    'MALS DELAYED OF THE YEAR' => 'أعطال مؤجلة لسنة',
    'MALS TODAY' => 'أعطال اليوم',
    'MALS FINISHED TODAY' => 'أعطال إنتهت اليوم',
    'MALS UNFINISHED TODAY' => 'أعطال لم تنتهي اليوم',
    'MALS DELAYED TODAY' => 'أعطال مؤجلة اليوم',
    'MALS MONTH' => 'أعطال الشهر',
    'MALS FINISHED MONTH' => 'أعطال إنتهت هذا الشهر',
    'MALS UNFINISHED MONTH' => 'أعطال لم تنتهي هذا الشهر',
    'MALS DELAYED MONTH' => 'أعطال مؤجلة هذا الشهر',
    'MALS PREV MONTH' => 'أعطال الشهر السابق',
    'MALS FINISHED PREV MONTH' => 'أعطال إنتهت الشهر السابق',
    'MALS UNFINISHED PREV MONTH' => 'أعطال لم تنتهي الشهر السابق',
    'MALS DELAYED PREV MONTH' => 'أعطال مؤجلة الشهر السابق',
    'MALS FAILED' => 'بعض الأعطال لا يُمكنك الإطلاع عليها',
    'NOT SHOWED' => 'لم يراها الفنى',
    'REVIEW ERROR' => 'لا يمكن تقييم العطل إلا بعد الإنتهاء منه',
    'INSERT MALFUNCTION' => 'إضافة العطل',
    'UPDATE MALFUNCTION' => 'تحديث بيانات العطل',
    'RESET MALFUNCTION' => 'إعادة تعيين بيانات العطل',
    'ADD RECEIPT' => 'إضافة إيصال التكلفة',
    'SEND NOTIFICATION' => 'تم إرسال اشعار الي الفني بتفاصيل العطل',
    'SEND LOCATION NOTIFICATION' => 'تم إرسال اشعار الي الفني بتفاصيل العنوان',


    // messages
    '*TECH REQUIRED' => 'لا يمكنك إضافة أى عطل لأنك لم تقُم بإضافة أى فنى',
    '*CLTS & PCS' => 'لا يمكنك إضافة أى عطل لأنك لم تقُم بإضافة أى جهاز أو عميل',
    'INSERTED' => 'تم إضافة العطل بنجاح',
    'UPDATED' => 'تم تعديل العطل بنجاح',
    'TEMP DELETED' => 'تم حذف العطل مؤقتاً بنجاح',
    'DELETED' => 'تم حذف العطل نهائياً بنجاح',
    'MEDIA DELETED' => 'تم حذف الصورة/الفيديو بنجاح',
    'MEDIA UPDATED' => 'تم تعديل الصورة/الفيديو بنجاح',
    'ASSIGN MALFUNCTION TO YOU' => 'بتكليفك بعطل جديد لتصليحه وبيانات العميل كالتالى',
    'ADMIN NULL' => 'خطأ في الرقم التعريفي للمسئول عن العطل',
    'TECH NULL' => 'خطأ في الرقم التعريفي للفني المسئول عن تصليح العطل',
    'CLT NULL' => 'خطأ في اختيار العميل المتضرر برجاء البحث بالاسم ثم الضغط علي الاسم للاختيار الصحيح',
    'DESC NULL' => 'برجاء كتابة الوصف الصحيح للضر الواقع علي العميل',

    // buttons words
    'ADD NEW' => 'إضافة عطل جديد',
    'ADD MEDIA' => 'إضافة صورة/فيديو',
    'EDIT' => 'تعديل بيانات عطل',
    'DELETE MAL' => 'حذف عطل',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
