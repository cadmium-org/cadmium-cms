<?php

# Regular expressions

define('REGEX_FORM_NAME',                           '/^[a-zA-Z][a-zA-Z0-9]*$/');
define('REGEX_FORM_FIELD_KEY',                      '/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

define('REGEX_LANGUAGE_FILE_NAME',                  '/^[A-Z0-9][a-zA-Z0-9]*$/');
define('REGEX_LANGUAGE_PHRASE_NAME',                '/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

define('REGEX_TEMPLATE_FILE_NAME',                  '/^[A-Z0-9][a-zA-Z0-9]*$/');
define('REGEX_TEMPLATE_ITEM_NAME',                  '/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

define('REGEX_TEMPLATE_LANGUAGE',                   '/^[a-z][a-z](-[a-z][a-z])?$/');

define('REGEX_TEMPLATE_BLOCK',                     '/(?s){[ ]*(!)?[ ]*block[ ]*:[ ]*([a-zA-Z0-9_]+)[ ]*(\/[ ]*}|}(.*?){[ ]*\/[ ]*block[ ]*:[ ]*\2[ ]*})/');
define('REGEX_TEMPLATE_LOOP',                      '/(?s){[ ]*for[ ]*:[ ]*([a-zA-Z0-9_]+)[ ]*}(.*?){[ ]*\/[ ]*for[ ]*:[ ]*\1[ ]*}/');
define('REGEX_TEMPLATE_VARIABLE',                  '/\$([a-zA-Z0-9_]+)\$/');
define('REGEX_TEMPLATE_PHRASE',                    '/\%([a-zA-Z0-9_]+)\%/');
