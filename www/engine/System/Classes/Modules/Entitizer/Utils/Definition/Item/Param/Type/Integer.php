<?php

namespace Modules\Entitizer\Utils\Definition\Item\Param\Type {

	use Modules\Entitizer\Utils\Definition;

	class Integer extends Definition\Item\Param {

		protected $short = false, $length = 0, $unsigned = false, $default = 0;

		# Constructor

		public function __construct(string $name, bool $short = false, int $length = 0, bool $unsigned = false, int $default = 0) {

			# Set configuration

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		# Get statement

		public function statement() {

			return ("`" . $this->name . "` " . ($this->short ? "tiny" : "") . "int(" . $this->length . ")") .

			       (($this->unsigned ? " UNSIGNED" : "") . " NOT NULL DEFAULT '" . $this->default . "'");
		}

		# Cast value

		public function cast($value = null) {

			return (((null !== $value) && is_scalar($value)) ? intval($value) : $this->default);
		}
	}
}
