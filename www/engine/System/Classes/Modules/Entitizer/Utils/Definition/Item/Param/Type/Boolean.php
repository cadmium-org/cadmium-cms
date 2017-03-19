<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Item\Param\Type {

	use Modules\Entitizer\Utils\Definition;

	class Boolean extends Definition\Item\Param {

		protected $default = false;

		/**
		 * Constructor
		 */

		public function __construct(string $name, bool $default = false) {

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		/**
		 * Get the statement
		 */

		public function getStatement() : string {

			return ("`" . $this->name . "` tinyint(1) UNSIGNED NOT NULL DEFAULT '" . intval($this->default) . "'");
		}

		/**
		 * Cast a value to a param type
		 *
		 * @return bool : the formatted value or the default value if the value can not be casted
		 */

		public function cast($value = null) : bool {

			return (((null !== $value) && is_scalar($value)) ? boolval($value) : $this->default);
		}
	}
}
