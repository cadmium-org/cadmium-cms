<?php

namespace Frames {

	use Modules\Auth, Modules\Extend, Modules\Settings, Utils\Messages, Utils\Popup, Utils\SEO, Utils\View, Language, Template;

	abstract class Section extends Main {

		# Active section interface

		const SECTION = '';

		# Phrases list interface

		const PHRASES = [];

		# Main method

		public function main() {

			# Init auth

			Auth::init(static::SECTION);

			# Init extensions

			Extend\Languages::init(static::SECTION);

			Extend\Templates::init(static::SECTION);

			# Load language phrases

			$languages = [Extend\Languages::pathPrimary(), Extend\Languages::path()];

			$phrases = array_merge(static::PHRASES, array_keys(Extend\Addons::items() ?? []));

			foreach (array_unique($languages) as $path) foreach ($phrases as $name) {

				Language::load($path . 'Phrases/' . $name . '.php');
			}

			# Set template globals

			Template::setGlobal('template_name',    strtolower(Extend\Templates::active()));

			Template::setGlobal('site_title',       Settings::get('site_title'));

			Template::setGlobal('system_url',       Settings::get('system_url'));

			Template::setGlobal('system_email',     Settings::get('system_email'));

			Template::setGlobal('install_path',     INSTALL_PATH);

			Template::setGlobal('index_page',       (('' !== INSTALL_PATH) ? INSTALL_PATH : '/'));

			# Init utils

			View::init(); SEO::init(); Messages::init(); Popup::init();

			# Set timezone

			if (Auth::check() && ('' !== ($timezone = Auth::user()->timezone))) date_default_timezone_set($timezone);

			# ------------------------

			$this->section();
		}
	}
}
