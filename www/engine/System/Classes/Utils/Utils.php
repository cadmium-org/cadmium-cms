<?php

namespace System\Utils {

	use Arr, Date, Explorer, String;

	class Utils {

		# Parse configuration file

		public static function config($file_name, $params) {

			$file_name = String::validate($file_name); $params = Arr::force($params);

			if (!is_array($include = Explorer::php($file_name))) return false;

			$config = array();

			foreach ($params as $name) {

				$name = String::validate($name);

				if (isset($include[$name])) $config[$name] = $include[$name];
			}

			# ------------------------

			return $config;
		}

		# Get copyright string

		public static function copyright($since = null) {

			$since = Date::validateYear($since); $year = Date::year();

			return (((false !== $since) && ($since < $year)) ? ($since . ' - ' . $year) : $year);
		}
	}
}

?>
