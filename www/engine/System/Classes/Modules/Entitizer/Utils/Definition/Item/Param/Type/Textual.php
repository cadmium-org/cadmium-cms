<?php

namespace Modules\Entitizer\Utils\Definition\Item\Param\Type {

	use Modules\Entitizer\Utils\Definition;

	class Textual extends Definition\Item\Param {

		protected $short = true, $length = 0, $binary = false, $default = '';

		# Constructor

		public function __construct(string $name, bool $short = true, int $length = 0, bool $binary = false, string $default = '') {

			# Set configuration

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		# Get statement

		public function statement() {

			return ("`" . $this->name . "` " . ($this->short ? ("varchar(" . $this->length . ")") : "text")) .

			       (($this->binary ? " BINARY" : "") . " NOT NULL DEFAULT '" . $this->default . "'");
		}

		# Cast value

		public function cast($value = null) {

			return (((null !== $value) && is_scalar($value)) ? strval($value) : $this->default);
		}
	}
}
