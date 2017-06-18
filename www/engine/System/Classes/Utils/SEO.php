<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Dataset;

	abstract class SEO {

		private static $dataset = null;

		/**
		 * Initialize the SEO data
		 */

		public static function init() {

			self::$dataset = new Dataset(['title' => '', 'description' => '', 'keywords' => '',

				'robots_index' => false, 'robots_follow' => false, 'canonical' => '']);
		}

		/**
		 * Set a param value
		 *
		 * @return bool : true on success or false on error
		 */

		public static function set(string $name, $value) : bool {

			if (null === self::$dataset) self::init();

			return (self::$dataset->set($name, $value) ?? false);
		}

		/**
		 * Get a param value
		 *
		 * @return mixed|false : the value or false if the param does not exist
		 */

		public static function get(string $name) {

			if (null === self::$dataset) self::init();

			return (self::$dataset->get($name) ?? false);
		}

		/**
		 * Get a robots string
		 */

		public static function getRobots() {

			if (null === self::$dataset) self::init();

			return ((self::get('robots_index') ? 'INDEX' : 'NOINDEX') . ',' . (self::get('robots_follow') ? 'FOLLOW' : 'NOFOLLOW'));
		}
	}
}
