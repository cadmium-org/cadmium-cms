<?php

namespace Modules\Extend\Utils {

	abstract class Extension {

		protected static $loader = null;

		# Check if name valid

		public static function valid(string $name) {

			return (preg_match(static::$regex_name, $name) ? true : false);
		}

		# Validate name

		public static function validate(string $name) {

			return (preg_match(static::$regex_name, $name) ? $name : false);
		}

		# Static overloader

		public static function __callStatic($name, $arguments) {

			if (null !== static::$loader) return static::$loader->$name(...$arguments);
		}
	}
}
