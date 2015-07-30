<?php

# Regular expressions

define('REGEX_MAP_PATH_ITEM_NAME',                  '/^[a-zA-Z0-9_\-\+\.\,\'\*\(\)\[\]:;!$%~]+$/');
define('REGEX_MAP_HANDLER_ITEM_NAME',               '/^[A-Z][a-zA-Z0-9]*$/');

define('REGEX_LANGUAGE_CODE',                       '/^[a-z][a-z]_[A-Z][A-Z]$/');
define('REGEX_TEMPLATE_NAME',                       '/^[A-Z0-9][a-zA-Z0-9]*$/');

define('REGEX_USER_AUTH_CODE',                      '/^[a-zA-Z0-9]{40}$/');

define('REGEX_USER_NAME',                           '/^(?!_)(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');
define('REGEX_USER_PASSWORD',                       '/^.+$/');
