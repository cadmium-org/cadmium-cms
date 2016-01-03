<?php

namespace System\Utils {

	use Exception;

	abstract class View {

		private static $section = '', $cache = [];

		# Init view

		public static function init(string $section) {

			self::$section = (($section === SECTION_ADMIN) ? SECTION_ADMIN : SECTION_SITE);
		}

		# Get view

		public static function get(string $name) {

			if ('' === self::$section) throw new Exception\View();

			$class_name = ('System\Views\\' . self::$section . '\\' . $name);

			if (isset(self::$cache[$class_name])) $view = clone self::$cache[$class_name];

			else $view = (self::$cache[$class_name] = new $class_name());

			# ------------------------

			return $view;
		}
	}
}
