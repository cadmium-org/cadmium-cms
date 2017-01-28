<?php

/**
 * @package Cadmium\System\Schemas
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Schemas {

	use Utils\Schema;

	class Addons extends Schema\_Array {

		protected static $file_name = 'Addons.json';

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addString('name');

			$routes = $this->addArray('routes');

			$routes->addString('path');
			$routes->addString('handler');
		}
	}
}
