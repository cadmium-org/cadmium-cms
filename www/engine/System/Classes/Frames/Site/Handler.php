<?php

namespace System\Frames\Site {

	use System, System\Utils\Auth, System\Utils\Menu, System\Utils\Messages, System\Utils\Status;
	use Date, Request, Template;

	abstract class Handler extends System\Frames\Main {

		private $title = '', $layout = 'Common', $contents = '';

		# Display site page

		private function displayPage() {

			$menu = new Menu();

			# Process template

			Template::main('Page');

			Template::title(('' === $this->title) ? CONFIG_SITE_TITLE : ($this->title . ' | ' . CONFIG_SITE_TITLE));

			# Set layout

			Template::main()->layout = ($layout = Template::block($this->layout));

			# Set menu

			$layout->menu = $menu->block();

			# Set auth

			if (Auth::check()) {

				$layout->block('user')->enable();

				$layout->block('user')->gravatar = md5(strtolower(Auth::user()->email));

				$layout->block('user')->name = Auth::user()->name;

				if (Auth::user()->rank === RANK_ADMINISTRATOR) $layout->block('user')->block('admin')->enable();

			} else {

				if (CONFIG_USERS_REGISTRATION) $layout->block('auth')->enable();
			}

			# Set title

			$layout->title = (('' === $this->title) ? CONFIG_SITE_TITLE : $this->title);

			# Set messages

			$layout->messages = Messages::block();

			# Set contents

			$layout->contents = $this->contents;

			# Set footer

			$layout->system_url = CONFIG_SYSTEM_URL;

			$layout->site_title = CONFIG_SITE_TITLE;

			$layout->copyright = Date::year();

			# ------------------------

			Template::output(STATUS_CODE_200, true);
		}

		# Set title

		protected function setTitle($title) {

			$this->title = strval($title);
		}

		# Set layout

		protected function setLayout($layout) {

			$this->layout = strval($layout);
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
