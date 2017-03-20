<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Item\Param\Type {

	use Modules\Entitizer\Utils\Definition;

	class Integer extends Definition\Item\Param {

		protected $short = false, $length = 0, $unsigned = false, $default = 0;

		/**
		 * Constructor
		 */

		public function __construct(string $name, bool $short = false, int $length = 0, bool $unsigned = false, int $default = 0) {

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		/**
		 * Get the statement
		 */

		public function getStatement() : string {

			return ("`" . $this->name . "` " . ($this->short ? "tiny" : "") . "int(" . $this->length . ")") .

			       (($this->unsigned ? " UNSIGNED" : "") . " NOT NULL DEFAULT '" . $this->default . "'");
		}

		/**
		 * Cast a value to a param type
		 *
		 * @return int : the formatted value or the default value if the value can not be casted
		 */

		public function cast($value = null) : int {

			return (((null !== $value) && is_scalar($value)) ? intval($value) : $this->default);
		}
	}
}
