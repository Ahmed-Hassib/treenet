<?php

/**
 * function of words in arabic
 */
function comp_sugg($phrase)
{
  static $lang = array(
    // words
    'COMP' => 'شكوى',
    'COMPS' => 'شكاوى',
    'THE COMP' => 'الشكوى',
    'THE COMPS' => 'الشكاوى',
    'TYPE' => 'النوع',
    'TEXT' => 'النص',
    'SUGG' => 'إقتراح',
    'SUGGS' => 'إقتراحات',
    'THE SUGG' => 'الإقتراح',
    'THE SUGGS' => 'الإقتراحات',
    'COMP & SUGG' => 'شكوى وإقتراح',
    'THE COMP & SUGG' => 'الشكوى والإقتراح',
    'THE COMP OR SUGG' => 'الشكوى أو الإقتراح',
    'COMPS & SUGGS' => 'شكاوى وإقتراحات',
    'THE COMPS & SUGGS' => 'الشكاوى والإقتراحات',
    'ADDITIONAL INFO' => 'بيانات إضافية',
    'COMMENTS' => 'التعليقات',
    'ADMIN COMMENT' => 'تعليق المدير',
    'YOUR COMMENT' => 'تعليقك',
    'COMP STATUS' => 'حالة الشكوى',
    'SUGG STATUS' => 'حالة الإقتراح',
    'MEDIA' => 'الصورة/الفيديو',
    'UPLOAD MEDIA' => 'إرفاق صورة/فيديو',

    // messages
    'ID NULL' => 'يوجد فقد في البيانات المُرسلة',
    'TYPE NULL' => 'لابد من تحديد النوع',
    'TYPE NOT RIGHT' => 'النوع الذي تم اختياره غير صحيح برجاء اختيار النوع الصحيح',
    'STATUS NULL' => 'لابد من تحديد الحالة',
    'STATUS NOT RIGHT' => 'الحالة التى تم اختيارها غير صحيحة برجاء اختيار الحالة الصحيحة',
    'COMMENT NULL' => 'لابد من كتابة الشكوى او الإقتراح المُقدم',
    'REPLAY NULL' => 'التعليق فارغ، من فضلك اكتب التعليق المطلوب',
    'COMP INSERTED' => 'تم إضافة الشكوى بنجاح وسيتم الرد عليكم في اقرب وقت ممكن من قبل المسئولين وشكراً',
    'SUGG INSERTED' => 'تم إضافة الإقتراح بنجاح وسيتم الرد عليكم في اقرب وقت ممكن من قبل المسئولين وشكراً',
    'COMP UPDATED' => 'تم تعديل الشكوى بنجاح',
    'SUGG UPDATED' => 'تم تعديل الإقتراح بنجاح',
    'COMMENT INSERTED' => 'تم إضافة التعليق بنجاح',
    'STATUS UPDATED' => 'تم تعديل الحالة بنجاح',

    // buttons words
    'ADD' => 'إضافة جديد',
    'ADD NEW' => 'إضافة شكوى أو إقتراح جديد',
    'EDIT' => 'تعديل شكوى أو إقتراح',
    'ADD COMP' => 'إضافة شكوى جديدة',
    'ADD SUGG' => 'إضافة إقتراح جديدة',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
