<?php

# Define constants

define('DIR_SYSTEM',                (dirname(__FILE__) . '/'));

define('DIR_SYSTEM_CLASSES',        (DIR_SYSTEM . 'Classes/'));
define('DIR_SYSTEM_DATA',           (DIR_SYSTEM . 'Data/'));
define('DIR_SYSTEM_INCLUDES',       (DIR_SYSTEM . 'Includes/'));
define('DIR_SYSTEM_LANGUAGES',      (DIR_SYSTEM . 'Languages/'));
define('DIR_SYSTEM_PLUGINS',        (DIR_SYSTEM . 'Plugins/'));
define('DIR_SYSTEM_TEMPLATES',      (DIR_SYSTEM . 'Templates/'));

# Require classes

require_once (DIR_SYSTEM . 'System.php');

# Require configuration

require_once (DIR_SYSTEM_INCLUDES . 'Config.php');
require_once (DIR_SYSTEM_INCLUDES . 'Constants.php');
require_once (DIR_SYSTEM_INCLUDES . 'Regex.php');
require_once (DIR_SYSTEM_INCLUDES . 'Tables.php');

# Process environment variables

define('HTTP_MOD_REWRITE', (getenv('HTTP_MOD_REWRITE') === 'on'));

define('INSTALL_PATH', rtrim(getenv('INSTALL_PATH'), '/'));
