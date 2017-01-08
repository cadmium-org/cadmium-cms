<?php

/**
 * @package Cadmium
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

# Check PHP version

if (version_compare(PHP_VERSION, '7.0.0') < 0) exit('PHP version 7 or higher is required.');

# Set error reporting

error_reporting(0);

# Define constants

define('DIR_ENGINE',        (dirname(__FILE__) . '/'));

define('DIR_WWW',           (DIR_ENGINE . '../'));
define('DIR_UPLOADS',       (DIR_ENGINE . '../uploads/'));

# Require framework main file

require_once(DIR_ENGINE . 'Framework/Main.php');

# Require system main file

require_once(DIR_ENGINE . 'System/Main.php');

# Register classes autoloader

spl_autoload_register(function ($class_name) {

	$path = explode('\\', $class_name); $last = $path[count($path) - 1];

	# Get class path

	$system_classes = ['Addons', 'Frames', 'Modules', 'Schemas', 'Utils', 'Dispatcher', 'Installer'];

	$path = ((in_array($path[0], $system_classes, true) ? DIR_SYSTEM_CLASSES : DIR_CLASSES) . implode('/', $path));

	# Require class file

	if (@file_exists($file_name = ($path . '.php')) && @is_file($file_name)) require_once $file_name;

	else if (@file_exists($file_name = ($path . '/' . $last . '.php')) && @is_file($file_name)) require_once $file_name;

	# Check if class exists

	if (!class_exists($class_name) && !interface_exists($class_name) && !trait_exists($class_name)) {

		throw new Exception\ClassLoad($class_name);
	}

	# Call autoload method

	if (method_exists($class_name, '__autoload')) $class_name::__autoload();
});
