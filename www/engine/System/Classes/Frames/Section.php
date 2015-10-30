<?php

namespace System\Frames {

	use System\Modules\Auth, System\Modules\Extend, System\Utils\Messages, System\Utils\View, Language, Template;

	abstract class Section extends Main {

		# Active section interface

		const SECTION = '';

		# Phrases list interface (change to constant in PHP 5.6+)

		protected static $phrases = [];

		# Constructor

		public function main() {

			# Init auth

			Auth::init(static::SECTION);

			# Init extensions

			Extend\Languages::init(static::SECTION);

			Extend\Templates::init(static::SECTION);

			# Load primary language phrases

			foreach (static::$phrases as $name) {

				Language::load(Extend\Languages::pathPrimary() . 'Phrases/' . $name . '.php');
			}

			# Load active language phrases

			if (Extend\Languages::active() !== Extend\Languages::primary()) {

				foreach (static::$phrases as $name) {

					Language::load(Extend\Languages::path() . 'Phrases/' . $name . '.php');
				}
			}

			# Set template globals

			Template::set('install_path', INSTALL_PATH);

			Template::set('template_name', strtolower(Extend\Templates::active()));

			# Init utils

			View::init(static::SECTION); Messages::init();

			# Set timezone

			if (Auth::check() && ('' !== ($timezone = Auth::user()->timezone))) date_default_timezone_set($timezone);

			# ------------------------

			$this->section();
		}

		# Section method interface

		abstract protected function section();

		# Handler interface

		abstract protected function handle();
	}
}
