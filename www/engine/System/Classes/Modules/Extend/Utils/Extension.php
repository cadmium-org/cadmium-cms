<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils {

	abstract class Extension {

		protected static $loader = null;

		/**
		 * Check if an item name is valid
		 */

		public static function isValid(string $name) : bool {

			return (preg_match(static::$regex_name, $name) ? true : false);
		}

		/**
 		 * Validate an item name
 		 *
 		 * @return string|false : the name or false on failure
 		 */

		public static function validate(string $name) {

			return (preg_match(static::$regex_name, $name) ? $name : false);
		}

		/**
		 * Check if the extension is inited
		 */

		public static function isInited() {

			return (null !== static::$loader);
		}

		/**
		 * Static overloader
		 */

		public static function __callStatic($name, $arguments) {

			if (null !== static::$loader) return static::$loader->$name(...$arguments);

			throw new \BadMethodCallException('Call to undefined method ' . get_called_class() . '::' . $name . '()');
		}
	}
}
