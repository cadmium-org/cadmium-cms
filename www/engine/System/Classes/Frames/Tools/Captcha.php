<?php

namespace System\Frames\Tools {

	use System, System\Modules\Auth, System\Utils\Tools;

	class Captcha extends System\Frames\Main {

		# Captcha main method

		protected function main() {

			# Generate capctha code

			$code = Auth::generateCaptcha();

			# Create captcha

			$captcha = new Tools\Captcha(CONFIG_CAPTCHA_WIDTH, CONFIG_CAPTCHA_HEIGHT, [255, 255, 255]);

			# Customize captcha

			$font = (DIR_SYSTEM_DATA . CONFIG_CAPTCHA_FONT); $size = CONFIG_CAPTCHA_FONT_SIZE;

			$indent = CONFIG_CAPTCHA_TEXT_INDENT; $step = CONFIG_CAPTCHA_TEXT_STEP;

			$captcha->text($font, $size, $indent, $step, $code, [0, 0, 0]);

			$captcha->lines(2, [255, 255, 255]); $captcha->noise(10, [255, 255, 255]);

			$captcha->lines(2, [0, 0, 0]); $captcha->noise(100, [0, 0, 0]);

			# ------------------------

			$captcha->output();
		}
	}
}
