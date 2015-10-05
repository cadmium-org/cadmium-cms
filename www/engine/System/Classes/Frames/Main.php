<?php

namespace System\Frames {

	use System\Modules\Settings, Session;

	abstract class Main {

		protected $path = [];

		# Constructor

		public function __construct(array $path = []) {

			$this->path = $path;

			# Start session

			Session::start(CONFIG_SESSION_NAME, CONFIG_SESSION_LIFETIME);

			# Init configuration

			Settings::init();

			# Set timezone

			date_default_timezone_set(Settings::get('system_timezone'));

			# ------------------------

			$this->main();
		}
	}
}
