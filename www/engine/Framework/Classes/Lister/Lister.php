<?php

namespace {

	abstract class Lister {

		protected static $list = [];

		# Load list

		protected static function init(string $file_name) {

			if (is_array($list = Explorer::php($file_name))) static::$list = $list;
		}

		# Check if item exists

		public static function exists($key) {

			return isset(static::$list[$key]);
		}

		# Validate key

		public static function validate($key) {

			$range = array_keys(static::$list);

			return ((false !== ($key = array_search($key, $range))) ? $range[$key] : false);
		}

		# Get item by key

		public static function get($key) {

			return (isset(static::$list[$key]) ? static::$list[$key] : null);
		}

		# Get list

		public static function list() {

			return static::$list;
		}
	}
}
