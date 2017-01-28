<?php

/**
 * @package Cadmium\Framework\Language
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Language {

		protected static $phrases = [];

		/**
		 * Add a phrase to the list
		 */

		private static function addPhrase(string $name, string $value) {

			if (preg_match(REGEX_LANGUAGE_PHRASE_NAME, $name)) self::$phrases[$name] = $value;
		}

		/**
		 * Load a phrases list from a file
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function load(string $file_name) : bool {

			if (!is_array($phrases = Explorer::include($file_name))) return false;

			foreach ($phrases as $name => $value) if (is_scalar($value)) self::addPhrase($name, $value);

			# ------------------------

			return true;
		}

		/**
		 * Get a phrase
		 *
		 * @return string|false : the phrase if exists, otherwise false
		 */

		public static function get(string $name) {

			return (self::$phrases[$name] ?? false);
		}

		/**
		 * Get the phrases array
		 */

		public static function getPhrases() : array {

			return static::$phrases;
		}
	}
}
