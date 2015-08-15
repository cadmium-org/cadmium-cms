<?php

namespace System\Frames\Admin {

	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Extend;
	use System\Utils\Messages, System\Utils\Status, System\Utils\View;
	use DB, Debug, Request, Template;

	abstract class Handler extends System\Frames\Main {

		private $title = '', $contents = '';

		# Display install

		private function displayForm() {

			# Process template

			Template::main(View::get('Main/Form'));

			Template::title(('' === $this->title) ? CADMIUM_NAME : ($this->title . ' | ' . CADMIUM_NAME));

			# Set messages

			Template::main()->messages = Messages::block();

			# Set contents

			Template::main()->contents = $this->contents;

			# ------------------------

			Template::output(STATUS_CODE_200, true);
		}

		# Display page

		private function displayPage() {

			# Process template

			Template::main(View::get('Main/Page'));

			Template::title(('' === $this->title) ? CADMIUM_NAME : ($this->title . ' | ' . CADMIUM_NAME));

			# Set menu

			Template::main()->menu = View::get('Blocks/Menu');

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

			Template::main()->cadmium_home          = CADMIUM_HOME;
			Template::main()->cadmium_copy          = CADMIUM_COPY;
			Template::main()->cadmium_name          = CADMIUM_NAME;
			Template::main()->cadmium_version       = CADMIUM_VERSION;

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

			$this->title = strval($title);
		}

		# Set contents

		protected function setContents($contents) {

			if (Template::settable($contents)) $this->contents = $contents;
		}

		# Admin main method

		protected function main() {

			# Check for restricted access

			if (('' !== CONFIG_ADMIN_IP) && (false !== stripos(ENGINE_CLIENT_IP, CONFIG_ADMIN_IP))) return Status::error404();

			# Handle request

			if ($this instanceof Component\Install) {

				return ((method_exists($this, 'handle') && $this->handle()) ? $this->displayForm() : Status::error404());
			}

			if ($this instanceof Component\Auth) {

				if (Auth::check()) return Request::redirect('/admin');

				return ((method_exists($this, 'handle') && $this->handle()) ? $this->displayForm() : Status::error404());
			}

			if (!Auth::check()) return Request::redirect('/admin/login');

			if (Request::isAjax() && method_exists($this, 'handleAjax')) return Ajax::output($this->handleAjax());

			return ((method_exists($this, 'handle') && $this->handle()) ? $this->displayPage() : Status::error404());
		}
	}
}
