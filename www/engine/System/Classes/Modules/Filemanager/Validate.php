<?php

namespace Modules\Filemanager {

	abstract class Validate {

		# Validate file or directory name

		public static function name(string $name) {

			return (preg_match(REGEX_FILE_NAME, $name) ? $name : false);
		}
	}
}
