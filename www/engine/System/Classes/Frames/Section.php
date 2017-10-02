<?php

/**
 * @package Cadmium\System\Frames
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames {

	use Modules\Auth, Modules\Extend, Modules\Settings;
	use Utils\Messages, Utils\Popup, Utils\SEO, Utils\View, Date, Language, Template;

	abstract class Section extends Main {

		# Active section interface

		const SECTION = '';

		# Phrases list interface

		const PHRASES = [];

		/**
		 * Load language phrases
		 */

		private function loadPhrases() {

			$languages = [Extend\Languages::getPrimary('path'), Extend\Languages::get('path')]; $phrases = static::PHRASES;

			if (Extend\Addons::isInited()) $phrases = array_merge($phrases, array_keys(Extend\Addons::getItems()));

			foreach (array_unique($languages) as $path) foreach ($phrases as $name) {

				Language::load($path . 'Phrases/' . $name . '.php');
			}
		}

		/**
		 * Set template globals
		 */

		private function setGlobals() {

			Template::setGlobal('cadmium_home',         CADMIUM_HOME);
			Template::setGlobal('cadmium_copy',         CADMIUM_COPY);
			Template::setGlobal('cadmium_name',         CADMIUM_NAME);
			Template::setGlobal('cadmium_version',      CADMIUM_VERSION);

			Template::setGlobal('template_name',        strtolower(Extend\Templates::get('name')));

			Template::setGlobal('site_title',           Settings::get('site_title'));
			Template::setGlobal('site_slogan',          Settings::get('site_slogan'));

			Template::setGlobal('system_url',           Settings::get('system_url'));
			Template::setGlobal('system_email',         Settings::get('system_email'));

			Template::setGlobal('install_path',         INSTALL_PATH);

			Template::setGlobal('index_page',           (('' !== INSTALL_PATH) ? INSTALL_PATH : '/'));

			Template::setGlobal('current_year',         Date::getYear());
		}

		/**
		 * The branch method for sections
		 */

		protected function _main() {

			# Init extensions

			Extend\Languages::init(static::SECTION);

			Extend\Templates::init(static::SECTION);

			# Process language and template

			$this->loadPhrases(); $this->setGlobals();

			# Init auth

			Auth::init(static::SECTION);

			# Set timezone

			if (Auth::isLogged() && ('' !== ($timezone = Auth::get('timezone')))) date_default_timezone_set($timezone);

			# Init utils

			View::init(); SEO::init(); Messages::init(); Popup::init();

			# ------------------------

			$this->_section();
		}

		/**
		 * The interface for a section branch method
		 */

		abstract protected function _section();

		/**
		 * The interface for a handler method
		 *
		 * @return Template\Block|Ajax\Response|null : a template block or an ajax response on success or null on failure
		 */

		abstract protected function handle();
	}
}
