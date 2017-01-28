<?php

/**
 * @package Cadmium\System\Modules\Install
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules {

	use Explorer;

	abstract class Install {

		private static $requirements = [], $extensions = [], $dirs = [];

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			# Check rewrite module

			self::$requirements['rewrite'] = HTTP_MOD_REWRITE;

			# Check extensions

			$extensions = ['mysqli', 'mbstring', 'gd', 'simplexml', 'dom'];

			foreach ($extensions as $name) {

				self::$requirements[$name] = self::$extensions[$name] = extension_loaded($name);
			}

			# Check directories

			$dirs = ['data' => DIR_SYSTEM_DATA, 'uploads' => DIR_UPLOADS];

			foreach ($dirs as $name => $dir_name) {

				self::$requirements[$name] = self::$dirs[$name] = is_writable($dir_name);
			}
		}

		/**
		 * Get the requirements list
		 *
		 * @return array : the array of requirements and their statuses (true if met, otherwise false)
		 */

		public static function getRequirements() : array {

			return self::$requirements;
		}

		/**
		 * Get the extensions list
		 *
		 * @return array : the array of extensions and their statuses (true if loaded, otherwise false)
		 */

		public static function getExtensions() : array {

			return self::$extensions;
		}

		/**
		 * Get the directories list
		 *
		 * @return array : the array of directories and their statuses (true if writable, otherwise false)
		 */

		public static function getDirs() : array {

			return self::$dirs;
		}

		/**
		 * Check whether all the installation requirements are met
		 */

		public static function checkRequirements() : bool {

			return (!in_array(false, self::$requirements, true));
		}

		/**
		 * Check whether the installation file (/www/install.php) exists
		 */

		public static function checkFile() : bool {

			return Explorer::isFile(DIR_WWW . 'install.php');
		}
	}
}
