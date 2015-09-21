<?php

namespace System\Modules\Extend\Utils {

    use Error, System\Modules\Config, Cookie, Explorer, Request;

    trait Extension {

        private static $section = '', $dir_name = '', $items = [], $active = '';

        # Get section

        private static function getSection($section) {

            return (($section === SECTION_ADMIN) ? SECTION_ADMIN : SECTION_SITE);
        }

        # Get directory name

        private static function getDirName($section) {

            return (self::$root_dir . (self::$separate ? ($section . '/') : ''));
        }

        # Parse configuration file

        private static function parseConfig($file_name, array $params) {

			$file_name = strval($file_name);

			if (!is_array($include = Explorer::php($file_name))) return false;

			$config = [];

			foreach ($params as $name) {

				$name = strval($name);

				$config[$name] = ((isset($include[$name])) ? $include[$name] : null);
			}

			# ------------------------

			return $config;
		}

        # Get items

        private static function getItems($dir_name) {

			$items = [];

			foreach (Explorer::listDirs($dir_name) as $name) {

				$file_name = ($dir_name . $name . '/Config.php');

				if (false === ($config = self::parseConfig($file_name, self::$data))) continue;

				if (!(self::valid($config['name']) && ($config['name'] === $name))) continue;

				$items[$name] = $config;
			}

            # ------------------------

			ksort($items); return $items;
		}

        # Get user defined extension name

		private static function getUserDefined() {

			if (self::exists($name_get = Request::get(self::$name))) $name = $name_get;

			else if (self::exists($name_cookie = Cookie::get(self::$param[self::$section]))) $name = $name_cookie;

			if (isset($name)) Cookie::set((self::$param[self::$section]), $name, self::$cookie_expires); else return false;

			# ------------------------

			return $name;
		}

        # Check if name valid

		public static function valid($name) {

			$name = strval($name);

			return (preg_match(self::$regex_name, $name) ? true : false);
		}

		# Validate name

		public static function validate($name) {

			$name = strval($name);

			return (self::valid($name) ? $name : false);
		}

		# Check if extension exists

		public static function exists($name) {

			$name = strval($name);

			return (self::valid($name) && isset(self::$items[$name]));
		}

        # Init extensions list

        public static function init($section) {

            $section = self::getSection($section); $dir_name = self::getDirName($section);

			if (!Explorer::isDir($dir_name)) throw new Error\General(self::$error_directory);

			self::$section = $section; self::$dir_name = $dir_name; self::$items = self::getItems($dir_name);

            $selectable = self::$selectable[$section]; $param = self::$param[$section]; $default = self::$default[$section];

			if ($selectable && (false !== ($name = self::getUserDefined()))) $name_valid = true;

			else $name_valid = (self::exists($name = Config::get($param)) || self::exists($name = $default));

			if (!($name_valid || (null !== ($name = key(self::$items))))) throw new Error\General(self::$error_select);

			# ------------------------

			self::$active = $name;
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

		public static function items($section = null) {

            if (null === $section) return self::$items;

            $section = self::getSection($section); $dir_name = self::getDirName($section);

			return (($dir_name !== self::$dir_name) ? self::getItems($dir_name) : self::$items);
		}

		# Return active extension name

		public static function active() {

			return self::$active;
		}

        # Get active extension path

		public static function path() {

			if ('' === self::$active) return false;

			return (self::$dir_name . self::$active . '/');
		}

        # Get active extension data

		public static function data($name = null) {

			if ('' === self::$active) return null;

			if (null === $name) return self::$items[self::$active];

            $name = strval($name);

			return (isset(self::$items[self::$active][$name]) ? self::$items[self::$active][$name] : null);
		}
    }
}
