<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Handler {

	use Frames, Modules\Auth, Request, Template;

	class Register extends Frames\Admin\Area\Auth {

		protected $_title = 'TITLE_AUTH_REGISTER';

		/**
		 * Handle the request
		 */

		public function handle() : Template\Block {

			if (!Auth::isInitial()) Request::redirect(INSTALL_PATH . '/admin/login');

			return (new Auth\Action\Register)->handle();
		}
	}
}
