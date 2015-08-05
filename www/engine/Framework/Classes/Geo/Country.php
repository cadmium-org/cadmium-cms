<?php

namespace Geo {

	use Lister;

	abstract class Country extends Lister {

		# Autoloader

		public static function __autoload() {

			self::init('Geo/Countries.php');
		}
	}
}
