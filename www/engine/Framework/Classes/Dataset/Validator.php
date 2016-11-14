<?php

/**
 * @package Framework\Dataset
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Dataset {

	class Validator {

		/**
		 * Get a validator for a given value type
		 */

		public static function get($default) {

			# Check basic types

			if (is_string   ($default)) return function(string      $value) { return $value; };

			if (is_bool     ($default)) return function(bool        $value) { return $value; };

			if (is_int      ($default)) return function(int         $value) { return $value; };

			if (is_float    ($default)) return function(float       $value) { return $value; };

			if (is_array    ($default)) return function(array       $value) { return $value; };

			if (is_callable ($default)) return function(callable    $value) { return $value; };

			# Check object type

			if (is_object($default)) return function($value) use($default) {

				return (is_a($value, get_class($default)) ? $value : null);
			};

			# Check resource type

			if (is_resource($default)) return function($value) { return (is_resource($value) ? $value : null); };

			# ------------------------

			return function() { return null; };
		}
	}
}
