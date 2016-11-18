<?php

# Form expressions

define('REGEX_FORM_NAME',                           '/^[a-zA-Z][a-zA-Z0-9]*$/');
define('REGEX_FORM_FIELD_KEY',                      '/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

# Language expressions

define('REGEX_LANGUAGE_PHRASE_NAME',                '/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

# Template expressions

define('REGEX_TEMPLATE_COMPONENT_NAME',             '/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

define('REGEX_TEMPLATE_STRUCTURE',                  '/(?s){[ ]*(!)?[ ]*(block|for|widget)[ ]*:[ ]*([a-zA-Z0-9_]+)[ ]*' .
                                                    '(?:\/[ ]*}|}(.*?){[ ]*\/[ ]*\2[ ]*:[ ]*\3[ ]*})/');

define('REGEX_TEMPLATE_VARIABLE',                   '/\$([a-zA-Z0-9_]+)\$/');
define('REGEX_TEMPLATE_PHRASE',                     '/\%([a-zA-Z0-9_]+)\%/');
