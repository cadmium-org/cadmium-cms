<?php

/**
 * @package Cadmium\Framework\Arr
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Arr {

		/**
		 * Get an array value by a given path, where path is an array of keys.
		 * This method is useful for accessing multidimensional arrays
		 *
		 * @return mixed|null : the value or null if the path does not exist
		 */

		public static function get(array $array, array $path) {

			$value = null;

			foreach ($path as $item) if (isset($array[$item])) $value = ($array = $array[$item]); else return null;

			# ------------------------

			return $value;
		}

		/**
		 * Select a set of elements from an array according to given keys.
		 * A result array can be optionally filtered by a given callback
		 */

		public static function select(array $array, array $keys, callable $filter = null) : array {

			$selected = array_intersect_key($array, array_flip($keys));

			if (null !== $filter) $selected = array_filter($array, $filter);

			# ------------------------

			return $selected;
		}

		/**
		 * Transform an associative array to indexed. Every element of a result array will be an array of type:
		 * [$key_name => old_key, $value_name => old_value]
		 */

		public static function index(array $array, string $key_name, string $value_name) : array {

			$indexed = [];

			foreach ($array as $key => $value) $indexed[] = [$key_name => $key, $value_name => $value];

			# ------------------------

			return $indexed;
		}

		/**
		 * Sort an array by a subvalue
		 */

		public static function sortby(array $array, $sub_key, bool $descending = false) : array {

			$select_key = function($element) use($sub_key) { return ($element[$sub_key] ?? false); };

			$sorted = []; $column = array_map($select_key, $array);

			if (!$descending) asort($column); else arsort($column);

			foreach (array_keys($column) as $key) $sorted[$key] = $array[$key];

			# ------------------------

			return $sorted;
		}

		/**
		 * Get a random value from an array
		 *
		 * @return mixed|null : the value or null if the array is empty
		 */

		public static function random(array $array) {

			return ($array[array_rand($array)] ?? null);
		}

		/**
		 * Encode an array into a 40-character hash string
		 */

		public static function encode(array $array) : string {

			return sha1(serialize($array));
		}
	}
}
