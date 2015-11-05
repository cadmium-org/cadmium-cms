<?php

namespace {

	abstract class Date {

		# Validate date using format

		public static function validate(string $date, string $format) {

			if (false === ($date_object = date_create_from_format($format, $date))) return false;

			if (false === ($date_formatted = $date_object->format($format))) return false;

			# ------------------------

			return (($date_formatted === $date) ? $date_formatted : false);
		}

		# Validate day

		public static function validateDay(int $day) {

			return self::validate($day, 'd');
		}

		# Validate month

		public static function validateMonth(int $month) {

			return self::validate($month, 'm');
		}

		# Validate year

		public static function validateYear(int $year) {

			if (false === ($year = self::validate($year, 'Y'))) return false;

			return (($year > '1900') ? (($year > self::year()) ? self::year() : $year) : '1900');
		}

		# Get formatted date from timestamp

		public static function get(string $format = DATE_FORMAT_STANDART, int $time = null) {

			return date($format, ((null !== $time) ? $time : REQUEST_TIME));
		}

		# Get day from timestamp

		public static function day(int $time = null) {

			return date('d', ((null !== $time) ? $time : REQUEST_TIME));
		}

		# Get month from timestamp

		public static function month(int $time = null) {

			return date('m', ((null !== $time) ? $time : REQUEST_TIME));
		}

		# Get year from timestamp

		public static function year(int $time = null) {

			return date('Y', ((null !== $time) ? $time : REQUEST_TIME));
		}
	}
}
