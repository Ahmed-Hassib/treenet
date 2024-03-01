<?php

/**
 * function of words in arabic
 */
function global_($phrase)
{
  static $lang = array(
    // global words
    'AR'                => 'arabic',
    'EN'                => 'english',
    'LANG'              => 'language',
    'LOGIN'             => 'log in',
    'LOGOUT'            => 'log out',
    'SIGNUP'            => 'sign up',
    'USERNAME'          => 'username',
    'PASSWORD'          => 'password',
    'COMPANY CODE'      => 'company code',
    'UNDER DEVELOPING'  => 'under developing',
    'SPONSOR'           => 'LEADER GROUP EGYPT',
    'SYS TREE'          => 'SYS TREE',
    'SYS TREE DESC'     => 'SYS TREE description',
    'TRIAL'             => 'trial',
    'REFRESH SESSION'   => 'update session',
    'NEW'               => 'new',
    'RATE APP'          => 'rate app',
    'POWERED BY'        => 'powered by',
    'PROFILE'           => 'profile',
    'JOINED'            => 'joined',
    'COMPANY IMG'       => 'company image',
    'READ MORE'         => 'raed more',
    'DETAILS'           => 'details',
    'UNKNOWN'           => 'unknown',
    'ADDED BY'          => 'added by',
    'ADDED DATE'        => 'added date',
    'ADDED TIME'        => 'added time',
    'SHOWED DATE'       => 'showed date',
    'SHOWED TIME'       => 'showed time',
    'FINISHED DATE'     => 'finished date',
    'FINISHED TIME'     => 'finished time',
    'DELAYED DATE'      => 'delayed date',
    'DELAYED TIME'      => 'delayed time',
    'REVIEWED DATE'     => 'reviewed date',
    'REVIEWED TIME'     => 'reviewed time',
    'FINISHED PERIOD'   => 'finished period',
    'BACK'              => 'back',
    'IP'                => 'IP Address',
    'MAC'               => 'MAC Address',
    'PORT'              => 'Port',
    'SECOND'            => 'second',
    'SECONDS'           => 'seconds',
    'MINUTE'            => 'minute',
    'MINUTES'           => 'minutes',
    'HOUR'              => 'hour',
    'HOURS'             => 'hours',
    'DAY'               => 'day',
    'DAYS'              => 'days',
    'MONTH'             => 'month',
    'MONTHS'            => 'months',
    'YEAR'              => 'year',
    'YEARS'             => 'years',
    'L.E'               => 'L.E',
    'BAD'               => 'bad',
    'GOOD'              => 'good',
    'VERY GOOD'         => 'very good',
    'RIGHT'             => 'right',
    'WRONG'             => 'wrong',

    // pages title
    'DASHBOARD'   => 'dashboard',

    // NAVBAR WORDS
    // website navbar
    'HOME'          => 'home',
    'OUR BLOG'      => 'our blog',
    'TOPICS'        => 'topics',
    'SERVICES'      => 'services',
    'THE SERVICES'  => 'the services',
    'OUR SERVICES'  => 'our services',
    'TEAM MEMBERS'  => 'team members',
    'TESTIMONIALS'  => 'testimonials',
    'OTHER'         => 'other',

    // sys tree navbar
    'EMPLOYEES'         => 'employees',
    'DIRECTIONS'        => 'directions',
    'PIECES'            => 'pieces',
    'CLIENTS'           => 'clients',
    'MALS'              => 'malfunctions',
    'COMBS'             => 'combinations',
    'CONNECTION TYPES'  => 'connections',
    'COMBINATIONS'      => 'combinations',
    'SETTINGS'          => 'settings',


    // large global words
    'DON`T HAVE ACCOUNT'  => 'don`t have account',
    '*REQUIRED'           => 'note: this sign * refere to the required fields',
    '*TECH REQUIRED'      => 'no technician has been added to add a new malfunction / combination',
    '' => '',
    'HARD & COMPLEX'      => 'the password must be difficult and complex',
    'CONFIRM DELETE'      => 'are you sure to delete',
    'PASS NOTE'           => 'don`t share password with anyone',
    'ENG NUM'             => 'numbers must be entered in English',
    'MEDIA FAILED'        => 'the photo/video failed to load',

    // global messages
    'NOT ASSIGNED'              => 'not assigned',
    'NAME EXIST'                => 'this name already exists',
    'REDIRECT AUTO'             => 'you will be redirected automatically after that',
    'ACCESS FAILED'             => 'this page cannot be accessed',
    'NO DATA'                   => 'there is no data to display',
    'QUERY PROBLEM'             => 'there was a problem saving the data',
    'LOGIN SUCCESS'             => 'successful login',
    'LOGIN FAILED'              => 'login Failed',
    'MISSING DATA'              => 'there is an error or loss of some data',
    'NO PAGE'                   => 'there is no page with this name',
    'LICENSE ENDED'             => 'your system has expired',
    'PERMISSION FAILED'         => 'there is no permission to access this page',
    'PERMISSION INSERT FAILED'  => 'you do not have permission to add',
    'PERMISSION UPDATE FAILED'  => 'you do not have permission to edit',
    'PERMISSION DELETE FAILED'  => 'you do not have permission to delete',
    'SESSION UPDATED'           => 'the session has been updated successfully',
    'SESSION FAILED'            => 'there was a problem updating the session',

    // tables words
    'NOTE'      => 'notes',
    'CONTROL'   => 'control',

    // buttons words
    'ADD'             => 'add',
    'EDIT'            => 'edit',
    'DELETE'          => 'delete',
    'SHOW'            => 'show',
    'RATING'          => 'rating',
    'SAVE'            => 'save',
    'CLOSE'           => 'close',
    'SEND'            => 'send',
    'DELETE IMG'      => 'delete image',
    'CHANGE IMG'      => 'change image',
    'DELETE MEDIA'    => 'delete img/vid',
    'DOWNLOAD MEDIA'  => 'download img/vid',
    'SELECT LANG'     => 'select language',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
