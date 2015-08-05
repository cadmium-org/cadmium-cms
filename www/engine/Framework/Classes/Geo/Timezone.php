<?php

namespace Geo {

	use Lister;

	abstract class Timezone extends Lister {

		# Autoloader

		public static function __autoload() {

			self::init('Geo/Timezones.php');
		}
	}
}
