<?php

namespace Schemas\Prototype {

	use Utils\Schema;

	class Language extends Schema\_Object {

		# Constructor

		public function __construct() {

			$this->addString('name');
			$this->addString('iso');
			$this->addString('country');
			$this->addString('title');
			$this->addString('author');
		}
	}
}
