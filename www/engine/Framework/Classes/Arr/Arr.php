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

		public static function select(array $array, array $keys) {

			foreach ($keys as $key) if (is_scalar($key)) yield $key => (isset($array[$key]) ? $array[$key] : false);
		}

		# Transform associative array to indexed

		public static function index(array $array, string $key_name, string $value_name) {

			foreach ($array as $key => $value) yield [$key_name => $key, $value_name => $value];
		}

		# Sort array by subvalue

		public static function sortby(array $array, $sub_key, bool $descending = false) {

			$column = array_column($array, $sub_key);

			if (!$descending) asort($column); else arsort($column);

			foreach (array_keys($column) as $key) yield $key => $array[$key];
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
