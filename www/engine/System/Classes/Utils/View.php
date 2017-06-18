<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Exception, Modules\Extend, Explorer, Template;

	abstract class View {

		private static $cache = [];

		/**
		 * Initialize the class
		 */

		public static function init() {

			self::$cache = [];
		}

		/**
		 * Get a view block
		 */

		public static function get(string $name) : Template\Block {

			if (false === ($path = Extend\Templates::get('path'))) throw new Exception\View;

			if (!isset(self::$cache[$file_name = ($path . $name . '.ctp')])) {

				if (false === ($contents = Explorer::getContents($file_name))) throw new Exception\ViewFile($file_name);

				self::$cache[$file_name] = Template::createBlock($contents);
			}

			# ------------------------

			return clone self::$cache[$file_name];
		}
	}
}
