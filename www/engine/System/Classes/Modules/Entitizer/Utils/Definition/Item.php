<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition {

	abstract class Item {

		protected $name = '';

		/**
		 * Get a property
		 */

		public function __get(string $property) {

			return ($this->$property ?? null);
		}

		/**
		 * Check if a property exists
		 */

		public function __isset(string $property) : bool {

			return isset($this->$property);
		}
	}
}
