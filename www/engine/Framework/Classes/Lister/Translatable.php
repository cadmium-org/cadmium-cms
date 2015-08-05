<?php

namespace Lister {

	use Language, Lister;

    abstract class Translatable extends Lister {

		# Get item by key

		public static function get($key) {

			$key = strval($key); $class = get_called_class();

			return (isset(self::$list[$class][$key]) ? Language::get(self::$list[$class][$key]) : false);
		}

		# Get list

        public static function range() {

			$list = array(); $class = get_called_class();

			foreach (self::$list[$class] as $key => $value) $list[$key] = Language::get($value);

			# ------------------------

			return $list;
        }
    }
}
