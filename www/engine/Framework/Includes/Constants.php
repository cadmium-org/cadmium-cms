<?php

# Cache limiters

define('CACHE_LIMITER_PRIVATE',                     'private');
define('CACHE_LIMITER_PUBLIC',                      'public');

# Date formats

define('DATE_FORMAT_STANDART',                      'd.m.Y');
define('DATE_FORMAT_MYSQL',                         'Y-m-d');
define('DATE_FORMAT_DATETIME',                      'd.m.Y, H:i');
define('DATE_FORMAT_W3C',                           'Y-m-d\TH:i:sP');

# Form input types

define('FORM_INPUT_TEXT',                           'text');
define('FORM_INPUT_CAPTCHA',                        'captcha');
define('FORM_INPUT_PASSWORD',                       'password');
define('FORM_INPUT_HIDDEN',                         'hidden');
define('FORM_INPUT_TEXTAREA',                       'textarea');

# Form field options

define('FORM_FIELD_REQUIRED',                       1);
define('FORM_FIELD_DISABLED',                       2);
define('FORM_FIELD_READONLY',                       4);
define('FORM_FIELD_TRANSLIT',                       8);
define('FORM_FIELD_AUTOFOCUS',                      16);
define('FORM_FIELD_AUTOCOMPLETE',                   32);
define('FORM_FIELD_SEARCH',                         64);
define('FORM_FIELD_AUTO',                           128);

# Text pools

define('TEXT_POOl_DEFAULT',                         'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
define('TEXT_POOl_LATIN',                           'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('TEXT_POOl_LATIN_LOWER',                     'abcdefghijklmnopqrstuvwxyz');
define('TEXT_POOl_LATIN_UPPER',                     'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('TEXT_POOl_NUMERIC',                         '0123456789');
