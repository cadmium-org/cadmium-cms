<?php

namespace System\Frames\Site {

	use System, System\Frames\Status;
	use System\Modules\Auth, System\Modules\Config, System\Modules\Extend, System\Utils\Menu, System\Utils\Messages, System\Utils\View;
	use Date, Request, Template;

	abstract class Section extends System\Frames\Section {

		# Define active section

		const SECTION = SECTION_SITE;

		# Define phrases list (change to constant in PHP 5.6+)

		protected static $phrases = ['Common', 'Lister', 'Mail', 'Site', 'User'];

		# Section settings

		protected $title = '', $layout = 'Common';

		protected $description = '', $keywords = '', $robots_index = false, $robots_follow = false, $canonical = '';

		# Get layout

		private function getLayout(Template\Utils\Settable $contents) {

			$layout = View::get('Layouts\\' . $this->layout);

			# Create layout components

			$menu = new Menu();

			# Set menu

			$layout->menu = $menu->block();

			# Set auth

			if (Config::get('users_registration')) {

				if (!Auth::check()) $layout->block('auth')->enable(); else {

					$layout->block('user')->enable();

					$layout->block('user')->gravatar = md5(strtolower(Auth::user()->email));

					$layout->block('user')->name = Auth::user()->name;

					if (Auth::user()->rank === RANK_ADMINISTRATOR) $layout->block('user')->block('admin')->enable();
				}
			}

			# Set title

			$layout->title = (('' !== $this->title) ? $this->title : Config::get('site_title'));

			# Set messages

			$layout->messages = Messages::block();

			# Set contents

			$layout->contents = $contents;

			# Set footer

			$layout->system_url = Config::get('system_url');

			$layout->site_title = Config::get('site_title');

			$layout->copyright = Date::year();

			# ------------------------

			return $layout;
		}

		# Display page

		private function displayPage(Template\Utils\Settable $contents) {

			# Process template

			$page = View::get('Main\Page');

			# Set language

			$page->language = Extend\Languages::data('iso');

			# Set title

			$page->title = ((('' !== $this->title) ? ($this->title . ' | ') : '') . Config::get('site_title'));

			# Set SEO data

			$page->description = ('' !== $this->description) ? $this->description : Config::get('site_description');

			$page->keywords = ('' !== $this->keywords) ? $this->keywords : Config::get('site_keywords');

			$page->robots = (($this->robots_index ? 'INDEX' : 'NOINDEX') . ',' . ($this->robots_follow ? 'FOLLOW' : 'NOFOLLOW'));

			# Set canonical

			if ('' === $this->canonical) $page->block('canonical')->disable();

			else $page->block('canonical')->link = (Config::get('system_url') . $this->canonical);

			# Set layout

			$page->layout = $this->getLayout($contents);

			# ------------------------

			Template::output($page, true, STATUS_CODE_200);
		}

		# Site main method

		protected function section() {

			# Display status screen

			if (Config::get('site_status') === STATUS_MAINTENANCE) return Status::maintenance();

			if (Config::get('site_status') === STATUS_UPDATE) return Status::update();

			# Handle request

			if ($this instanceof Component\Profile) {

				if (!Config::get('users_registration')) return Status::error404();

				if (($this instanceof Component\Profile\Auth)) { if (Auth::check()) Request::redirect('/profile'); }

				else if (!Auth::check()) Request::redirect('/profile/login');
			}

			return (Template::isSettable($result = $this->handle()) ? $this->displayPage($result) : Status::error404());
		}
	}
}
