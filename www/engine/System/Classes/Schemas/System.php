<?php

/**
 * @package Cadmium\System\Schemas
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Schemas {

	use Utils\Schema;

	class System extends Schema\_Object {

		protected static $file_name = 'System.json';

		/**
		 * Constructor
		 */

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
