<?php

/**
 * @package Cadmium\Framework
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

# Date formats

define('DATE_FORMAT_STANDART',                      'd.m.Y');
define('DATE_FORMAT_MYSQL',                         'Y-m-d');
define('DATE_FORMAT_DATETIME',                      'd.m.Y, H:i');
define('DATE_FORMAT_W3C',                           'Y-m-d\TH:i:sP');

# Form fields

define('FORM_FIELD_HIDDEN',                         'hidden');
define('FORM_FIELD_PASSWORD',                       'password');
define('FORM_FIELD_CAPTCHA',                        'captcha');
define('FORM_FIELD_TEXT',                           'text');
define('FORM_FIELD_TEXTAREA',                       'textarea');

# String pools

define('STR_POOL_DEFAULT',                          'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
define('STR_POOL_LATIN',                            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('STR_POOL_LATIN_LOWER',                      'abcdefghijklmnopqrstuvwxyz');
define('STR_POOL_LATIN_UPPER',                      'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
define('STR_POOL_NUMERIC',                          '0123456789');
