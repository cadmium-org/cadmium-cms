<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils\Extension {

	use Modules\Extend, Cookie, Request;

	abstract class Basic extends Extend\Utils\Extension {

		/**
		 * Get a loader object
		 */

		public static function getLoader(string $section, bool $load_all = true) : Extend\Utils\Loader\Basic {

			return new static::$loader_class($section, $load_all);
		}

		/**
		 * Initialize the extensions list
		 */

		public static function init(string $section) {

			static::$loader = new static::$loader_class($section, false);

			# Throw error if no extensions found

			if (false === static::$loader->get('name')) throw new static::$exception_class;

			# Activate user defined extension

			if (static::$selectable[static::$loader->getSection()]) {

				$name = static::$name; $param = static::$param[static::$loader->getSection()];

				if (static::$loader->activate(Request::get($name)) || static::$loader->activate(Cookie::get($param)))

					Cookie::set($param, static::$loader->get('name'), static::$cookie_expires);
			}
		}
	}
}
