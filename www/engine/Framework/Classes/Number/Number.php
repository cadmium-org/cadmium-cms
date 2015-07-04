<?php

namespace {

	abstract class Number {

		# Validate number

		public static function validate($number) {

			if (is_object($number)) return (method_exists($number, '__toString') ? intval(strval($number)) : 1);

			return intval($number);
		}

		# Validate float

		public static function validateFloat($number) {

			if (is_object($number)) return (method_exists($number, '__toString') ? floatval(strval($number)) : 1);

			return floatval($number);
		}

		# Format number as binary

		public static function binary($number) {

			$number = self::validate($number);

			return (($number >= 1) ? true : false);
		}

		# Format number as positive

		public static function positive($number) {

			$number = self::validate($number);

			return (($number >= 1) ? $number : 1);
		}

		# Format number as unsigned

		public static function unsigned($number) {

			$number = self::validate($number);

			return (($number >= 0) ? $number : 0);
		}

		# Format number as position

		public static function position($number) {

			$number = self::validate($number);

			if ($number < 0) return 0; else if ($number > 99) return 99; else return $number;
		}

		# Format number as color

		public static function color($number) {

			$number = self::validate($number);

			if ($number < 0) return 0; else if ($number > 255) return 255; else return $number;
		}

		# Format number as index

		public static function index($number) {

			$number = self::validate($number);

			if ($number < 1) return 1; else if ($number > 999999) return 999999; else return $number;
		}

		# Format number as price

		public static function price($number) {

			$number = validateFloat($number);

			if ($number < 0) $number = 0; else if ($number > 999999.99) $number = 999999.99;

			# ------------------------

			return floatval(number_format($number, 2, '.', ''));
		}

		# Format number as priority

		public static function priority($number) {

			$number = self::validateFloat($number);

			if ($number < 0) $number = 0; else if ($number > 1) $number = 1;

			# ------------------------

			return floatval(number_format($number, 1, '.', ''));
		}

		# Format text containing number (ukrainian/russian language only)

		public static function text($number, $variant_1, $variant_3, $variant_5) {

			$number = self::unsigned($number); $length = mb_strlen($number);

			$variant_1 = String::validate($variant_1); $variant_3 = String::validate($variant_3); $variant_5 = String::validate($variant_5);

			if (substr($number, ($length - 2), 2) >= 11 && substr($number, ($length - 2), 2) <= 20) return $variant_5;

			else if (substr($number, ($length - 1), 1) == 1) return $variant_1;

			else if (substr($number, ($length - 1), 1) >= 2 && substr($number, ($length - 1), 1) <= 4) return $variant_3;

			else if (substr($number, ($length - 1), 1) >= 5 || substr($number, ($length - 1), 1) == 0) return $variant_5;
		}
	}
}

?>
