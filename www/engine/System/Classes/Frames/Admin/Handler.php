<?php

namespace System\Frames\Admin {

	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Extend, System\Utils\Messages;
	use Date, DB, Debug, Language, Request, String, Template;

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

		# Display install

		private function displayInstall() {

			# Process template

			Template::main('Install');

			Template::title((false === $this->title) ? CADMIUM_NAME : ($this->title . ' | ' . CADMIUM_NAME));

			# Set messages

			Template::main()->messages = Messages::block();

			# Set contents

			Template::main()->contents = $this->contents;

			# ------------------------

			Template::output(STATUS_CODE_200, true);
		}

		# Display auth

		private function displayAuth() {

			# Process template

			Template::main('Auth');

			Template::title((false === $this->title) ? CADMIUM_NAME : ($this->title . ' | ' . CADMIUM_NAME));

			# Set messages

			Template::main()->messages = Messages::block();

			# Set contents

			Template::main()->contents = $this->contents;

			# ------------------------

			Template::output(STATUS_CODE_401, true);
		}

		# Display page

		private function displayPage() {

			# Process template

			Template::main('Page');

			Template::title((false === $this->title) ? CADMIUM_NAME : ($this->title . ' | ' . CADMIUM_NAME));

			# Set menu

			Template::main()->menu = Template::block('Menu');

			# Set user

			Template::main()->block('user')->gravatar = md5(strtolower(Auth::user()->email));

			Template::main()->block('user')->name = Auth::user()->name;

			Template::main()->block('user')->id = Auth::user()->id;

			# Set title

			Template::main()->title = $this->title;

			# Set messages

			Template::main()->messages = Messages::block();

			# Set contents

			Template::main()->contents = $this->contents;

			# Set footer

			Template::main()->cadmium_home			= CADMIUM_HOME;
			Template::main()->cadmium_copy			= CADMIUM_COPY;
			Template::main()->cadmium_name			= CADMIUM_NAME;
			Template::main()->cadmium_version		= CADMIUM_VERSION;

			# Set language selector

			Template::main()->block('language')->country = Extend\Languages::data('country');

			Template::main()->block('language')->title = Extend\Languages::data('title');

			Template::main()->block('language')->items = Extend\Languages::items();

			# Set template selector

			Template::main()->block('template')->title = Extend\Templates::data('title');

			Template::main()->block('template')->items = Extend\Templates::items();

			# Set report

			Template::main()->block('report')->script_time = Debug::time();

			Template::main()->block('report')->db_time = DB::time();

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

		# Admin main method

		protected function main() {

			# Check for restricted access

			if (('' !== CONFIG_ADMIN_IP) && (false !== stripos(ENGINE_CLIENT_IP, CONFIG_ADMIN_IP))) return $this->display404();

			# Handle request

			if (0 === strpos(get_class($this), 'System\\Handlers\\Admin\\Install')) {

				return ((method_exists($this, 'handle') && $this->handle()) ? $this->displayInstall() : $this->display404());
			}

			if (0 === strpos(get_class($this), 'System\\Handlers\\Admin\\Auth')) {

				if (Auth::check()) return Request::redirect('/admin');

				DB::select(TABLE_USERS, 'id', array('id' => 1), false, 1);

				if (!(DB::last() && DB::last()->status)) return $this->display404();

				$extra_registration = (DB::last()->rows === 0);

				if ($this instanceof System\Handlers\Admin\Auth\Register) {

					if (!$extra_registration) return Request::redirect('/admin/login');

				} else if ($extra_registration) return Request::redirect('/admin/register');

				return ((method_exists($this, 'handle') && $this->handle()) ? $this->displayAuth() : $this->display404());
			}

			if (0 === strpos(get_class($this), 'System\\Handlers\\Admin')) {

				if (!Auth::check()) return Request::redirect('/admin/login');

				if (Request::isAjax() && method_exists($this, 'handleAjax')) return Ajax::output($this->handleAjax());

				return ((method_exists($this, 'handle') && $this->handle()) ? $this->displayPage() : $this->display404());
			}
		}
	}
}
