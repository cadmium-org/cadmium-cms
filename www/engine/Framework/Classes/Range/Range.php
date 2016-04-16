<?php

namespace {

	abstract class Range {

		protected static $range = [];

		# Load range

		protected static function init(string $file_name) {

			if (is_array($range = Explorer::php($file_name))) static::$range = $range;
		}

		# Check if item exists

		public static function exists($key) {

			return isset(static::$range[$key]);
		}

		# Validate key

		public static function validate($key) {

			$keys = array_keys(static::$range);

			return ((false !== ($key = array_search($key, $keys))) ? $keys[$key] : false);
		}

		# Get item by key

		public static function get($key) {

			return (static::$range[$key] ?? false);
		}

		# Get range array

		public static function array() {

			return static::$range;
		}
	}
}
