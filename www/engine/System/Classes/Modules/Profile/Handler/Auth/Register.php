<?php

/**
 * @package Cadmium\System\Modules\Profile
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Profile\Handler\Auth {

	use Frames, Modules\Auth;

	class Register extends Frames\Site\Area\Auth {

		protected $_title = 'TITLE_PROFILE_AUTH_REGISTER';

		# Handle request

		protected function handle() {

			return (new Auth\Action\Register)->handle();
		}
	}
}
