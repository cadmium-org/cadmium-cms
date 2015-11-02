<?php

namespace System\Modules {

	use Text;

	abstract class Filemanager {

		# Validate file or directory name

		public static function validate($name) {

			$name = Text::input($name, false, CONFIG_FILE_NAME_MAX_LENGTH);

			return (!preg_match('/[\\/?%*:|"<>]/', $name) ? $name : false);
		}
	}
}
