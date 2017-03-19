<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Item\Param {

	use Modules\Entitizer\Utils\Definition;

	class Id extends Definition\Item\Param {

		protected $auto_increment = true;

		/**
		 * Constructor
		 */

		public function __construct(bool $auto_increment = true) {

			$this->name = 'id'; $this->auto_increment = $auto_increment;
		}

		/**
		 * Get the statement
		 */

		public function getStatement() : string {

			return ("`" . $this->name . "` int(10) UNSIGNED NOT NULL" . ($this->auto_increment ? " AUTO_INCREMENT" : ""));
		}

		/**
		 * Cast a value to a param type
		 *
		 * @return int : the formatted value or 0 if the value can not be casted
		 */

		public function cast($value = null) : int {

			return (((null !== $value) && is_scalar($value) && (($value = intval($value)) >= 0)) ? $value : 0);
		}
	}
}
