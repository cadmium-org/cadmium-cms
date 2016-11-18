<?php

namespace Frames {

	use Modules\Settings, Session, Url;

	abstract class Main {

		protected $url = null;

		# Constructor

		public function __construct(Url $url = null) {

			$this->url = ($url ?? new Url);

			# Start session

			Session::start(CONFIG_SESSION_NAME, CONFIG_SESSION_LIFETIME);

			# Load settings

			Settings::load();

			# Set timezone

			date_default_timezone_set(Settings::get('system_timezone'));

			# ------------------------

			$this->main();
		}
	}
}
