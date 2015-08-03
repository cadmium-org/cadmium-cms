<?php

namespace System\Utils {

	use Headers, String, Validate;

	abstract class Ajax {

		private static $data = array(), $status = true;

		# Set variable

		public static function set($name, $value) {

			$name = strval($name); $value = strval($value);

			self::$data[$name] = $value;
		}

		# Set error

		public static function error($value) {

			self::set('error', $value);

			return (self::$status = false);
		}

		# Set status

		public static function status($value) {

			self::$status = boolval($value);
		}

		# Output JSON data

		public static function output($status = null) {

			$status = intval((null !== $status) ? boolval($status) : self::$status);

			Headers::nocache(); Headers::status(STATUS_CODE_200); Headers::content(MIME_TYPE_JSON);

			echo json_encode(array_merge(array('status' => $status), self::$data));

			# ------------------------

			return true;
		}
	}
}
