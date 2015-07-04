<?php

namespace System\Utils\Extend {

	use System\Utils\Utils, Error, Explorer, Language, String;

	class Languages {

		const ERROR_DIRECTORY	= 'Languages directory does not exist';
		const ERROR_SELECT		= 'Languages not found';

		private static $loaded = false, $section = false, $items = array(), $active = false;

		# Get items

		private static function getItems($section) {

			$items = array(); $section = ((false !== $section) ? ($section . '/') : '');

			foreach (Explorer::listDirs(DIR_SYSTEM_LANGUAGES . $section) as $code) {

				$config_file = (DIR_SYSTEM_LANGUAGES . $section . $code . '/Config.php');

				$config_values = array('code', 'iso', 'country', 'title', 'author');

				if (false === ($config = Utils::config($config_file, $config_values))) continue;

				if (!(self::valid($config['code']) && ($config['code'] === $code))) continue;

				$items[$config['code']] = $config;
			}

			ksort($items); return $items;
		}

		# Check if code valid

		public static function valid($code) {

			$code = String::validate($code);

			return (preg_match(REGEX_LANGUAGE_CODE, $code) ? true : false);
		}

		# Validate code

		public static function validate($code) {

			$code = String::validate($code);

			return (self::valid($code) ? $code : false);
		}

		# Check if language exists

		public static function exists($code) {

			if (array() === self::$items) return false;

			$code = String::validate($code);

			# ------------------------

			return (self::valid($code) && isset(self::$items[$code]));
		}

		# Load language

		public static function load($section, $code, $default) {

			if (false !== self::$loaded) return;

			$section = String::validate($section); $code = String::validate($code); $default = String::validate($default);

			if (!Explorer::isDir(DIR_SYSTEM_LANGUAGES . $section)) throw new Error\General(self::ERROR_DIRECTORY);

			self::$loaded = true; self::$section = $section; self::$items = self::getItems($section);

			$code_valid = (self::exists($code) || self::exists($code = $default));

			if (!($code_valid || (null !== ($code = key(self::$items))))) throw new Error\General(self::ERROR_SELECT);

			# ------------------------

			Language::init(DIR_SYSTEM_LANGUAGES . ((false !== self::$section) ? (self::$section . '/') : '') . (self::$active = $code));
		}

		# Return items

		public static function items($section) {

			return (((false === self::$section) || ($section === self::$section)) ? self::$items : self::getItems($section));
		}

		# Return active languages code

		public static function active() {

			return self::$active;
		}

		# Return active languages data

		public static function data($name) {

			if (false === self::$active) return false;

			if (null === $name) return self::$items[self::$active];

			$name = String::validate($name);

			return (isset(self::$items[self::$active][$name]) ? self::$items[self::$active][$name] : false);
		}
	}
}

?>
