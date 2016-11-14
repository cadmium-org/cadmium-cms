<?php

/**
 * @package Framework\Date
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Date {

		/**
		 * Validate a date using a given format
		 *
		 * @return the formatted date or false on failure
		 */

		public static function validate(string $date, string $format) {

			if (false === ($datetime = date_create_from_format($format, $date))) return false;

			if (false === ($formatted = $datetime->format($format))) return false;

			# ------------------------

			return (($formatted === $date) ? $formatted : false);
		}

		/**
		 * Check if a given number is a valid day
		 *
		 * @return the formatted day or false on failure
		 */

		public static function validateDay(int $day) {

			return self::validate($day, 'd');
		}

		/**
		 * Check if a given number is a valid month
		 *
		 * @return the formatted month or false on failure
		 */

		public static function validateMonth(int $month) {

			return self::validate($month, 'm');
		}

		/**
		 * Check if a given number is a valid year
		 *
		 * @return the formatted year or false on failure
		 */

		public static function validateYear(int $year) {

			if (false === ($year = self::validate($year, 'Y'))) return false;

			return (($year > '1900') ? (($year > self::getYear()) ? self::getYear() : $year) : '1900');
		}

		/**
		 * Get a date from a given timestamp and format it according to a given pattern.
		 * If the timestamp is null, a current time will be used
		 *
		 * @return the formatted date or false if a non-numeric value is used for timestamp
		 */

		public static function get(string $format = DATE_FORMAT_STANDART, int $time = null) {

			return date($format, ((null !== $time) ? $time : REQUEST_TIME));
		}

		/**
		 * Get a day from a given timestamp. If the timestamp is null, a current time will be used
		 *
		 * @return the formatted day or false if a non-numeric value is used for timestamp
		 */

		public static function getDay(int $time = null) {

			return date('d', ((null !== $time) ? $time : REQUEST_TIME));
		}

		/**
		 * Get a month from a given timestamp. If the timestamp is null, a current time will be used
		 *
		 * @return the formatted month or false if a non-numeric value is used for timestamp
		 */

		public static function getMonth(int $time = null) {

			return date('m', ((null !== $time) ? $time : REQUEST_TIME));
		}

		/**
		 * Get a year from a given timestamp. If the timestamp is null, a current time will be used
		 *
		 * @return the formatted year or false if a non-numeric value is used for timestamp
		 */

		public static function getYear(int $time = null) {

			return date('Y', ((null !== $time) ? $time : REQUEST_TIME));
		}
	}
}
