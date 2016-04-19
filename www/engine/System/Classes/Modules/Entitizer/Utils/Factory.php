<?php

namespace Modules\Entitizer\Utils {

	use Exception;

	abstract class Factory {

		protected static $error_message = '', $cache = [], $classes = [];

		# Get class instance

		public static function get(string $table) {

			if (!isset(static::$classes[$table])) throw new Exception\General(static::$error_message);

			if (!isset(static::$cache[$table])) static::$cache[$table] = new static::$classes[$table];

			# ------------------------

			return static::$cache[$table];
		}
	}
}
