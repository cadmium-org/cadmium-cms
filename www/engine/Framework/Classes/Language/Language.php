<?php

namespace {

	abstract class Language {

		private static $init = false, $dir_name = false, $phrases = array();

		# Init language

		public static function init($dir_name) {

			if (self::$init) return;

			$dir_name = String::validate($dir_name);

			if (!Explorer::isDir($dir_name)) throw new Warning\LanguageInit($dir_name);

			self::$init = true; self::$dir_name = $dir_name;
		}

		# Include phrases files

		public static function phrases() {

			if (!self::$init) return false;

			foreach (func_get_args() as $name) {

				$name = String::validate($name);

				if (!preg_match(REGEX_LANGUAGE_FILE_NAME, $name)) continue;

				$file_name = (self::$dir_name . '/Phrases/' . $name . '.php');

				$phrases = Arr::force(Explorer::php($file_name));

				foreach ($phrases as $name => $value) {

					$name = String::validate($name); $value = String::validate($value);

					if (preg_match(REGEX_LANGUAGE_PHRASE_NAME, $name)) self::$phrases[$name] = $value;
				}
			}

			return true;
		}

		# Get phrase by name

		public static function get($name) {

			if (!self::$init) return false;

			return (isset(self::$phrases[$name]) ? self::$phrases[$name] : false);
		}
	}
}
