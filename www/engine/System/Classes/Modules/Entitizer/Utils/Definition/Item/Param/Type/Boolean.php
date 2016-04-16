<?php

namespace Modules\Entitizer\Utils\Definition\Item\Param\Type {

	use Modules\Entitizer\Utils\Definition;

	class Boolean extends Definition\Item\Param {

		protected $default = false;

		# Constructor

		public function __construct(string $name, bool $default = false) {

			# Set configuration

			foreach (get_defined_vars() as $name => $value) $this->$name = $value;
		}

		# Get statement

		public function statement() {

			return ("`" . $this->name . "` tinyint(1) UNSIGNED NOT NULL DEFAULT '" . intval($this->default) . "'");
		}

		# Cast value

		public function cast($value = null) {

			return (((null !== $value) && is_scalar($value)) ? boolval($value) : $this->default);
		}
	}
}
