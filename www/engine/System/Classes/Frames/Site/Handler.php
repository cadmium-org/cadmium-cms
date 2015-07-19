<?php

namespace System\Frames\Site {

	use System, System\Utils\Auth, System\Utils\Menu, System\Utils\Messages;
	use Date, Language, Request, String, Template;

	abstract class Handler extends System\Frames\Main {

		private $title = false, $contents = false;

		# Display 404 error

		private function display404() {

			# Process template

			Template::main('404');

			Template::title(Language::get('STATUS_TITLE_404'));

			Template::main()->system_url = CONFIG_SYSTEM_URL;

			Template::main()->site_title = CONFIG_SITE_TITLE;

			Template::main()->copyright = Date::year();

			# ------------------------

			Template::output(STATUS_CODE_404, true);
		}

		# Display maintenance screen

		private function displayMaintenance() {

			# Process template

			Template::main('Maintenance');

			Template::title(Language::get('STATUS_TITLE_MAINTENANCE'));

			Template::main()->system_url = CONFIG_SYSTEM_URL;

			Template::main()->site_title = CONFIG_SITE_TITLE;

			Template::main()->copyright = Date::year();

			# ------------------------

			Template::output(STATUS_CODE_503, true);
		}

		# Display update screen

		private function displayUpdate() {

			# Process template

			Template::main('Update');

			Template::title(Language::get('STATUS_TITLE_UPDATE'));

			Template::main()->system_url = CONFIG_SYSTEM_URL;

			Template::main()->site_title = CONFIG_SITE_TITLE;

			Template::main()->copyright = Date::year();

			# ------------------------

			Template::output(STATUS_CODE_503, true);
		}

		# Display site page

		private function displayPage() {

			$menu = new Menu();

			# Process template

			Template::main('Page');

			Template::title((false === $this->title) ? CONFIG_SITE_TITLE : ($this->title . ' | ' . CONFIG_SITE_TITLE));

			# Set menu

			Template::main()->menu = $menu->block();

			# Set auth

			if (!Auth::check()) { if (CONFIG_USERS_REGISTRATION) Template::main()->block('auth')->enable(); } else {

				Template::main()->block('user')->enable();

				Template::main()->block('user')->gravatar = md5(strtolower(Auth::user()->email()));

				Template::main()->block('user')->name = Auth::user()->name();

				if (Auth::user()->rank() === RANK_ADMINISTRATOR) Template::main()->block('user')->block('admin')->enable();
			}

			# Set title

			Template::main()->title = ((false === $this->title) ? CONFIG_SITE_TITLE : $this->title);

			# Set messages

			Template::main()->messages = Messages::block();

			# Set contents

			Template::main()->contents = $this->contents;

			# Set footer

			Template::main()->system_url = CONFIG_SYSTEM_URL;

			Template::main()->site_title = CONFIG_SITE_TITLE;

			Template::main()->copyright = Date::year();

			# ------------------------

			Template::output(STATUS_CODE_200, true);
		}

		# Set title

		protected function setTitle($title) {

			$this->title = String::validate($title);
		}

		# Set contents

		protected function setContents($contents) {

			if (Template::settable($contents)) $this->contents = $contents;
		}

		# Site main method

		protected function main() {

			# Display status screen

			if (CONFIG_SITE_STATUS === STATUS_MAINTENANCE) return $this->displayMaintenance();

			if (CONFIG_SITE_STATUS === STATUS_UPDATE) return $this->displayUpdate();

			# Handle request

			if (0 === strpos(get_class($this), 'System\\Handlers\\Profile\\Auth')) {

				if (!CONFIG_USERS_REGISTRATION) return $this->display404();

				if (Auth::check()) return Request::redirect('/profile');

			} else if (0 === strpos(get_class($this), 'System\\Handlers\\Profile')) {

				if (!Auth::check()) Request::redirect('/profile/login');
			}

			// if (isset($this->_access) && (Auth::user()->rank() < $this->_access)) Request::redirect('/profile/login');

			return ((method_exists($this, 'handle') && $this->handle()) ? $this->displayPage() : $this->display404());
		}
	}
}

?>
