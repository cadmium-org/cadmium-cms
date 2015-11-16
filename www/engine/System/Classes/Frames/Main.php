<?php

namespace System\Frames {

	use System\Modules\Settings, Session, Url;

	abstract class Main {

		protected $url = null;

		# Constructor

		public function __construct(Url $url = null) {

			$this->url = $url;

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
