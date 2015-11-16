<?php

namespace System\Frames\Admin {

	use System, System\Frames\Status;
	use System\Modules\Auth, System\Modules\Extend, System\Utils\Messages, System\Utils\View;
	use Ajax, DB, Debug, Request, Template;

	abstract class Section extends System\Frames\Section {

		# Define active section

		const SECTION = SECTION_ADMIN;

		# Define phrases list

		const PHRASES = ['Admin', 'Ajax', 'Common', 'Install', 'Lister', 'Mail', 'Menuitem', 'Page', 'User'];

		# Section settings

		protected $title = '';

		# Display form

		private function displayForm(Template\Utils\Settable $contents, string $status) {

			$form = View::get('Main\Form');

			# Set language

			$form->language = Extend\Languages::data('iso');

			# Set title

			$form->title = (('' !== $this->title) ? ($this->title . ' | ' . CADMIUM_NAME) : CADMIUM_NAME);

			# Create layout

			$form->layout = ($layout = View::get('Layouts\Form'));

			# Set title

			$layout->title = $this->title;

			# Set messages

			$layout->messages = Messages::block();

			# Set contents

			$layout->contents = $contents;

			# Set report

			$layout->block('report')->script_time = Debug::time();

			$layout->block('report')->db_time = DB::time();

			# ------------------------

			Template::output($form, true, $status);
		}

		# Display page

		private function displayPage(Template\Utils\Settable $contents) {

			$page = View::get('Main\Page');

			# Set language

			$page->language = Extend\Languages::data('iso');

			# Set title

			$page->title = (('' !== $this->title) ? ($this->title . ' | ' . CADMIUM_NAME) : CADMIUM_NAME);

			# Create layout

			$page->layout = ($layout = View::get('Layouts\Page'));

			# Set menu

			$layout->menu = View::get('Blocks\Utils\Menu');

			# Set user

			$layout->block('user')->gravatar = md5(strtolower(Auth::user()->email));

			$layout->block('user')->name = Auth::user()->name;

			$layout->block('user')->id = Auth::user()->id;

			# Set title

			$layout->title = $this->title;

			# Set messages

			$layout->messages = Messages::block();

			# Set contents

			$layout->contents = $contents;

			# Set copyright

			$layout->cadmium_home       = CADMIUM_HOME;
			$layout->cadmium_copy       = CADMIUM_COPY;
			$layout->cadmium_name       = CADMIUM_NAME;
			$layout->cadmium_version    = CADMIUM_VERSION;

			# Set language selector

			$layout->block('language')->country = Extend\Languages::data('country');

			$layout->block('language')->title = Extend\Languages::data('title');

			$layout->block('language')->items = Extend\Languages::items();

			# Set template selector

			$layout->block('template')->title = Extend\Templates::data('title');

			$layout->block('template')->items = Extend\Templates::items();

			# Set report

			$layout->block('report')->script_time = Debug::time();

			$layout->block('report')->db_time = DB::time();

			# ------------------------

			Template::output($page, true, STATUS_CODE_200);
		}

		# Admin main method

		protected function section() {

			# Check for restricted access

			if (('' === CONFIG_ADMIN_IP) || in_array(REQUEST_CLIENT_IP, preg_split('/ +/', CONFIG_ADMIN_IP))) {

				# Handle install component request

				if ($this instanceof Component\Install) {

					if (Template::isSettable($result = $this->handle())) return $this->displayForm($result, STATUS_CODE_200);
				}

				# Handle auth component request

				else if ($this instanceof Component\Auth) {

					if (Auth::check()) Request::redirect(INSTALL_PATH . '/admin');

					if ($this instanceof Component\Auth\Initial) { if (!Auth::initial()) Request::redirect(INSTALL_PATH . '/admin/login'); }

					else if (Auth::initial()) Request::redirect(INSTALL_PATH . '/admin/register');

					if (Template::isSettable($result = $this->handle())) return $this->displayForm($result, STATUS_CODE_401);
				}

				# Handle panel component request

				else if ($this instanceof Component\Panel) {

					if (!Auth::check()) Request::redirect(INSTALL_PATH . '/admin/login');

					if (Template::isSettable($result = $this->handle())) return $this->displayPage($result);

					if (Ajax::isResponse($result)) return Ajax::output($result);
				}
			}

			# ------------------------

			return Status::error404();
		}
	}
}
