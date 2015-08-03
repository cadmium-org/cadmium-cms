<?php

# Check PHP version

if (version_compare(PHP_VERSION, '5.4.0') < 0) exit('PHP version 5.4.0 or higher is required.');

# Set error reporting

error_reporting(E_ALL);

# Define constants

define('DIR_ENGINE',                (dirname(__FILE__) . '/'));

define('DIR_UPLOADS',               (DIR_ENGINE . '../uploads/'));

define('DIR_FRAMEWORK',             (DIR_ENGINE . 'Framework/'));
define('DIR_SYSTEM',                (DIR_ENGINE . 'System/'));

define('DIR_CLASSES',               (DIR_FRAMEWORK . 'Classes/'));
define('DIR_DATA',                  (DIR_FRAMEWORK . 'Data/'));
define('DIR_INCLUDES',              (DIR_FRAMEWORK . 'Includes/'));
define('DIR_TEMPLATES',             (DIR_FRAMEWORK . 'Templates/'));

define('DIR_SYSTEM_CLASSES',        (DIR_SYSTEM . 'Classes/'));
define('DIR_SYSTEM_DATA',           (DIR_SYSTEM . 'Data/'));
define('DIR_SYSTEM_INCLUDES',       (DIR_SYSTEM . 'Includes/'));
define('DIR_SYSTEM_LANGUAGES',      (DIR_SYSTEM . 'Languages/'));
define('DIR_SYSTEM_PLUGINS',        (DIR_SYSTEM . 'Plugins/'));
define('DIR_SYSTEM_TEMPLATES',      (DIR_SYSTEM . 'Templates/'));

# Require classes

require_once (DIR_FRAMEWORK . 'Engine.php');
require_once (DIR_FRAMEWORK . 'Error.php');
require_once (DIR_FRAMEWORK . 'Warning.php');
require_once (DIR_FRAMEWORK . 'Functions.php');

require_once (DIR_SYSTEM . 'System.php');

# Define classes autoloader

function __autoload($class_name) {

	$path = explode("\\", $class_name);

	if (0 === strcmp($path[0], 'System')) { $dir_name = DIR_SYSTEM_CLASSES; $path = array_slice($path, 1); }

	else if (0 === strcmp($path[0], 'Plugins')) { $dir_name = DIR_SYSTEM_PLUGINS; $path = array_slice($path, 1); }

	else { $dir_name = DIR_CLASSES; if (count($path) === 1) $path[] = $path[0]; }

	for ($i = 0; $i < ($count = count($path)); $i++) {

		if (($i < ($count - 1)) && @file_exists($dir_name .= $path[$i]) && @is_dir($dir_name)) { $dir_name .= '/'; continue; }

		if (@file_exists($file_name = ($dir_name . $path[$i] . '.php')) && @is_file($file_name)) require_once $file_name;

		break;
	}

	if (!class_exists($class_name) && !interface_exists($class_name)) throw new Error\ClassLoad($class_name);

	if (method_exists($class_name, '__autoload')) $class_name::__autoload();
}
