<?php

/**
 * @package Cadmium\System\Frames\Admin
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Admin {

	use Frames, Frames\Status, Modules\Auth, Ajax, Request, Template;

	abstract class Section extends Frames\Section {

		# Define active section

		const SECTION = SECTION_ADMIN;

		# Define phrases list

		const PHRASES = ['Admin', 'Ajax', 'Common', 'Install', 'Mail', 'Menuitem', 'Page', 'Range', 'User', 'Variable', 'Widget'];

		# Page settings

		protected $_title = '';

		/**
		 * Handle a form area request
		 */

		private function handleFormArea() {

			# Check auth

			if (($this instanceof Area\Auth) && Auth::isLogged()) Request::redirect(INSTALL_PATH . '/admin');

			# Handle request

			if (Template::isBlock($result = $this->handle())) return (new View\Form($this->_title))->display($result);

			# ------------------------

			return Status::displayError404();
		}

		/**
		 * Handle a panel area request
		 */

		private function handlePanelArea() {

			# Check auth

			if (!Auth::isLogged() || ((false !== Request::get('logout')) && Auth::logout())) {

				Request::redirect(INSTALL_PATH . '/admin/login');
			}

			# Handle request

			$request = (!Request::isSpecial('navigate') ? 'display' : 'navigate');

			$result = $this->handle(Request::isAjax() && ($request === 'display'));

			if (Template::isBlock($result)) return (new View\Panel($this->_title))->$request($result);

			if (Ajax::isResponse($result)) return Ajax::output($result);

			# ------------------------

			return Status::displayError404();
		}

		/**
		 * The branch method for the admin section
		 */

		protected function _section() {

			# Check for restricted access

			if ('' !== CONFIG_ADMIN_IP) {

				$ips = preg_split('/ +/', CONFIG_ADMIN_IP, -1, PREG_SPLIT_NO_EMPTY);

				if (!in_array(REQUEST_CLIENT_IP, $ips, true)) return Status::displayError404();
			}

			# Handle request

			if (($this instanceof Area\Auth) || ($this instanceof Area\Install)) return $this->handleFormArea();

			if ($this instanceof Area\Panel) return $this->handlePanelArea();

			# ------------------------

			return Status::displayError404();
		}
	}
}
