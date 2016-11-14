<?php

namespace Frames\Tools {

	use Frames, Modules\Tools, Exception, XML;

	abstract class Sitemap extends Frames\Main {

		# Sitemap main method

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
