<?php

namespace Modules\Entitizer\Utils\Definition\Group {

	use Modules\Entitizer\Utils\Definition;

	class Foreigns extends Definition\Group {

		# Add foreign

		public function add(string $name, string $table, string $field, string $delete = null, string $update = null) {

			if (!isset($this->definition->params()[$name]) || isset($this->list[$name])) return;

			$this->list[$name] = new Definition\Item\Foreign($name, $table, $field, $delete, $update);
		}
	}
}
