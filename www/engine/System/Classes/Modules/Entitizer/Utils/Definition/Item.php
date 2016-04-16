<?php

namespace Modules\Entitizer\Utils\Definition {

	abstract class Item {

		protected $name = '';

		# Getter

		public function __get(string $property) {

			return ($this->$property ?? null);
		}
	}
}
