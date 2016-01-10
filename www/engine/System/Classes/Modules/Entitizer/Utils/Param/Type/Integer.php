<?php

namespace Modules\Entitizer\Utils\Param\Type {

	use Modules\Entitizer;

	class Integer extends Entitizer\Utils\Param {

		protected $short = false, $maxlength = 0, $default = 0;

		# Constructor

		public function __construct(string $name, bool $short = false, int $maxlength = 0,

			int $default = 0, bool $index = false, bool $unique = false) {

			# Set field configuration

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		# Get field statement

		public function fieldStatement() {

			return ("`" . $this->name . "` " . ($this->short ? "tiny" : "") . "int(" . $this->maxlength . ") ") .

			       ("unsigned NOT NULL DEFAULT '" . $this->default . "'");
		}

		# Cast value

		public function cast($value = null) {

			return (((null !== $value) && is_scalar($value)) ? intval($value) : $this->default);
		}
	}
}
