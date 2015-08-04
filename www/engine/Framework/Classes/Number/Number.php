<?php

namespace {

	abstract class Number {

		# Format number

		public static function format($number, $min = 0, $max = 0, $decimals = 0) {

			$number = floatabs($number); $min = floatabs($min); $max = floatabs($max);

			$decimals = intabs($decimals);

			if (($min > 0) && ($number < $min)) $number = $min;

			else if (($max > 0) && ($number > $max)) $number = $max;

			$number = (($decimals > 0) ? floatval(number_format($number, $decimals, '.', '')) : intval($number));

			# ------------------------

			return $number;
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
