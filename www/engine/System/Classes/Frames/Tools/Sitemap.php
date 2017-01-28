<?php

/**
 * @package Cadmium\System\Frames
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Tools {

	use Frames, Modules\Tools, Exception, XML;

	abstract class Sitemap extends Frames\Main {

		/**
		 * The branch method for the sitemap
		 */

		protected function _main() {

			$sitemap = $this->handle();

			if (($sitemap instanceof Tools\Sitemap) && (null !== $sitemap->xml())) {

				return XML::output($sitemap->xml());
			}

			# ------------------------

			throw new Exception\Sitemap;
		}

		/**
		 * The interface for a handler method
		 *
		 * @return Tools\Sitemap|null : the sitemap object on success or null on failure
		 */

		abstract protected function handle();
	}
}
