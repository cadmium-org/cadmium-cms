<?php

namespace {

	abstract class Mime extends Lister {

		protected static $list = [];

		# Check mime type

		private static function check($extension, $type) {

			if (null === ($mime = self::get($extension))) return false;

			return (preg_match('/^' . $type . '\//', $mime) ? true : false);
		}

		# Autoloader

		public static function __autoload() {

			self::init('Mime.php');
		}

		# Check if extension is image

		public static function isImage($extension) {

			return self::check($extension, 'image');
		}

		# Check if extension is audio

		public static function isAudio($extension) {

			return self::check($extension, 'audio');
		}

		# Check if extension is video

		public static function isVideo($extension) {

			return self::check($extension, 'video');
		}
	}
}
