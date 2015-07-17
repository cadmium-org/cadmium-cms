<?php

namespace System\Utils\Extend {

	use System\Utils\Utils, Error, Explorer, Cookie, Language, Request, String, Validate;

	class Languages {

		const ERROR_DIRECTORY	= 'Languages directory does not exist';
		const ERROR_SELECT		= 'Languages not found';

		private static $dir_name = false, $section = false, $items = array(), $active = false;

		# Get items

		private static function getItems($dir_name) {

			$items = array();

			foreach (Explorer::listDirs($dir_name) as $code) {

				$config_file = ($dir_name . $code . '/Config.php');

				$config_values = array('code', 'iso', 'country', 'title', 'author');

				if (false === ($config = Utils::config($config_file, $config_values))) continue;

				if (!(self::valid($config['code']) && ($config['code'] === $code))) continue;

				$items[$config['code']] = $config;
			}

			ksort($items); return $items;
		}

		# Get user language

		private static function getUserLanguage($section) {

			$code = false; $section = strtolower($section);

			if (self::exists($code_get = Request::get('language'))) $code = $code_get;

			else if (self::exists($code_cookie = Cookie::get($section . '_language'))) $code = $code_cookie;

			if (false !== $code) Cookie::set($section . '_language', $code, CONFIG_LANGUAGE_COOKIE_EXPIRES);

			# ------------------------

			return $code;
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

		public static function load($section, $code, $default, $selectable = false) {

			$section = String::validate($section); $code = String::validate($code);

			$default = String::validate($default); $selectable = Validate::boolean($selectable);

			$dir_name = DIR_SYSTEM_LANGUAGES;

			if (!Explorer::isDir($dir_name)) throw new Error\General(self::ERROR_DIRECTORY);

			self::$dir_name = $dir_name; self::$section = $section; self::$items = self::getItems($dir_name);

			if ($selectable && (false !== ($code = self::getUserLanguage($section)))) $code_valid = true;

			else $code_valid = (self::exists($code) || self::exists($code = $default));

			if (!($code_valid || (null !== ($code = key(self::$items))))) throw new Error\General(self::ERROR_SELECT);

			# ------------------------

			Language::init($dir_name . (self::$active = $code));
		}

		# Return items

		public static function items($section = null) {

			if (false === ($section = String::validate($section))) return self::$items;

			$dir_name = DIR_SYSTEM_LANGUAGES;

			return (($dir_name === self::$dir_name) ? self::$items : self::getItems($dir_name));
		}

		# Return active languages code

		public static function active() {

			return self::$active;
		}

		# Return active languages data

		public static function data($name = null) {

			if (false === self::$active) return false;

			if (false === ($name = String::validate($name))) return self::$items[self::$active];

			return (isset(self::$items[self::$active][$name]) ? self::$items[self::$active][$name] : false);
		}
	}
}

?>
