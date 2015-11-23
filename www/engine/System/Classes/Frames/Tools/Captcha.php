<?php

namespace System\Frames\Tools {

	use System, System\Utils\Tools, Exception, Image;

	abstract class Captcha extends System\Frames\Main {

		# Captcha main method

		protected function main() {

			$captcha = $this->handle();

			if (($captcha instanceof Tools\Captcha) && (null !== $captcha->image())) {

				return Image::outputPNG($captcha->image());
			}

			# ------------------------

			throw new Exception\Captcha();
		}
	}
}
