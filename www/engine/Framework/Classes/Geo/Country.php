<?php

namespace Geo {

	abstract class Country extends Utils\Lister {

		# Autoloader

		public static function __autoload() {

			self::init('Geo/Countries.php');
		}
	}
}
