<?php

namespace {

	abstract class Lister {

		protected static $list = array();

		# Load list

		protected static function init($file_name) {

			$file_name = (DIR_DATA . $file_name);

			if (is_array($list = Explorer::php($file_name))) static::$list = $list;
		}

		# Check if item exists

		public static function exists($key) {

			$key = strval($key);

			return isset(static::$list[$key]);
		}

		# Validate key

		public static function validate($key) {

			$key = strval($key);

			return (isset(static::$list[$key]) ? $key : false);
		}

		# Get item by key

		public static function get($key) {

			$key = strval($key);

			return (isset(static::$list[$key]) ? static::$list[$key] : false);
		}

		# Get list

		public static function range() {

			return static::$list;
		}
	}
}
