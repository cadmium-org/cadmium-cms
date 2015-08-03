<?php

namespace System\Frames\Site {

	use System, System\Utils\Auth, System\Utils\Menu, System\Utils\Messages, System\Utils\Status;
	use Date, Request, Template;

	abstract class Handler extends System\Frames\Main {

		private $title = '', $contents = '';

		# Display site page

		private function displayPage() {

			$menu = new Menu();

			# Process template

			Template::main('Page');

			Template::title(('' === $this->title) ? CONFIG_SITE_TITLE : ($this->title . ' | ' . CONFIG_SITE_TITLE));

			# Set menu

			Template::main()->menu = $menu->block();

			# Set auth

			if (!Auth::check()) { if (CONFIG_USERS_REGISTRATION) Template::main()->block('auth')->enable(); } else {

				Template::main()->block('user')->enable();

				Template::main()->block('user')->gravatar = md5(strtolower(Auth::user()->email));

				Template::main()->block('user')->name = Auth::user()->name;

				if (Auth::user()->rank === RANK_ADMINISTRATOR) Template::main()->block('user')->block('admin')->enable();
			}

			# Set title

			Template::main()->title = (('' === $this->title) ? CONFIG_SITE_TITLE : $this->title);

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

			$this->title = strval($title);
		}

		# Set contents

		protected function setContents($contents) {

			if (Template::settable($contents)) $this->contents = $contents;
		}

		# Site main method

		protected function main() {

			# Display status screen

			if (CONFIG_SITE_STATUS === STATUS_MAINTENANCE) return Status::maintenance();

			if (CONFIG_SITE_STATUS === STATUS_UPDATE) return Status::update();

			# Handle request

			if (0 === strpos(get_class($this), 'System\\Handlers\\Profile\\Auth')) {

				if (!CONFIG_USERS_REGISTRATION) return Status::error404();

				if (Auth::check()) return Request::redirect('/profile');

			} else if (0 === strpos(get_class($this), 'System\\Handlers\\Profile')) {

				if (!Auth::check()) Request::redirect('/profile/login');
			}

			return ($this->handle() ? $this->displayPage() : Status::error404());
		}
	}
}
