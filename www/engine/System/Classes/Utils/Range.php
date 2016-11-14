<?php

namespace Utils {

	use Language;

	abstract class Range extends \Range {

		# Translate value

		private static function translate($value) {

			return ((false !== ($translated = Language::get($value))) ? $translated : $value);
		}

		# Get item by key

		public static function get($key) {

			return ((false !== ($value = parent::get($key))) ? self::translate($value) : false);
		}

		# Get range array

		public static function getRange() {

			return array_map('self::translate', parent::getRange());
		}
	}
}
