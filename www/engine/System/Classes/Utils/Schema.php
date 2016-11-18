<?php

namespace Utils {

	abstract class Schema {

		private static $cache = [];

		# Get schema

		public static function get(string $name) {

			$class_name = ('Schemas\\' . $name);

			if (!isset(self::$cache[$class_name])) self::$cache[$class_name] = new $class_name;

			# ------------------------

			return self::$cache[$class_name];
		}
	}
}
