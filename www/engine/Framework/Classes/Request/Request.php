<?php

namespace {

	abstract class Request {

		# Check if requested with ajax

		public static function isAjax() {

			return (0 === strcmp(getenv('HTTP_X_REQUESTED_WITH'), 'XMLHttpRequest'));
		}

		# Check if request is secure

		public static function isSecure() {

			$https = (!is_empty(getenv('HTTPS')) && (getenv('HTTPS') !== 'off'));

			return ($https || (getenv('SERVER_PORT') === '443'));
		}

		# Return GET param by name

		public static function get($name) {

			$name = strval($name);

			return (isset($_GET[$name]) ? strval($_GET[$name]) : null);
		}

		# Return POST param by name

		public static function post($name) {

			$name = strval($name);

			return (isset($_POST[$name]) ? strval($_POST[$name]) : null);
		}

		# Return GET params by array of names

		public static function getArray(array $params) {

			return Arr::select($_GET, $params);
		}

		# Return POST params by array of names

		public static function postArray(array $params) {

			return Arr::select($_POST, $params);
		}

		# Redirect to specified url

		public static function redirect($url) {

			$url = strval($url);

			header("Location: " . $url); exit();
		}
	}
}
