<?php

namespace {

	abstract class Language extends Lister {

		protected static $list = [];

		# Load phrases file

		public static function load($file_name) {

			if (!is_array($phrases = Explorer::php($file_name))) return false;

			foreach ($phrases as $name => $value) {

				$name = strval($name); $value = strval($value);

				if (preg_match(REGEX_LANGUAGE_PHRASE_NAME, $name)) self::$list[$name] = $value;
			}

			# ------------------------

			return true;
		}
	}
}
