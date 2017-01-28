<?php

/**
 * @package Cadmium\Framework\Mime
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Mime extends Range {

		protected static $range = [];

		/**
		 * Check if an extension is of a given type
		 */

		private static function checkType(string $extension, string $type) : bool {

			if (false === ($mime = self::get($extension))) return false;

			return (preg_match(('/^' . $type . '\//'), $mime) ? true : false);
		}

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			self::init(DIR_DATA . 'Mime.php');
		}

		/**
		 * Check if a given extension is of an image type
		 */

		public static function isImage(string $extension) : bool {

			return self::checkType($extension, 'image');
		}

		/**
		 * Check if a given extension is of an audio type
		 */

		public static function isAudio(string $extension) : bool {

			return self::checkType($extension, 'audio');
		}

		/**
		 * Check if a given extension is of a video type
		 */

		public static function isVideo(string $extension) : bool {

			return self::checkType($extension, 'video');
		}
	}
}
