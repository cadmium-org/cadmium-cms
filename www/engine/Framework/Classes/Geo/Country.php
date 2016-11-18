<?php

/**
 * @package Framework\Geo
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Geo {

	use Range;

	abstract class Country extends Range {

		protected static $range = [];

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			self::init(DIR_DATA . 'Geo/Countries.php');
		}
	}
}
