<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer, Number;

	class Textual extends Entitizer\Utils\Param {

		protected $short = true, $maxlength = 255, $binary = false;

		# Constructor

		public function __construct(string $name, bool $short = true, int $maxlength = 0,

			bool $binary = false, bool $index = false, bool $unique = false) {

			# Set field configuration

			$this->name = $name; $this->short = $short; $this->maxlength = $maxlength;

			$this->binary = $binary; $this->index = $index; $this->unique = $unique;
		}

		# Get field statement

		public function fieldStatement() {

			return ("`" . $this->name . "` " . ($this->short ? ("varchar(" . $this->maxlength . ")") : "text")) .

			       (($this->binary ? " CHARACTER SET utf8 COLLATE utf8_bin" : "") . " NOT NULL");
		}

		# Cast value

		public function cast($value = null) {

			return ((($value !== null) && is_scalar($value)) ? strval($value) : '');
		}
	}
}
