<?php

/**
 * @package Cadmium\Framework\Image
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Image {

		/**
		 * Output an image
		 *
		 * @return bool : true on success or false if the given image is not a valid resource
		 */

		private static function output($image, string $mime, callable $outputter, array $params = []) : bool {

			if (!is_resource($image)) return false;

			Headers::sendNoCache(); Headers::sendContent($mime);

			$outputter($image, ...$params); imagedestroy($image);

			# ------------------------

			return true;
		}

		/**
		 * Output a JPEG image
		 *
		 * @param $quality ranges from 0 (worst) to 100 (best)
		 *
		 * @return bool : true on success or false if the given image is not a valid resource
		 */

		public static function outputJPEG($image, int $quality = 75) : bool {

			$params = [null, Number::forceInt($quality, 0, 100)];

			return self::output($image, MIME_TYPE_JPEG, 'imagejpeg', $params);
		}

		/**
		 * Output a PNG image
		 *
		 * @param $quality ranges from 0 (no compression) to 9
		 *
		 * @return bool : true on success or false if the given image is not a valid resource
		 */

		public static function outputPNG($image, int $quality = 4) : bool {

			$params = [null, Number::forceInt($quality, 0, 9)];

			return self::output($image, MIME_TYPE_PNG, 'imagepng', $params);
		}

		/**
		 * Output a GIF image
		 *
		 * @return bool : true on success or false if the given image is not a valid resource
		 */

		public static function outputGIF($image) : bool {

			return self::output($image, MIME_TYPE_GIF, 'imagegif');
		}
	}
}
