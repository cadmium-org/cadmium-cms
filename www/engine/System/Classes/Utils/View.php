<?php

namespace Utils {

	use Exception, Modules\Extend, Explorer, Template;

	abstract class View {

		private static $cache = [];

		# Init view

		public static function init() {

			self::$cache = [];
		}

		# Get view

		public static function get(string $name) {

			if (false === ($path = Extend\Templates::path())) throw new Exception\View;

			if (!isset(self::$cache[$file_name = ($path . $name . '.tpl')])) {

				if (false === ($contents = Explorer::getContents($file_name))) throw new Exception\ViewFile($file_name);

				self::$cache[$file_name] = Template::createBlock($contents);
			}

			# ------------------------

			return clone self::$cache[$file_name];
		}
	}
}
