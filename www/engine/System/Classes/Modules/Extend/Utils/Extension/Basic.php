<?php

namespace Modules\Extend\Utils\Extension {

	use Modules\Extend, Exception, Cookie, Request;

	abstract class Basic extends Extend\Utils\Extension {

		# Create new loader

		public static function loader(string $section, bool $load_all = true) {

			return new static::$loader_class($section, $load_all);
		}

		# Init extensions list

		public static function init(string $section) {

			static::$loader = new static::$loader_class($section, false);

			# Throw error if no extensions found

			if (false === static::$loader->active()) throw new static::$exception_class;

			# Activate user defined extension

			if (static::$selectable[$section]) {

				$name = static::$name; $param = static::$param[static::$loader->section()];

				if (static::$loader->activate(Request::get($name)) || static::$loader->activate(Cookie::get($param)))

					Cookie::set($param, static::$loader->data('name'), static::$cookie_expires);
			}
		}
	}
}
