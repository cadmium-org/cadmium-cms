<?php

/**
 * @package Cadmium\Framework\Number
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Number {

		/**
		 * Force a given variable to an integer
		 */

		public static function forceInt($number, int $min = 0, int $max = 0) : int {

			if (!is_numeric($number) || (($number = intval($number)) < 0)) $number = 0;

			if (($min > 0) && ($number < $min)) return $min;

			if (($max > 0) && ($number > $max)) return $max;

			# ------------------------

			return $number;
		}

		/**
		 * Force a given variable to a float
		 */

		public static function forceFloat($number, float $min = 0, float $max = 0, int $decimals = 0) : float {

			if (!is_numeric($number) || (($number = floatval($number)) < 0)) $number = 0;

			if (($min > 0) && ($number < $min)) $number = $min;

			if (($max > 0) && ($number > $max)) $number = $max;

			$number = floatval(number_format($number, $decimals, '.', ''));

			# ------------------------

			return $number;
		}

		/**
		 * Format a given number as a file size
		 */

		public static function size(int $number) : string {

			$number = (($number >= 0) ? $number : 0); $exponents = [0 => 'Bytes', 'KB', 'MB', 'GB', 'TB'];

			foreach ($exponents as $exponent => $text) if ($number < pow(1024, ($exponent + 1))) {

				$number = number_format(($number / pow(1024, $exponent)), (($exponent < 2) ? $exponent : 2));

				return (floatval($number) . ' ' . $text);
			}

			# ------------------------

			return '> 1 PB';
		}

		/**
		 * Format a text related to a number (for specific languages such as ukrainian or russian)
		 *
		 * @return string : one of the given forms depending on the number
		 */

		public static function text(int $number, string $form_1, string $form_3, string $form_5) : string {

			$number = (($number >= 0) ? $number : 0); $length = strlen($number);

			$last_1 = substr($number, ($length - 1), 1); $last_2 = substr($number, ($length - 2), 2);

			if (($last_2 >= 11) && ($last_2 <= 20)) return $form_5;

			if ($last_1 == 1) return $form_1;

			if (($last_1 >= 2) && ($last_1 <= 4)) return $form_3;

			if (($last_1 >= 5) || ($last_1 == 0)) return $form_5;
		}
	}
}
