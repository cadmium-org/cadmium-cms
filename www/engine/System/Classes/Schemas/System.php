<?php

namespace Schemas {

	use Utils\Schema;

	class System extends Schema\_Object {

		protected static $file_name = 'System.json';

		# Constructor

		public function __construct() {

			$database = $this->addObject('database');

			$database->addString('server');
			$database->addString('user');
			$database->addString('password');
			$database->addString('name');

			$this->addInteger('time');
		}
	}
}
