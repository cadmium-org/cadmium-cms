<?php

/**
 * @package Cadmium\Framework\Validate
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Validate {

		/**
		 * Validate a boolean value
		 *
		 * @return bool : true for "1", "true", "on" and "yes", otherwise false
		 */

		public static function boolean($value) : bool {

			return filter_var($value, FILTER_VALIDATE_BOOLEAN);
		}

		/**
		 * Validate an ip address
		 *
		 * @return string|false : the filtered data or false if the filter fails
		 */

		public static function ip(string $value) {

			return filter_var($value, FILTER_VALIDATE_IP);
		}

		/**
		 * Validate an email
		 *
		 * @return string|false : the filtered data or false if the filter fails
		 */

		public static function email(string $value) {

			return filter_var($value, FILTER_VALIDATE_EMAIL);
		}

		/**
		 * Validate a regular expression
		 *
		 * @return string|false : the filtered data or false if the filter fails
		 */

		public static function regex(string $value) {

			return filter_var($value, FILTER_VALIDATE_REGEXP);
		}

		/**
		 * Validate a mac address
		 *
		 * @return string|false : the filtered data or false if the filter fails
		 */

		public static function mac(string $value) {

			return filter_var($value, FILTER_VALIDATE_MAC);
		}

		/**
		 * Validate an url
		 *
		 * @return string|false : the filtered data or false if the filter fails
		 */

		public static function url(string $value) {

			return filter_var($value, FILTER_VALIDATE_URL);
		}
	}
}
