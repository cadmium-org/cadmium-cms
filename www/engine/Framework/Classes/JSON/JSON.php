<?php

/**
 * @package Framework\JSON
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class JSON {

		/**
		 * Parse a string as JSON
		 *
		 * @return the JSON value or null on failure
		 */

		public static function parse(string $string) {

			return json_decode($string, true);
		}

		/**
		 * Convert a JSON value to a string
		 *
		 * @return the string or false on failure
		 */

		public static function stringify($value) {

			return json_encode($value, (JSON_PRETTY_PRINT | JSON_PARTIAL_OUTPUT_ON_ERROR));
		}

		/**
		 * Load a JSON value from a file
		 *
		 * @return the JSON value or null on failure
		 */

		public static function load(string $file_name) {

			if (false === ($contents = Explorer::getContents($file_name))) return null;

			return self::parse($contents);
		}

		/**
		 * Save a JSON value into a file
		 *
		 * @return the number of bytes that were written to the file or false on failure
		 */

		public static function save(string $file_name, $value) {

			if (false === ($value = self::stringify($value))) return false;

			return Explorer::putContents($file_name, $value);
		}

		/**
		 * Output JSON
		 */

		public static function output($value) {

			Headers::sendNoCache(); Headers::sendStatus(STATUS_CODE_200); Headers::sendContent(MIME_TYPE_JSON);

			echo self::stringify($value);
		}
	}
}
