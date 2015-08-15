<?php

namespace System\Utils {

    use System\Utils\Extend\Templates;

	class View {

        private static $cache = array();

        # Get view

		public static function get($name) {

            $name = strval($name);

            if (isset(self::$cache[$name])) return clone self::$cache['name'];

            $class_name = ('System\\Views\\' . Templates::section() . '\\' . str_replace('/', '\\', $name));

            # ------------------------

            return (self::$cache[$name] = new $class_name());
        }
	}
}
