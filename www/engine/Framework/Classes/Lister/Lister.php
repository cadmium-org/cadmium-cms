<?php

namespace {

	abstract class Lister {

		protected static $list = array();

		# Load list

		protected static function init($file_name) {

			$file_name = (DIR_DATA . $file_name); $class = get_called_class();

			if (is_array($list = Explorer::php($file_name))) self::$list[$class] = $list;
		}

		# Check if item exists

		public static function exists($key) {

			$key = strval($key); $class = get_called_class();

			return isset(self::$list[$class][$key]);
		}

		# Validate key

		public static function validate($key) {

			$key = strval($key); $class = get_called_class();

			return (isset(self::$list[$class][$key]) ? $key : false);
		}

		# Get item by key

		public static function get($key) {

			$key = strval($key); $class = get_called_class();

			return (isset(self::$list[$class][$key]) ? self::$list[$class][$key] : false);
		}

		# Get list

		public static function range() {

			return self::$list[get_called_class()];
		}
	}
}
