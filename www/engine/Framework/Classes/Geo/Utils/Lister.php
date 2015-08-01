<?php

namespace Geo\Utils {

	use Explorer, String;

	abstract class Lister {

		private static $list = array();

		# Load list

		protected static function init($file_name) {

			$file_name = (DIR_DATA . $file_name);

			if (is_array($list = Explorer::php($file_name))) self::$list = $list;
		}

		# Check if item exists

		public static function exists($key) {

			$key = String::validate($key);

			return (isset(self::$list[$key]));
		}

		# Validate key

		public static function validate($key) {

			$key = String::validate($key);

			return (self::exists($key) ? $key : false);
		}

		# Get item by key

		public static function get($key) {

			$key = String::validate($key);

			return (self::exists($key) ? self::$list[$key] : false);
		}

		# Get list

		public static function range() {

			return self::$list;
		}
	}
}