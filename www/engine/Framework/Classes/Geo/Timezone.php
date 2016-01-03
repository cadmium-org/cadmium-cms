<?php

namespace Geo {

	use Lister;

	abstract class Timezone extends Lister {

		protected static $list = [];

		# Autoloader

		public static function __autoload() {

			self::init(DIR_DATA . 'Geo/Timezones.php');
		}
	}
}
