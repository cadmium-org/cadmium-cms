<?php

namespace Modules\Extend\Utils\Extension {

	use Modules\Extend;

	abstract class Addons extends Extend\Utils\Extension {

		# Create new loader

		public static function loader(bool $load_all = true) {

			return new static::$loader_class($load_all);
		}

		# Init add-ons list

		public static function init() {

			static::$loader = new static::$loader_class(false);
		}
	}
}
