<?php

namespace System\Frames {

	use System\Modules\Config, Session;

	abstract class Main {

		protected $path = array();

		# Constructor

		public function __construct(array $path = []) {

			$this->path = $path;

			# Start session

			Session::start(CONFIG_SESSION_NAME, CONFIG_SESSION_LIFETIME);

			# Init configuration

            Config::init();

			# Set timezone

			date_default_timezone_set(Config::get('system_timezone'));

			# ------------------------

			$this->main();
		}
	}
}
