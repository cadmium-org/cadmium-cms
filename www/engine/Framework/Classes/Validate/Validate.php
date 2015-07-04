<?php

namespace {

	abstract class Validate {

		# Validate id

		public static function id($value) {

			return filter_var(intval($value), FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
		}

		# Validate ip

		public static function ip($value) {

			$value = String::validate($value);

			return filter_var($value, FILTER_VALIDATE_IP);
		}

		# Validate email

		public static function email($value) {

			$value = String::validate($value);

			return filter_var($value, FILTER_VALIDATE_EMAIL);
		}

		# Validate url

		public static function url($value) {

			$value = String::validate($value);

			$value = filter_var($value, FILTER_VALIDATE_URL);

			return preg_replace('/\/*$/', '', $value);
		}

		# Validate boolean

		public static function boolean($value) {

			return filter_var($value, FILTER_VALIDATE_BOOLEAN);
		}
	}
}

?>
