<?php

/**
 * @package Cadmium\System\Schemas
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Schemas\Prototype {

	use Utils\Schema;

	class Addon extends Schema\_Object {

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addString('name');
			$this->addString('title');
			$this->addString('description');
			$this->addString('version');
			$this->addString('author');
			$this->addString('website');
			$this->addString('browse_url');

			$routes = $this->addArray('routes');

			$routes->addString('path');
			$routes->addString('handler');
		}
	}
}
