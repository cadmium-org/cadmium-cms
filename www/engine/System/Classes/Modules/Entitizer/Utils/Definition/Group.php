<?php

namespace Modules\Entitizer\Utils\Definition {

	use Modules\Entitizer\Utils\Definition;

	abstract class Group {

		protected $definition = null, $list = [];

		# Constructor

		public function __construct(Definition $definition) {

			$this->definition = $definition;
		}

		# Get item

		public function get(string $name) {

			return ($this->list[$name] ?? false);
		}

		# Return list

		public function list() {

			return $this->list;
		}
	}
}
