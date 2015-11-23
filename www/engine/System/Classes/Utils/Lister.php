<?php

namespace System\Utils {

	use Language;

	abstract class Lister extends \Lister {

		# Translate value

		private static function translate($value) {

			return ((false !== ($translated = Language::get($value))) ? $translated : $value);
		}

		# Get item by key

		public static function get($key) {

			return ((false !== ($value = parent::get($key))) ? self::translate($value) : false);
		}

		# Get list

		public static function list() {

			return array_map('self::translate', parent::list());
		}
	}
}
