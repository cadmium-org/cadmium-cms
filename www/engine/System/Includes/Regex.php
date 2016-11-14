<?php

# Regular expressions

define('REGEX_MAP_ITEM_PATH',                       '/^[a-zA-Z0-9_\-\+\.\,\'\*\(\)\[\]:;!$%~]+$/');
define('REGEX_MAP_ITEM_HANDLER',                    '/^[A-Z][a-zA-Z0-9]*$/');

define('REGEX_ADDON_NAME',                          '/^[A-Z0-9][a-zA-Z0-9]*$/');
define('REGEX_LANGUAGE_NAME',                       '/^[a-z][a-z]-[A-Z][A-Z]$/');
define('REGEX_TEMPLATE_NAME',                       '/^[A-Z0-9][a-zA-Z0-9]*$/');

define('REGEX_USER_AUTH_CODE',                      '/^[a-zA-Z0-9]{40}$/');

define('REGEX_USER_NAME',                           '/^(?!_)(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');
define('REGEX_USER_PASSWORD',                       '/^.+$/');

define('REGEX_FILE_NAME',                           '/^[^\/?%*:|"<>\\\]+$/');
