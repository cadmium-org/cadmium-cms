<?php

namespace Geo {

	use Lister;

	abstract class Timezone extends Lister {

		protected static $list = array();

		# Autoloader

		public static function __autoload() {

			self::init('Geo/Timezones.php');
		}
	}
}
