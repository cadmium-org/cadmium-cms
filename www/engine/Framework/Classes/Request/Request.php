<?php

namespace {

	abstract class Request {

		# Check if request is ajax

		public static function isAjax() {

			return (getenv('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest');
		}

		# Check if request is secure

		public static function isSecure() {

			$https = (!empty(getenv('HTTPS')) && (getenv('HTTPS') !== 'off'));

			return ($https || (getenv('SERVER_PORT') === '443'));
		}

		# Return GET param by name

		public static function get(string $name) {

			return ($_GET[$name] ?? false);
		}

		# Return POST param by name

		public static function post(string $name) {

			return ($_POST[$name] ?? false);
		}

		# Return file by name

		public static function file(string $name) {

			return ($_FILES[$name] ?? false);
		}

		# Redirect to specified url

		public static function redirect(string $url) {

			header("Location: " . $url); exit();
		}
	}
}
