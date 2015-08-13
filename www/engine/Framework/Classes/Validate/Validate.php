<?php

namespace {

	abstract class Validate {

		# Validate ip

		public static function ip($value) {

			$value = strval($value);

			return filter_var($value, FILTER_VALIDATE_IP);
		}

		# Validate email

		public static function email($value) {

			$value = strval($value);

			return filter_var($value, FILTER_VALIDATE_EMAIL);
		}

		# Validate url

		public static function url($value) {

			$value = strval($value);

			$value = filter_var($value, FILTER_VALIDATE_URL);

			return ((false !== $value) ? preg_replace('/\/*$/', '', $value) : false);
		}
	}
}
