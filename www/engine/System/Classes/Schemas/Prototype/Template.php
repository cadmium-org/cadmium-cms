<?php

namespace Schemas\Prototype {

	use Utils\Schema;

	class Template extends Schema\_Object {

		# Constructor

		public function __construct() {

			$this->addString('name');
			$this->addString('title');
			$this->addString('author');
		}
	}
}
