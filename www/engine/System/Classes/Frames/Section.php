<?php

namespace Frames {

	use Modules\Auth, Modules\Extend, Modules\Settings, Utils\Messages, Utils\Popup, Utils\View, Language, Template;

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

			foreach (array_unique($languages) as $path) foreach (static::PHRASES as $name) {

				Language::load($path . 'Phrases/' . $name . '.php');
			}

			# Set template globals

			Template::global('template_name', strtolower(Extend\Templates::active()));

			Template::global('site_title', Settings::get('site_title'));

			Template::global('system_url', Settings::get('system_url'));

			Template::global('system_email', Settings::get('system_email'));

			Template::global('install_path', INSTALL_PATH);

			Template::global('index_page', (('' !== INSTALL_PATH) ? INSTALL_PATH : '/'));

			# Init utils

			View::init(static::SECTION); Messages::init(); Popup::init();

			# Set timezone

			if (Auth::check() && ('' !== ($timezone = Auth::user()->timezone))) date_default_timezone_set($timezone);

			# ------------------------

			$this->section();
		}

		# Section interface

		abstract protected function section();

		# Handler interface

		abstract protected function handle();
	}
}
