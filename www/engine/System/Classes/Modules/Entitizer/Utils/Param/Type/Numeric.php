<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer, Number;

	class Numeric extends Entitizer\Utils\Param {

		protected $short = false, $maxlength = 0, $default = 0;

		# Constructor

		public function __construct(string $name, bool $short = false, int $maxlength = 0,

			int $default = 0, bool $index = false, bool $unique = false) {

			# Set field configuration

			$this->name = $name; $this->short = $short; $this->maxlength = $maxlength;

			$this->default = $default; $this->index = $index; $this->unique = $unique;
		}

		# Get field statement

		public function fieldStatement() {

			return ("`" . $this->name . "` " . ($this->short ? "tiny" : "") . "int(" . $this->maxlength . ") ") .

			       ("unsigned NOT NULL DEFAULT '" . $this->default . "'");
		}

		# Cast value

		public function cast($value = null) {

			return ((($value !== null) && is_numeric($value)) ? intval($value) : $this->default);
		}
	}
}
