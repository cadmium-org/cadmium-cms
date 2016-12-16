<?php

/**
 * @package Cadmium\Framework\Geo
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Geo {

	use Range;

	abstract class Timezone extends Range {

		protected static $range = [];

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			self::init(DIR_DATA . 'Geo/Timezones.php');
		}
	}
}
