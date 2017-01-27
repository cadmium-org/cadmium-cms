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

			return ((null !== ($value = parent::get($key))) ? self::translate($value) : null);
		}

		# Get range array

		public static function getRange() : array {

			return array_map('self::translate', parent::getRange());
		}
	}
}
