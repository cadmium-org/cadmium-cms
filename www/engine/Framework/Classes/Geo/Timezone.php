<?php

namespace Geo {

	abstract class Timezone extends Utils\Lister {

		# Autoloader

		public static function __autoload() {

			self::init('Geo/Timezones.php');
		}
	}
}
