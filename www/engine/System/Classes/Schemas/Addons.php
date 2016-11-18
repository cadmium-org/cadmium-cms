<?php

namespace Schemas {

	use Utils\Schema;

	class Addons extends Schema\_Array {

		protected static $file_name = 'Addons.json';

		# Constructor

		public function __construct() {

			$this->addString('name');

			$routes = $this->addArray('routes');

			$routes->addString('path');
			$routes->addString('handler');
		}
	}
}
