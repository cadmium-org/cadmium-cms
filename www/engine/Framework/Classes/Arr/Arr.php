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

		# Select a set of elements from array

		public static function select(array $array, array $params) {

			$array_selected = [];

			foreach ($params as $name) $array_selected[$name] = (isset($array[$name]) ? $array[$name] : null);

			# ------------------------

			return $array_selected;
		}

		# Transform associative array to indexed

		public static function index(array $array, $key_name, $value_name) {

			$key_name = strval($key_name); $value_name = strval($value_name);

			$array_indexed = [];

			foreach ($array as $key => $value) $array_indexed[] = [$key_name => $key, $value_name => $value];

			# ------------------------

			return $array_indexed;
		}

		# Extract subvalue

		public static function subvalExtract(array $array, $sub_key) {

			$sub_key = strval($sub_key);

			$array_extracted = [];

			foreach ($array as $key => $sub_array) {

				if (is_array($sub_array) && isset($sub_array[$sub_key])) $array_extracted[$key] = $sub_array[$sub_key];
			}

			# ------------------------

			return $array_extracted;
		}

		# Sort by subvalue

		public static function subvalSort(array $array, $sub_key, $descending = false) {

			$sub_key = strval($sub_key); $descending = boolval($descending);

			$array_extracted = self::subvalExtract($array, $sub_key); $array_sorted = [];

			if (!$descending) asort($array_extracted); else arsort($array_extracted);

			foreach (array_keys($array_extracted) as $key) $array_sorted[$key] = $array[$key];

			# ------------------------

			return $array_sorted;
		}

		# Get random value

		public static function random(array $array) {

			return $array[array_rand($array)];
		}

		# Encode array

		public static function encode(array $array) {

			return sha1(serialize($array));
		}
	}
}
