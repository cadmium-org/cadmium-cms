<?php

namespace Geo {

	use Explorer, String;

	abstract class Timezone {

		private static $timezones = false;

		# Autoloader

		public static function __autoload() {

			self::$timezones = Explorer::php(DIR_DATA . 'Geo/Timezones.php');
		}

		# Check if timezone exists

		public static function exists($name) {

			$name = String::validate($name);

			return (isset(self::$timezones[$name]) ? true : false);
		}

		# Validate name

		public static function validate($name) {

			$name = String::validate($name);

			return (self::exists($name) ? $name : false);
		}

		# Get timezone by name

		public static function get($name) {

			$name = String::validate($name);

			return (isset(self::$timezones[$name]) ? self::$timezones[$name] : false);
		}

		# Get list

		public static function range() {

			return self::$timezones;
		}
	}
}

?>
