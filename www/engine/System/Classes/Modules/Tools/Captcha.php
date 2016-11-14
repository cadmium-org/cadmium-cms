<?php

namespace Modules\Tools {

	use Explorer, Number;

	class Captcha {

		private $image = null, $width = 0, $height = 0;

		# Allocate color

		private function allocateColor(array $color = null) {

			if (null === $this->image) return false;

			if (null === $color) $color = [0, 0, 0]; else if (count($color) !== 3) return false;

			foreach (array_values($color) as $key => $value) $color[$key] = Number::forceInt($value, 0, 255);

			# ------------------------

			return imagecolorallocate($this->image, ...$color);
		}

		# Constructor

		public function __construct(int $width, int $height, array $bg_color = null) {

			if (false === ($image = imagecreatetruecolor($width, $height))) return;

			$this->image = $image; $this->width = $width; $this->height = $height;

			if (false !== ($bg_color = $this->allocateColor($bg_color))) {

				imagefilledrectangle($image, 0, 0, ($width - 1), ($height - 1), $bg_color);
			}
		}

		# Draw text

		public function text(string $font, int $size, int $indent, int $step, string $text, array $color = null) {

			if (null === $this->image) return false;

			if (!Explorer::isFile($font)) return false;

			if (false === ($color = $this->allocateColor($color))) return false;

			$base = (floor(($this->height - $size) / 2) + $size);

			foreach (str_split($text) as $index => $character) {

				$angle = random_int(-10, 10); $x = ($indent + ($index * $step)); $y = random_int(($base - 5), ($base + 5));

				imagettftext($this->image, $size, $angle, $x, $y, $color, $font, $character);
			}

			# ------------------------

			return true;
		}

		# Draw noise

		public function noise(int $rate, array $color = null) {

			if (null === $this->image) return false;

			if (false === ($color = $this->allocateColor($color))) return false;

			for ($x = 0; $x < $this->width; $x++) for ($y = 0; $y < $this->height; $y++) {

				if (random_int(1, $rate) === 1) imagesetpixel($this->image, $x, $y, $color);
			}

			# ------------------------

			return true;
		}

		# Draw lines

		public function lines(int $count, array $color = null) {

			if (null === $this->image) return false;

			if (false === ($color = $this->allocateColor($color))) return false;

			for ($i = 0; $i < $count; $i++) {

				$point_0 = [0, random_int(0, ($this->height - 1))];

				$point_1 = [($this->width - 1), random_int(0, ($this->height - 1))];

				imageline($this->image, $point_0[0], $point_0[1], $point_1[0], $point_1[1], $color);
			}

			# ------------------------

			return true;
		}

		# Return image

		public function image() {

			return $this->image;
		}
	}
}
