<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils\Extension {

	use Modules\Extend;

	abstract class Addons extends Extend\Utils\Extension {

		/**
		 * Get a loader object
		 */

		public static function getLoader(bool $load_all = true) : Extend\Utils\Loader\Addons {

			return new static::$loader_class($load_all);
		}

		/**
		 * Initialize the add-ons list
		 */

		public static function init() {

			static::$loader = new static::$loader_class(false);
		}
	}
}
