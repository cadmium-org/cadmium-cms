<?php

namespace {

	abstract class Image {

		# Output image

		private static function output($image, string $mime, callable $outputter, array $params) {

			if (!is_resource($image)) return false;

			Headers::nocache(); Headers::content($mime);

			call_user_func($outputter, $image, ...$params); imagedestroy($image);

			# ------------------------

			return true;
		}

		# Output JPEG image

		public static function outputJPEG($image, int $quality = 75) {

			$params = [null, Number::format($quality, 0, 100)];

			return self::output($image, MIME_TYPE_JPEG, 'imagejpeg', $params);
		}

		# Output PNG image

		public static function outputPNG($image, int $quality = 4) {

			$params = [null, Number::format($quality, 0, 9)];

			return self::output($image, MIME_TYPE_PNG, 'imagepng', $params);
		}

		# Output GIF image

		public static function outputGIF($image) {

			return self::output($image, MIME_TYPE_GIF, 'imagegif');
		}
	}
}
