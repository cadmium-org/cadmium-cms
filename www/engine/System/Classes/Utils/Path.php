<?php

namespace System\Utils {

	use System\Modules\Settings, Url;

	abstract class Path {

		private static $path = '';

		# Init path

		public static function init() {

			$url = new Url(Settings::get('system_url'));

			foreach ($url->path() as $part) self::$path .= ('/' . $part);
		}

		# Get path

		public static function get() {

			return self::$path;
		}
	}
}
