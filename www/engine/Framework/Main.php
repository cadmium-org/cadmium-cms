<?php

# Define constants

define('DIR_FRAMEWORK',     (dirname(__FILE__) . '/'));

define('DIR_CLASSES',       (DIR_FRAMEWORK . 'Classes/'));
define('DIR_DATA',          (DIR_FRAMEWORK . 'Data/'));
define('DIR_INCLUDES',      (DIR_FRAMEWORK . 'Includes/'));
define('DIR_TEMPLATES',     (DIR_FRAMEWORK . 'Templates/'));

# Require classes
                    
require_once (DIR_FRAMEWORK . 'Engine.php');
require_once (DIR_FRAMEWORK . 'Error.php');
require_once (DIR_FRAMEWORK . 'Functions.php');

# Require configuration

require_once (DIR_INCLUDES . 'Config.php');
require_once (DIR_INCLUDES . 'Constants.php');
require_once (DIR_INCLUDES . 'Regex.php');
require_once (DIR_INCLUDES . 'Headers/Mime.php');
require_once (DIR_INCLUDES . 'Headers/Status.php');

# Set defaults

if (function_exists('mb_internal_encoding')) mb_internal_encoding(CONFIG_DEFAULT_CHARSET);

date_default_timezone_set(CONFIG_DEFAULT_TIMEZONE);

# Set request constants

define('REQUEST_CLIENT_IP', Engine::ip());

define('REQUEST_TIME', $_SERVER['REQUEST_TIME']);

define('REQUEST_TIME_FLOAT', $_SERVER['REQUEST_TIME_FLOAT']);
