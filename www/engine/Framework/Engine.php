<?php

namespace {

	abstract class Engine {

		# Get client IP

		public static function ip() {

			if (!empty(getenv('HTTP_CLIENT_IP')))           return getenv('HTTP_CLIENT_IP');

			if (!empty(getenv('HTTP_X_FORWARDED_FOR')))     return getenv('HTTP_X_FORWARDED_FOR');

			if (!empty(getenv('HTTP_X_FORWARDED')))         return getenv('HTTP_X_FORWARDED');

			if (!empty(getenv('HTTP_FORWARDED_FOR')))       return getenv('HTTP_FORWARDED_FOR');

			if (!empty(getenv('HTTP_FORWARDED')))           return getenv('HTTP_FORWARDED');

			if (!empty(getenv('REMOTE_ADDR')))              return getenv('REMOTE_ADDR');

			# ------------------------

			return 'unknown';
		}

		# Display exception screen

		public static function exception(Throwable $exc) {

			$message = $exc->getMessage();

			# Load template

			$file_name = (DIR_TEMPLATES . 'Exception.tpl');

			$contents = ((@file_exists($file_name)) ? @file_get_contents($file_name) : false);

			$output = ($contents ? str_replace('$message$', $message, $contents) : $message);

			# Set headers

			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

			header('Cache-Control: no-store, no-cache, must-revalidate');

			header('Cache-Control: post-check=0, pre-check=0', false);

			header('Pragma: no-cache');

			header(getenv('SERVER_PROTOCOL') . ' 500 Internal Server Error', true, 500);

			header('Content-type: text/html; charset=UTF-8');

			# ------------------------

			exit ($output);
		}
	}
}
