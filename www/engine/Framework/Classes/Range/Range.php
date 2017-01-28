<?php

/**
 * @package Cadmium\Framework\Range
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Range {

		protected static $range = [];

		/**
		 * Load data from a file
		 */

		protected static function init(string $file_name) {

			if (is_array($range = Explorer::include($file_name))) static::$range = $range;
		}

		/**
		 * Check if a key exists in the range
		 */

		public static function exists($key) : bool {

			return isset(static::$range[$key]);
		}

		/**
		 * Validate a key
		 *
		 * @return mixed|null : the key if exists, otherwise false
		 */

		public static function validate($key) {

			$keys = array_keys(static::$range);

			return ((false !== ($key = array_search($key, $keys))) ? $keys[$key] : false);
		}

		/**
		 * Get an item value by a key
		 *
		 * @return mixed|null : the value if the key exists, otherwise null
		 */

		public static function get($key) {

			return (static::$range[$key] ?? null);
		}

		/**
		 * Get the range array
		 */

		public static function getRange() : array {

			return static::$range;
		}
	}
}
