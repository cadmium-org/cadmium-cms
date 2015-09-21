<?php

namespace System\Handlers\Tools {

	use System, System\Utils\Security, System\Utils\Tools;

	class Captcha extends System\Frames\Tools\Captcha {

		# Handle request

		protected function handle() {

			# Generate capctha code

			$code = Security::generateCaptcha();

			# Preset colors

			$black = [0, 0, 0]; $white = [255, 255, 255];

			# Create captcha

			$captcha = new Tools\Captcha(CONFIG_CAPTCHA_WIDTH, CONFIG_CAPTCHA_HEIGHT, $white);

			# Customize captcha

			$font = (DIR_SYSTEM_DATA . CONFIG_CAPTCHA_FONT); $size = CONFIG_CAPTCHA_FONT_SIZE;

			$indent = CONFIG_CAPTCHA_TEXT_INDENT; $step = CONFIG_CAPTCHA_TEXT_STEP;

			$captcha->text($font, $size, $indent, $step, $code, $black);

			$captcha->lines(2, $white); $captcha->noise(10, $white);

			$captcha->lines(2, $black); $captcha->noise(100, $black);

			# ------------------------

			return $captcha;
		}
	}
}
