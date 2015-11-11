<?php

namespace {

	abstract class Validate {

		# Validate ip

		public static function ip(string $value) {

			return filter_var($value, FILTER_VALIDATE_IP);
		}

		# Validate email

		public static function email(string $value) {

			return filter_var($value, FILTER_VALIDATE_EMAIL);
		}

		# Validate regular expression

		public static function regex(string $value) {

			return filter_var($value, FILTER_VALIDATE_REGEXP);
		}

		# Validate mac address

		public static function mac(string $value) {

			return filter_var($value, FILTER_VALIDATE_MAC);
		}

		# Validate url

		public static function url(string $value) {

			$value = filter_var($value, FILTER_VALIDATE_URL);

			return ((false !== $value) ? rtrim('/') : false);
		}
	}
}
