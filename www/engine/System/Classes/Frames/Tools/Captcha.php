<?php

namespace System\Frames\Tools {

	use System, System\Frames\Status, System\Utils\Tools;

	abstract class Captcha extends System\Frames\Main {

		# Captcha main method

		protected function main() {

			$captcha = $this->handle();

			if (!($captcha instanceof Tools\Captcha)) return Status::error404();

			# ------------------------

			$captcha->output();
		}

		# Handler interface

		abstract protected function handle();
	}
}
