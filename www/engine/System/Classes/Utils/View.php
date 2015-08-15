<?php

namespace System\Utils {

    use Extend\Templates;

	class View {

        private static $cache = array();

        # Get view

		public static function get($name) {

            $name = strval($name);

            if (isset($cache[$name])) return clone $cache['name'];

            $class_name = ('Views\\' . Templates::section() . $name);

            # ------------------------

            return ($this->cache[$name] = new $class_name());
        }
	}
}
