<?php

namespace {

	abstract class Number {

		# Format number

		public static function format($number, $min = 0, $max = 0) {

			$number = intabs($number); $min = intabs($min); $max = intabs($max);

			if (($min > 0) && ($number < $min)) return $min;

			if (($max > 0) && ($number > $max)) return $max;

			# ------------------------

			return $number;
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

			$number = intabs($number); $length = strlen($number);

			$variant_1 = strval($variant_1); $variant_3 = strval($variant_3); $variant_5 = strval($variant_5);

			if (substr($number, ($length - 2), 2) >= 11 && substr($number, ($length - 2), 2) <= 20) return $variant_5;

			else if (substr($number, ($length - 1), 1) == 1) return $variant_1;

			else if ((substr($number, ($length - 1), 1) >= 2) && (substr($number, ($length - 1), 1) <= 4)) return $variant_3;

			else if ((substr($number, ($length - 1), 1) >= 5) || (substr($number, ($length - 1), 1) == 0)) return $variant_5;
		}
	}
}
