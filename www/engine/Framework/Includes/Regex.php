<?php

# Regular expressions

define('REGEX_FORM_NAME',							'/^[a-zA-Z][a-zA-Z0-9]*$/');
define('REGEX_FORM_FIELD_NAME',						'/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

define('REGEX_LANGUAGE_FILE_NAME',					'/^[A-Z0-9][a-zA-Z0-9]*$/');
define('REGEX_LANGUAGE_PHRASE_NAME',				'/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

define('REGEX_TEMPLATE_FILE_NAME',					'/^[A-Z0-9][a-zA-Z0-9]*$/');
define('REGEX_TEMPLATE_ITEM_NAME',					'/^(?![0-9_])(?!.*_$)(?!.*_{2,})[a-zA-Z0-9_]+$/');

?>