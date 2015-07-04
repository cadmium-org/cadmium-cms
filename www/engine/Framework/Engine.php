<?php

namespace {

	class Engine {

		# Get client IP

		private function getIP() {

			if (($value = getenv('HTTP_CLIENT_IP')) && strcasecmp($value, 'unknown')) return $value;

			else if (($value = getenv('REMOTE_ADDR')) && strcasecmp($value, 'unknown')) return $value;

			else if (($value = getenv('HTTP_X_FORWARDED_FOR')) && strcasecmp($value, 'unknown')) return $value;

			else if (isset($_SERVER['REMOTE_ADDR']) && ($value = $_SERVER['REMOTE_ADDR']) && strcasecmp($value, 'unknown'))

				return $_SERVER['REMOTE_ADDR']; else return 'Unknown';
			}

		# Engine constructor

		public function __construct() {

			# Include engine constants

			require_once (DIR_INCLUDES . 'Config.php');
			require_once (DIR_INCLUDES . 'Constants.php');
			require_once (DIR_INCLUDES . 'Regex.php');
			require_once (DIR_INCLUDES . 'Headers/Mime.php');
			require_once (DIR_INCLUDES . 'Headers/Status.php');

			# Set engine defaults

			mb_internal_encoding(CONFIG_FRAMEWORK_DEFAULT_CHARSET);

			date_default_timezone_set(CONFIG_FRAMEWORK_DEFAULT_TIMEZONE);

			# Set engine constants

			define('ENGINE_CLIENT_IP', $this->getIP());

			define('ENGINE_TIME', $_SERVER['REQUEST_TIME']);

			define('ENGINE_MICRO_TIME', $_SERVER['REQUEST_TIME_FLOAT']);

			# ------------------------

			$this->main();
		}

		# Display error screen

		public static function error($message) {

			$message = (('' !== ($message = strval($message))) ? ('Engine error: ' . $message) : 'Unknown error');

			$file_exists = (@file_exists($file_name = (DIR_TEMPLATES . 'Error.tpl')) && (false != ($contents = @file_get_contents($file_name))));

			$contents = ($file_exists ? str_replace('$message$', $message, $contents) : $message);

			# Set headers

			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

			header('Cache-Control: no-store, no-cache, must-revalidate');

			header('Cache-Control: post-check=0, pre-check=0', false);

			header('Pragma: no-cache');

			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

			header('Content-type: text/html; charset=UTF-8');

			# ------------------------

			exit ($contents);
		}
	}
}

?>
