<?php

namespace {

	abstract class Number {

		# Format number

		public static function format(int $number, int $min = 0, int $max = 0) {

			if (($min > 0) && ($number < $min)) return $min;

			if (($max > 0) && ($number > $max)) return $max;

			# ------------------------

			return $number;
		}

		# Format float number

		public static function formatFloat(float $number, float $min = 0, float $max = 0, int $decimals = 0) {

			if (($min > 0) && ($number < $min)) $number = $min;

			if (($max > 0) && ($number > $max)) $number = $max;

			$number = floatval(number_format($number, $decimals, '.', ''));

			# ------------------------

			return $number;
		}

		# Format number as file size

		public static function size(int $number) {

			if ($number < 0) $number = 0;

			$exponents = [0 => 'Bytes', 'KB', 'MB', 'GB', 'TB'];

			foreach ($exponents as $exponent => $text) if ($number < pow(1024, ($exponent + 1))) {

				$number = number_format(($number / pow(1024, $exponent)), (($exponent < 2) ? $exponent : 2));

				return (floatval($number) . ' ' . $text);
			}

			# ------------------------

			return '> 1 PB';
		}

		# Format text containing number (ukrainian/russian language only)

		public static function text(int $number, string $variant_1, string $variant_3, string $variant_5) {

			$number = abs($number); $length = strlen($number);

			$last_1 = substr($number, ($length - 1), 1); $last_2 = substr($number, ($length - 2), 2);

			if (($last_2 >= 11) && ($last_2 <= 20)) return $variant_5;

			if ($last_1 == 1) return $variant_1;

			if (($last_1 >= 2) && ($last_1 <= 4)) return $variant_3;

			if (($last_1 >= 5) || ($last_1 == 0)) return $variant_5;
		}
	}
}
