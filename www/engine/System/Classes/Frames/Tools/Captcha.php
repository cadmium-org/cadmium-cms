<?php

namespace System\Frames\Tools {

	use System, System\Frames\Status, System\Utils\Tools, Image;

	abstract class Captcha extends System\Frames\Main {

		# Captcha main method

		protected function main() {

			$captcha = $this->handle();

			if (!($captcha instanceof Tools\Captcha)) return Status::error404();

			# ------------------------

			Image::outputPNG($captcha->image());
		}

		# Handler interface

		abstract protected function handle();
	}
}
