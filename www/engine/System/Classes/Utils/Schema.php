<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	abstract class Schema {

		private static $cache = [];

		/**
		 * Get a schema object
		 */

		public static function get(string $name) : Schema\_Object {

			$class_name = ('Schemas\\' . $name);

			if (!isset(self::$cache[$class_name])) self::$cache[$class_name] = new $class_name;

			# ------------------------

			return self::$cache[$class_name];
		}
	}
}
