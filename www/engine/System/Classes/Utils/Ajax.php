<?php

namespace System\Utils {

	use Headers, String, Validate;

	abstract class Ajax {

		private static $data = array(), $status = true;

		# Set variable

		public static function set($set, $value = null) {

			if (!is_array($set)) $set = array($set => $value);

			foreach ($set as $name => $value) {

				$name = String::validate($name);

				if (!is_array($value)) { self::$data[$name] = String::validate($value); continue; }

				self::$data[$name] = array();

				foreach ($value as $s_name => $s_value) {

					self::$data[$name][String::validate($s_name)] = String::validate($s_value);
				}
			}
		}

		# Set error

		public static function error($value) {

			self::set('error', $value); return (self::$status = false);
		}

		# Set status

		public static function status($value) {

			self::$status = Validate::boolean($value);
		}

		# Output JSON data

		public static function output($status) {

			$status = intval((null !== $status) ? Validate::boolean($status) : self::$status);

			Headers::nocache(); Headers::status(STATUS_CODE_200); Headers::content(MIME_TYPE_JSON);

			echo json_encode(array_merge(array('status' => $status), self::$data));

			# ------------------------

			return true;
		}
	}
}

?>
