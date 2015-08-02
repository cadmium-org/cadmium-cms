<?php

namespace {

	abstract class Number {

		# Format number as binary

		public static function binary($number) {

			$number = intval($number);

			return (($number >= 1) ? true : false);
		}

		# Format number as positive

		public static function positive($number, $max = null) {

			$number = intval($number);

			if ((null !== $max) && ($number > ($max = self::positive($max)))) return $max;

			return (($number >= 1) ? $number : 1);
		}

		# Format number as unsigned

		public static function unsigned($number, $max = null) {

			$number = intval($number);

			if ((null !== $max) && ($number > ($max = self::unsigned($max)))) return $max;

			return (($number >= 0) ? $number : 0);
		}

		# Format number as position

		public static function position($number) {

			$number = intval($number);

			if ($number < 0) return 0; else if ($number > 99) return 99; else return $number;
		}

		# Format number as color

		public static function color($number) {

			$number = intval($number);

			if ($number < 0) return 0; else if ($number > 255) return 255; else return $number;
		}

		# Format number as index

		public static function index($number) {

			$number = intval($number);

			if ($number < 1) return 1; else if ($number > 999999) return 999999; else return $number;
		}

		# Format number as price

		public static function price($number) {

			$number = floatval($number);

			if ($number < 0) $number = 0; else if ($number > 999999.99) $number = 999999.99;

			# ------------------------

			return floatval(number_format($number, 2, '.', ''));
		}

		# Format number as priority

		public static function priority($number) {

			$number = floatval($number);

			if ($number < 0) $number = 0; else if ($number > 1) $number = 1;

			# ------------------------

			return floatval(number_format($number, 1, '.', ''));
		}

		# Format text containing number (ukrainian/russian language only)

		public static function text($number, $variant_1, $variant_3, $variant_5) {

			$number = self::unsigned($number); $length = strlen($number);

			$variant_1 = strval($variant_1); $variant_3 = strval($variant_3); $variant_5 = strval($variant_5);

			if (substr($number, ($length - 2), 2) >= 11 && substr($number, ($length - 2), 2) <= 20) return $variant_5;

			else if (substr($number, ($length - 1), 1) == 1) return $variant_1;

			else if ((substr($number, ($length - 1), 1) >= 2) && (substr($number, ($length - 1), 1) <= 4)) return $variant_3;

			else if ((substr($number, ($length - 1), 1) >= 5) || (substr($number, ($length - 1), 1) == 0)) return $variant_5;
		}
	}
}
