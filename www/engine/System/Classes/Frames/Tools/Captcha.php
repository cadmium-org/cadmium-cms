<?php

/**
 * @package Cadmium\System\Frames
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Tools {

	use Frames, Modules\Tools, Exception, Image;

	abstract class Captcha extends Frames\Main {

		/**
		 * The branch method for the captcha
		 */

		protected function _main() {

			$captcha = $this->handle();

			if (($captcha instanceof Tools\Captcha) && (null !== $captcha->image())) {

				return Image::outputPNG($captcha->image());
			}

			# ------------------------

			throw new Exception\Captcha;
		}

		/**
		 * The interface for a handler method
		 *
		 * @return Tools\Captcha|null : the captcha object on success or null on failure
		 */

		abstract protected function handle();
	}
}
