<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils {

	use Exception;

	abstract class Factory {

		protected static $error_message = '', $cache = [], $classes = [];

		/**
		 * Get a class instance
		 */

		public static function get(string $table) {

			if (!isset(static::$classes[$table])) throw new Exception\General(static::$error_message);

			if (!isset(static::$cache[$table])) static::$cache[$table] = new static::$classes[$table];

			# ------------------------

			return static::$cache[$table];
		}
	}
}
