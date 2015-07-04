<?php

namespace System\Frames\Tools {

	use System, System\Utils\Auth, System\Utils\Tools;

	class Captcha extends System\Frames\Main {

		# Captcha main method

		protected function main() {

			$code = Auth::captcha();

			$black = array(0, 0, 0); $white = array(255, 255, 255);

			$captcha = new Tools\Captcha(CONFIG_CAPTCHA_WIDTH, CONFIG_CAPTCHA_HEIGHT, $white);

			$font = (DIR_SYSTEM_DATA . CONFIG_CAPTCHA_FONT); $size = CONFIG_CAPTCHA_FONT_SIZE;

			$indent = CONFIG_CAPTCHA_TEXT_INDENT; $step = CONFIG_CAPTCHA_TEXT_STEP;

			$captcha->text($font, $size, $indent, $step, $code, $black);

			$captcha->lines(2, $white); $captcha->noise(10, $white);

			$captcha->lines(2, $black); $captcha->noise(100, $black);

			# ------------------------

			$captcha->outputPNG();
		}
	}
}

?>
