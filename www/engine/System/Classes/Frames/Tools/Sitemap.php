<?php

namespace System\Frames\Tools {

	use System, System\Frames\Status, System\Utils\Tools;

	abstract class Sitemap extends System\Frames\Main {

		# Captcha main method

		protected function main() {

			$sitemap = $this->handle();

			if (!($sitemap instanceof Tools\Sitemap)) return Status::error404();

			# ------------------------

			$sitemap->output();
		}

		# Handler interface

		abstract protected function handle();
	}
}
