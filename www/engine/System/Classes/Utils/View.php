<?php

namespace System\Utils {

	use Error;

	abstract class View {

		private static $section = '', $error = 'View is not initialized', $cache = [];

		# Init view

		public static function init($section) {

			self::$section = (($section === SECTION_ADMIN) ? SECTION_ADMIN : SECTION_SITE);
		}

		# Get view

		public static function get($name) {

			if ('' === self::$section) throw new Error\General(self::$error);

			$class_name = ('System\Views\\' . self::$section . '\\' . $name);

			if (isset(self::$cache[$class_name])) return clone self::$cache[$class_name];

			# ------------------------

			return (self::$cache[$class_name] = new $class_name());
		}
	}
}
