<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Language;

	abstract class Range extends \Range {

		/**
		 * Translate a value accordingly to an active language
		 *
		 * @return string|mixed : the translated value or the raw value if the phrase does not exist
		 */

		private static function translate($value) {

			return ((false !== ($translated = Language::get($value))) ? $translated : $value);
		}

		/**
		 * Get a translated item value by a key
		 *
		 * @return mixed|null : the value if the key exists, otherwise null
		 */

		public static function get($key) {

			return ((null !== ($value = parent::get($key))) ? self::translate($value) : null);
		}

		/**
		 * Get the translated range array
		 */

		public static function getRange() : array {

			return array_map('self::translate', parent::getRange());
		}
	}
}
