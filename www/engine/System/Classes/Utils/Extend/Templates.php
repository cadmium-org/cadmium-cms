<?php

namespace System\Utils\Extend {

	use Warning, System\Utils\Utils, Explorer, Cookie, Template, Request, String, Validate;

	class Templates {

		const ERROR_DIRECTORY   = 'Templates directory does not exist';
		const ERROR_SELECT      = 'Templates not found';

		private static $dir_name = false, $section = false, $items = array(), $active = false;

		# Get items

		private static function getItems($dir_name) {

			$items = array();

			foreach (Explorer::listDirs($dir_name) as $name) {

				$config_file = ($dir_name . $name . '/Config.php');

				$config_values = array('name', 'title', 'author');

				if (false === ($config = Utils::config($config_file, $config_values))) continue;

				if (!(self::valid($config['name']) && ($config['name'] === $name))) continue;

				$items[$config['name']] = $config;
			}

			ksort($items); return $items;
		}

		# Get user template

		private static function getUserTemplate($section) {

			$name = false; $section = strtolower($section);

			if (self::exists($name_get = Request::get('template'))) $name = $name_get;

			else if (self::exists($name_cookie = Cookie::get($section . '_template'))) $name = $name_cookie;

			if (false !== $name) Cookie::set($section . '_template', $name, CONFIG_TEMPLATE_COOKIE_EXPIRES);

			# ------------------------

			return $name;
		}

		# Check if name valid

		public static function valid($name) {

			$name = String::validate($name);

			return (preg_match(REGEX_TEMPLATE_NAME, $name) ? true : false);
		}

		# Validate name

		public static function validate($name) {

			$name = String::validate($name);

			return (self::valid($name) ? $name : false);
		}

		# Check if template exists

		public static function exists($name) {

			if (array() === self::$items) return false;

			$name = String::validate($name);

			# ------------------------

			return (self::valid($name) && isset(self::$items[$name]));
		}

		# Load template

		public static function load($section, $name, $default, $selectable = false) {

			$section = String::validate($section); $name = String::validate($name);

			$default = String::validate($default); $selectable = Validate::boolean($selectable);

			$dir_name = (DIR_SYSTEM_TEMPLATES . $section . '/');

			if (!Explorer::isDir($dir_name)) throw new Warning\General(self::ERROR_DIRECTORY);

			self::$dir_name = $dir_name; self::$section = $section; self::$items = self::getItems($dir_name);

			if ($selectable && (false !== ($name = self::getUserTemplate($section)))) $name_valid = true;

			else $name_valid = (self::exists($name) || self::exists($name = $default));

			if (!($name_valid || (null !== ($name = key(self::$items))))) throw new Warning\General(self::ERROR_SELECT);

			# ------------------------

			Template::init($dir_name . (self::$active = $name));
		}

		# Return items

		public static function items($section = null) {

			if (false === ($section = String::validate($section))) return self::$items;

			$dir_name = (DIR_SYSTEM_TEMPLATES . $section . '/');

			return (($dir_name === self::$dir_name) ? self::$items : self::getItems($dir_name));
		}

		# Return active templates name

		public static function active() {

			return self::$active;
		}

		# Return active templates data

		public static function data($name = null) {

			if (false === self::$active) return false;

			if (false === ($name = String::validate($name))) return self::$items[self::$active];

			return (isset(self::$items[self::$active][$name]) ? self::$items[self::$active][$name] : false);
		}
	}
}
