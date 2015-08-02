<?php

namespace {

	abstract class Request {

		# Check if requested with ajax

		public static function isAjax() {

			return (0 === strcmp(getenv('HTTP_X_REQUESTED_WITH'), 'XMLHttpRequest'));
		}

		# Return GET variable by name

		public static function get($name) {

			$name = strval($name);

			return (isset($_GET[$name]) ? strval($_GET[$name]) : null);
		}

		# Return POST variable by name

		public static function post($name) {

			$name = strval($name);

			return (isset($_POST[$name]) ? strval($_POST[$name]) : null);
		}

		# Redirect to specified url

		public static function redirect($url) {

			$url = strval($url);

			header("Location: " . $url); exit();
		}
	}
}
