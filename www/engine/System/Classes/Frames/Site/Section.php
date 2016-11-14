<?php

namespace Frames\Site {

	use Frames, Frames\Status, Modules\Auth, Modules\Extend, Modules\Settings, Utils\Menu, Utils\Messages;
	use Utils\SEO, Utils\Template\Variables, Utils\Template\Widgets, Utils\View, Date, Language, Template;

	abstract class Section extends Frames\Section {

		# Define active section

		const SECTION = SECTION_SITE;

		# Define phrases list

		const PHRASES = ['Common', 'Mail', 'Range', 'Site', 'User'];

		# Page settings

		protected $title = '', $layout = 'Common';

		# Get layout

		private function getLayout(Template\Block $contents) {

			$layout = View::get('Layouts/' . $this->layout);

			# Create layout components

			$menu = new Menu;

			# Set menu

			$layout->menu = $menu->block();

			# Set auth

			if (Auth::check()) {

				$layout->getBlock('user')->enable();

				$layout->getBlock('user')->gravatar = Auth::user()->gravatar;;

				$layout->getBlock('user')->name = Auth::user()->name;

				$layout->getBlock('auth')->disable();

				if (Auth::user()->rank === RANK_ADMINISTRATOR) $layout->getBlock('admin')->enable();
			}

			# Set title

			$layout->title = (('' !== SEO::title()) ? SEO::title() :

				(('' !== $this->title) ? Language::get($this->title) : Settings::get('site_title')));

			# Set slogan

			$layout->slogan = Settings::get('site_slogan');

			# Set contents

			$layout->contents = $contents;

			# Set copyright

			$layout->copyright = Date::getYear();

			# Set powered by

			$layout->cadmium_home       = CADMIUM_HOME;
			$layout->cadmium_name       = CADMIUM_NAME;
			$layout->cadmium_version    = CADMIUM_VERSION;

			# ------------------------

			return $layout;
		}

		# Display page

		protected function displayPage(Template\Block $contents, int $status = STATUS_CODE_200) {

			# Process template

			$page = View::get('Main/Page');

			# Set language

			$page->language = Extend\Languages::data('iso');

			# Set SEO data

			$page->description = ('' !== SEO::description()) ? SEO::description() : Settings::get('site_description');

			$page->keywords = ('' !== SEO::keywords()) ? SEO::keywords() : Settings::get('site_keywords');

			$page->robots = ((SEO::robotsIndex() ? 'INDEX' : 'NOINDEX') . ',' . (SEO::robotsFollow() ? 'FOLLOW' : 'NOFOLLOW'));

			# Set title

			$page->title = (('' !== SEO::title()) ? SEO::title() :

				((('' !== $this->title) ? (Language::get($this->title) . ' | ') : '') . Settings::get('site_title')));

			# Set canonical

			if ('' === SEO::canonical()) $page->getBlock('canonical')->disable();

			else $page->getBlock('canonical')->link = SEO::canonical();

			# Set layout

			$page->layout = $this->getLayout($contents);

			# Set messages

			$contents->messages = Messages::block();

			# Set global components

			foreach (Variables::generate() as $name => $value) Template::setGlobal($name, $value);

			foreach (Widgets::generate() as $name => $block) Template::setWidget($name, $block);

			# ------------------------

			Template::output($page, $status);
		}

		# Site main method

		protected function section() {

			# Check site status

			if (Settings::get('site_status') === STATUS_MAINTENANCE) return Status::maintenance();

			if (Settings::get('site_status') === STATUS_UPDATE) return Status::update();

			# ------------------------

			$this->area();
		}
	}
}
