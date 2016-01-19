<?php

namespace Modules\Extend\Utils {

	use Exception, Modules\Settings, Arr, Cookie, Explorer, Request;

	trait Extension {

		private static $section = '', $dir_name = '', $items = [], $active = '', $primary = '';

		# Get section

		private static function getSection(string $section) {

			return (($section === SECTION_ADMIN) ? SECTION_ADMIN : SECTION_SITE);
		}

		# Get directory name

		private static function getDirName(string $section) {

			return (self::$root_dir . (self::$separate ? ($section . '/') : ''));
		}

		# Get items

		private static function getItems(string $dir_name) {

			$items = [];

			foreach (Explorer::listDirs($dir_name) as $name) {

				$file_name = ($dir_name . $name . '/Config.json');

				if (false === ($config = Explorer::json($file_name))) continue;

				$config = Arr::select($config, self::$data);

				if (!(self::valid($config['name']) && ($config['name'] === $name))) continue;

				$items[$name] = array_map('strval', $config);
			}

			# ------------------------

			ksort($items); return $items;
		}

		# Get user defined extension name

		private static function getUserDefined() {

			$name = ''; $param = self::$param[self::$section];

			if (self::exists($name_cookie = Cookie::get($param))) $name = $name_cookie;

			if (self::exists($name_get = Request::get(self::$name))) $name = $name_get;

			if ('' !== $name) Cookie::set($param, $name, self::$cookie_expires); else return false;

			# ------------------------

			return $name;
		}

		# Check if name valid

		public static function valid(string $name) {

			return (preg_match(self::$regex_name, $name) ? true : false);
		}

		# Validate name

		public static function validate(string $name) {

			return (self::valid($name) ? $name : false);
		}

		# Check if extension exists

		public static function exists(string $name) {

			return (self::valid($name) && isset(self::$items[$name]));
		}

		# Init extensions list

		public static function init($section) {

			$section = self::getSection($section); $dir_name = self::getDirName($section);

			if (!Explorer::isDir($dir_name)) throw new Exception\General(self::$error_directory);

			self::$section = $section; self::$dir_name = $dir_name; self::$items = self::getItems($dir_name);

			$selectable = self::$selectable[$section]; $param = self::$param[$section];

			$primary = (self::exists(self::$default[$section]) ? self::$default[$section] : false);

			if ($selectable && (false !== ($name = self::getUserDefined()))) $name_valid = true;

			else $name_valid = (self::exists($name = Settings::get($param)) || (false !== ($name = $primary)));

			if (!($name_valid || (null !== ($name = key(self::$items))))) throw new Exception\General(self::$error_select);

			# ------------------------

			self::$active = $name; self::$primary = $primary;
		}

		# Return active section

		public static function section() {

			return self::$section;
		}

		# Return directory name

		public static function dirName() {

			return self::$dir_name;
		}

		# Return items

		public static function items(string $section = null) {

			if (null === $section) return self::$items;

			$section = self::getSection($section); $dir_name = self::getDirName($section);

			return (($dir_name !== self::$dir_name) ? self::getItems($dir_name) : self::$items);
		}

		# Return active extension name

		public static function active() {

			return self::$active;
		}

		# Return primary extension name

		public static function primary() {

			return self::$primary;
		}

		# Get active extension path

		public static function path() {

			if ('' === self::$active) return false;

			return (self::$dir_name . self::$active . '/');
		}

		# Get primary extension path

		public static function pathPrimary() {

			if ('' === self::$primary) return false;

			return (self::$dir_name . self::$primary . '/');
		}

		# Get active extension data

		public static function data(string $name = null) {

			if ('' === self::$active) return false;

			if (null === $name) return self::$items[self::$active];

			return (isset(self::$items[self::$active][$name]) ? self::$items[self::$active][$name] : false);
		}
	}
}
