<?php

# Check PHP version

if (version_compare(PHP_VERSION, '5.4.0') < 0) exit('PHP version 5.4.0 or higher is required.');

# Set error reporting

error_reporting(E_ALL);

# Define constants

define('DIR_ENGINE',        (dirname(__FILE__) . '/'));

define('DIR_WWW',           (DIR_ENGINE . '../'));
define('DIR_UPLOADS',       (DIR_ENGINE . '../uploads/'));

# Require framework main file

require_once(DIR_ENGINE . 'Framework/Main.php');

# Require system main file

require_once(DIR_ENGINE . 'System/Main.php');

# Register classes autoloader

spl_autoload_register(function($class_name) {

	$path = explode('\\', $class_name); $last = $path[count($path) - 1];

	# Determine class path

	if ($path[0] === 'System') $path = (DIR_SYSTEM_CLASSES . implode('/', array_slice($path, 1)));

	else if ($path[0] === 'Plugins') $path = (DIR_SYSTEM_PLUGINS . implode('/', array_slice($path, 1)));

	else $path = (DIR_CLASSES . implode('/', $path));

	# Require class file

	if (@file_exists($file_name = ($path . '.php')) && @is_file($file_name)) require_once $file_name;

	else if (@file_exists($file_name = ($path . '/' . $last . '.php')) && @is_file($file_name)) require_once $file_name;

	# Check if class exists

	if (!class_exists($class_name) && !interface_exists($class_name) && !trait_exists($class_name)) throw new Exception\ClassLoad($class_name);

	# Call autoload method

	if (method_exists($class_name, '__autoload')) $class_name::__autoload();
});
