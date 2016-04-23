<?php

namespace Geo {

	use Range;

	abstract class Timezone extends Range {

		protected static $range = [];

		# Autoloader

		public static function __autoload() {

			self::init(DIR_DATA . 'Geo/Timezones.php');
		}
	}
}
