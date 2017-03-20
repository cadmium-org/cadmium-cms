<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Item {

	use Modules\Entitizer\Utils\Definition;

	class Index extends Definition\Item {

		protected $type = null;

		/**
		 * Validate a type value
		 *
		 * @return string|null : the type or null if the value is invalid
		 */

		private function validateType(string $value) {

			$value = strtoupper($value); $range = ['PRIMARY', 'UNIQUE', 'FULLTEXT'];

			return (in_array($value, $range, true) ? $value : null);
		}

		/**
		 * Constructor
		 */

		public function __construct(string $name, string $type = null) {

			$this->name = $name;

			if (null !== $type) $this->type = $this->validateType($type);
		}

		/**
		 * Get the statement
		 */

		public function getStatement() : string {

			return ((null !== $this->type) ? ($this->type . " ") : "") .

			       ("KEY `" . $this->name . "` (`" . $this->name . "`)");
		}
	}
}
