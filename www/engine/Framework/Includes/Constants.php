<?php

# Cache limiters

define('CACHE_LIMITER_PRIVATE',                     'private');
define('CACHE_LIMITER_PUBLIC',                      'public');

# Date formats

define('DATE_FORMAT_STANDART',                      'd.m.Y');
define('DATE_FORMAT_MYSQL',                         'Y-m-d');
define('DATE_FORMAT_DATETIME',                      'd.m.Y, H:i');
define('DATE_FORMAT_W3C',                           'Y-m-d\TH:i:sP');

# Form field options

define('FORM_FIELD_ERROR',                          1);
define('FORM_FIELD_REQUIRED',                       2);
define('FORM_FIELD_READONLY',                       4);
define('FORM_FIELD_DISABLED',                       8);
define('FORM_FIELD_SEARCH',                         16);
define('FORM_FIELD_TRANSLIT',                       32);
define('FORM_FIELD_AUTO',                           64);

# String pools

define('STRING_POOL_DEFAULT',                       'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
define('STRING_POOL_LATIN',                         'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('STRING_POOL_LATIN_LOWER',                   'abcdefghijklmnopqrstuvwxyz');
define('STRING_POOL_LATIN_UPPER',                   'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('STRING_POOL_NUMERIC',                       '0123456789');
