<?php

/**
 * @package Cadmium\System\Addons\Contact
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Addons {

	abstract class Contact {

		# Addon configuration

		const NAME_MAX_LENGTH           = 128;
		const EMAIL_MAX_LENGTH          = 128;
		const MESSAGE_MAX_LENGTH        = 2000;
		const CAPTCHA_MAX_LENGTH        = 16;
	}
}
