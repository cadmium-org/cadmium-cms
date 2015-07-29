<?php

namespace {

	abstract class Date {

		# Validate date using format

		public static function validate($date, $format) {

			$date = String::validate($date); $format = String::validate($format);

			if (false === ($dt_object = date_create_from_format($format, $date))) return false;

			if (false === ($dt_formatted = $dt_object->format($format))) return false;

			# ------------------------

			return (($dt_formatted == $date) ? $dt_formatted : false);
		}

		# Validate day

		public static function validateDay($day) {

			return ((false !== ($day = self::validate($day, 'd'))) ? $day : false);
		}

		# Validate month

		public static function validateMonth($month) {

			return ((false !== ($month = self::validate($month, 'm'))) ? $month : false);
		}

		# Validate year

		public static function validateYear($year) {

			if (false === ($year = self::validate($year, 'Y'))) return false;

			if ($year < '1900') return '1900'; else if ($year > self::year()) return self::year(); else return $year;
		}

		# Get formatted date from timestamp

		public static function get($format = DATE_FORMAT_STANDART, $time = null) {

			$format = String::validate($format); $time = ((null !== $time) ? Number::unsigned($time) : ENGINE_TIME);

			if ($format === DATE_FORMAT_STANDART) return @date(DATE_FORMAT_STANDART, $time);

			if ($format === DATE_FORMAT_MYSQL) return @date(DATE_FORMAT_MYSQL, $time);

			if ($format === DATE_FORMAT_DATETIME) return @date(DATE_FORMAT_DATETIME, $time);

			if ($format === DATE_FORMAT_W3C) return @date(DATE_FORMAT_W3C, $time);

			# ------------------------

			return false;
		}

		# Get day from timestamp

		public static function day($time = null) {

			$time = ((null !== $time) ? Number::unsigned($time) : ENGINE_TIME);

			return @date('d', $time);
		}

		# Get month from timestamp

		public static function month($time = null) {

			$time = ((null !== $time) ? Number::unsigned($time) : ENGINE_TIME);

			return @date('m', $time);
		}

		# Get year from timestamp

		public static function year($time = null) {

			$time = ((null !== $time) ? Number::unsigned($time) : ENGINE_TIME);

			return @date('Y', $time);
		}
	}
}

?>
