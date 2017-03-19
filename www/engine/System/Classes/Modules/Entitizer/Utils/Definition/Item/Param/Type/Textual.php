<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Item\Param\Type {

	use Modules\Entitizer\Utils\Definition;

	class Textual extends Definition\Item\Param {

		protected $short = true, $length = 0, $binary = false, $default = '';

		/**
		 * Constructor
		 */

		public function __construct(string $name, bool $short = true, int $length = 0, bool $binary = false, string $default = '') {

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		/**
		 * Get the statement
		 */

		public function getStatement() : string {

			return ("`" . $this->name . "` " . ($this->short ? ("varchar(" . $this->length . ")") : "text")) .

			       (($this->binary ? " BINARY" : "") . " NOT NULL DEFAULT '" . $this->default . "'");
		}

		/**
		 * Cast a value to a param type
		 *
		 * @return string : the formatted value or the default value if the value can not be casted
		 */

		public function cast($value = null) : string {

			return (((null !== $value) && is_scalar($value)) ? strval($value) : $this->default);
		}
	}
}
