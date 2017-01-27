<?php

/**
 * @package Cadmium\System
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

# Define directories

define('DIR_SYSTEM',                (dirname(__FILE__) . '/'));

define('DIR_SYSTEM_CLASSES',        (DIR_SYSTEM . 'Classes/'));
define('DIR_SYSTEM_DATA',           (DIR_SYSTEM . 'Data/'));
define('DIR_SYSTEM_INCLUDES',       (DIR_SYSTEM . 'Includes/'));
define('DIR_SYSTEM_LANGUAGES',      (DIR_SYSTEM . 'Languages/'));
define('DIR_SYSTEM_TEMPLATES',      (DIR_SYSTEM . 'Templates/'));

# Require classes

require_once (DIR_SYSTEM . 'Exception.php');

# Require configuration

require_once (DIR_SYSTEM_INCLUDES . 'Constants.php');
require_once (DIR_SYSTEM_INCLUDES . 'Config.php');
require_once (DIR_SYSTEM_INCLUDES . 'Regex.php');
require_once (DIR_SYSTEM_INCLUDES . 'Tables.php');

# Set environment constants

define('HTTP_MOD_REWRITE',      (getenv('HTTP_MOD_REWRITE') === 'on'));

define('INSTALL_PATH',          rtrim(getenv('INSTALL_PATH'), '/'));

define('DEBUG_MODE',            @file_exists(DIR_SYSTEM_DATA . '.debug'));

# Set error reporting

if (DEBUG_MODE) error_reporting(E_ALL);
