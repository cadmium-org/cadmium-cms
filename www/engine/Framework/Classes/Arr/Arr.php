<?php

namespace {

	abstract class Arr {

		# Force variable convert to array

		public static function force($array) {

			return (is_array($array) ? $array : array());
		}

		# Get array value by path

		public static function get($array, $path) {

			if (array() === ($array = self::force($array))) return null;

			if (array() === ($path = self::force($path))) return null;

			foreach ($path as $item) {

				if (!isset($array[$item])) return null;

				$value = ($array = $array[$item]);
			}

			return $value;
		}

		# Transform associative array to indexed

		public static function index($array, $key_name, $value_name) {

			if (array() === ($array = self::force($array))) return array();

			$key_name = String::validate($key_name); $value_name = String::validate($value_name);

			$array_indexed = array();

			foreach ($array as $key => $value) $array_indexed[] = array($key_name => $key, $value_name => $value);

			# ------------------------

			return $array_indexed;
		}

		# Extract subvalue

		public static function subvalExtract($array, $sub_key) {

			if (array() === ($array = self::force($array))) return array();

			$sub_key = String::validate($sub_key);

			$array_extracted = array();

			foreach ($array as $key => $sub_array) {

				if (is_array($sub_array) && isset($sub_array[$sub_key])) $array_extracted[$key] = $sub_array[$sub_key];
			}

			# ------------------------

			return $array_extracted;
		}

		# Sort by subvalue

		public static function subvalSort($array, $sub_key, $desc = false) {

			if (array() === ($array = self::force($array))) return array();

			$sub_key = String::validate($sub_key); $desc = Validate::boolean($desc);

			$array_extracted = self::subvalExtract($array, $sub_key); $array_sorted = array();

			if (!$desc) asort($array_extracted); else arsort($array_extracted);

			foreach (array_keys($array_extracted) as $key) $array_sorted[$key] = $array[$key];

			# ------------------------

			return $array_sorted;
		}

		# Get random value

		public static function random($array) {

			if (array() === ($array = self::force($array))) return false;

		    return $array[array_rand($array)];
		}
	}
}

?>
