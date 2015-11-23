<?php

namespace System\Frames\Tools {

	use System, System\Utils\Tools, Exception, XML;

	abstract class Sitemap extends System\Frames\Main {

		# Captcha main method

		protected function main() {

			$sitemap = $this->handle();

			if (($sitemap instanceof Tools\Sitemap) && (null !== $sitemap->xml())) {

				return XML::output($sitemap->xml());
			}

			# ------------------------

			throw new Exception\Sitemap();
		}
	}
}
