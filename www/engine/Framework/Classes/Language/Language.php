<?php

namespace {

	abstract class Language extends Lister {

		protected static $list = [];

		# Add phrase to list

		private static function add(string $name, string $value) {

			if (preg_match(REGEX_LANGUAGE_PHRASE_NAME, $name)) self::$list[$name] = $value;
		}

		# Load phrases file

		public static function load(string $file_name) {

			if (!is_array($phrases = Explorer::php($file_name))) return false;

			foreach ($phrases as $name => $value) self::add($name, $value);

			# ------------------------

			return true;
		}
	}
}
