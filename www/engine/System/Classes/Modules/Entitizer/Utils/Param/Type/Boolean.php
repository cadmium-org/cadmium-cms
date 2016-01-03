<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer;

	class Boolean extends Entitizer\Utils\Param {

		protected $default = false;

		# Constructor

		public function __construct(string $name, bool $default = false, bool $index = false) {

			# Set field configuration

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		# Get field statement

		public function fieldStatement() {

			return ("`" . $this->name . "` tinyint(1) unsigned NOT NULL DEFAULT '" . intval($this->default) . "'");
		}

		# Cast value

		public function cast($value = null) {

			return (((null !== $value) && is_scalar($value)) ? boolval($value) : $this->default);
		}
	}
}
