<?php

namespace {

	abstract class Language {

		private static $init = false, $dir_name = '', $phrases = [];

		# Init language

		public static function init($dir_name) {

			if (self::$init) return;

			$dir_name = strval($dir_name);

			if (!Explorer::isDir($dir_name)) throw new Error\LanguageInit($dir_name);

			self::$init = true; self::$dir_name = $dir_name; self::$phrases = [];
		}

		# Include phrases files

		public static function phrases(array $phrases) {

			if (!self::$init) return false;

			foreach ($phrases as $name) {

				$name = strval($name);

				if (!preg_match(REGEX_LANGUAGE_FILE_NAME, $name)) continue;

				$file_name = (self::$dir_name . '/Phrases/' . $name . '.php');

				if (!is_array($phrases = Explorer::php($file_name))) continue;

				foreach ($phrases as $name => $value) {

					$name = strval($name); $value = strval($value);

					if (preg_match(REGEX_LANGUAGE_PHRASE_NAME, $name)) self::$phrases[$name] = $value;
				}
			}

			return true;
		}

		# Get phrase by name

		public static function get($name) {

			if (!self::$init) return false;

			$name = strval($name);

			return (isset(self::$phrases[$name]) ? self::$phrases[$name] : null);
		}
	}
}
