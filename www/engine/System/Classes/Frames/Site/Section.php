<?php

/**
 * @package Cadmium\System\Frames\Site
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Site {

	use Frames, Frames\Status, Modules\Auth, Modules\Settings, Ajax, Request, Template;

	abstract class Section extends Frames\Section {

		# Define active section

		const SECTION = SECTION_SITE;

		# Define phrases list

		const PHRASES = ['Common', 'Mail', 'Range', 'Site', 'User'];

		# Page settings

		protected $_title = '', $_layout = 'Common';

		/**
		 * Handle an auth area request
		 */

		private function handleAuthArea() {

			# Check auth

			if (Auth::isLogged()) Request::redirect(INSTALL_PATH . '/profile');

			# ------------------------

			return $this->handleCommonArea();
		}

		/**
		 * Handle an authorized area request
		 */

		private function handleAuthorizedArea() {

			# Check auth

			if (!Auth::isLogged() || ((false !== Request::get('logout')) && Auth::logout())) {

				Request::redirect(INSTALL_PATH . '/profile/login');
			}

			# ------------------------

			return $this->handleCommonArea();
		}

		/**
		 * Handle a common area request
		 */

		private function handleCommonArea() {

			# Handle request

			$result = $this->handle(Request::isAjax());

			if (Template::isBlock($result)) return (new View($this->_title, $this->_layout))->display($result);

			if (Ajax::isResponse($result)) return Ajax::output($result);

			# ------------------------

			return Status::displayError404();
		}

		/**
		 * The branch method for the site section
		 */

		protected function _section() {

			# Check site status

			if (Settings::get('site_status') === STATUS_MAINTENANCE) return Status::displayMaintenance();

			if (Settings::get('site_status') === STATUS_UPDATE) return Status::displayUpdate();

			# Handle request

			if ($this instanceof Area\Auth) return $this->handleAuthArea();

			if ($this instanceof Area\Authorized) return $this->handleAuthorizedArea();

			if ($this instanceof Area\Common) return $this->handleCommonArea();

			# ------------------------

			return Status::displayError404();
		}
	}
}
