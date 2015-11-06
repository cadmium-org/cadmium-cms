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

			return (isset($_GET[$name]) ? $_GET[$name] : false);
		}

		# Return POST param by name

		public static function post(string $name) {

			return (isset($_POST[$name]) ? $_POST[$name] : false);
		}

		# Return GET params by list of names

		public static function getArray(array $params) {

			return Arr::select($_GET, $params);
		}

		# Return POST params by list of names

		public static function postArray(array $params) {

			return Arr::select($_POST, $params);
		}

		# Redirect to specified url

		public static function redirect(string $url) {

			header("Location: " . $url); exit();
		}
	}
}
