<?php

namespace {

	abstract class Arr {

		# Get array value by path

		public static function get(array $array, array $path) {

			$value = false;

			foreach ($path as $item) if (isset($array[$item])) $value = ($array = $array[$item]); else return false;

			# ------------------------

			return $value;
		}

		# Transform associative array to indexed

		public static function index(array $array, $key_name, $value_name) {

			$key_name = String::validate($key_name); $value_name = String::validate($value_name);

			$array_indexed = array();

			foreach ($array as $key => $value) $array_indexed[] = array($key_name => $key, $value_name => $value);

			# ------------------------

			return $array_indexed;
		}

		# Extract subvalue

		public static function subvalExtract(array $array, $sub_key) {

			$sub_key = String::validate($sub_key);

			$array_extracted = array();

			foreach ($array as $key => $sub_array) {

				if (is_array($sub_array) && isset($sub_array[$sub_key])) $array_extracted[$key] = $sub_array[$sub_key];
			}

			# ------------------------

			return $array_extracted;
		}

		# Sort by subvalue

		public static function subvalSort(array $array, $sub_key, $descending = false) {

			$sub_key = String::validate($sub_key); $descending = Validate::boolean($descending);

			$array_extracted = self::subvalExtract($array, $sub_key); $array_sorted = array();

			if (!$descending) asort($array_extracted); else arsort($array_extracted);

			foreach (array_keys($array_extracted) as $key) $array_sorted[$key] = $array[$key];

			# ------------------------

			return $array_sorted;
		}

		# Get random value

		public static function random(array $array) {

		    return $array[array_rand($array)];
		}
	}
}
