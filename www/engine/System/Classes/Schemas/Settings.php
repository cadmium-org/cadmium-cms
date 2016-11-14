<?php

namespace Schemas {

	use Utils\Schema;

	class Settings extends Schema\_Object {

		protected static $file_name = 'Settings.json';

		# Constructor

		public function __construct() {

			$this->addString('admin_language');
			$this->addString('admin_template');

			$this->addString('site_language');
			$this->addString('site_template');

			$this->addString('site_title');
			$this->addString('site_slogan');

			$this->addString('site_status');

			$this->addString('site_description');
			$this->addString('site_keywords');

			$this->addString('system_url');
			$this->addString('system_email');
			$this->addString('system_timezone');
		}
	}
}
