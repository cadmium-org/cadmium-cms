<?php

namespace Modules\Entitizer\Utils\Definition\Group {

	use Modules\Entitizer\Utils\Definition;

	class Indexes extends Definition\Group {

		# Constructor

		public function __construct(Definition $definition) {

			parent::__construct($definition);

			$this->list['id'] = new Definition\Item\Index('id', 'PRIMARY');
		}

		# Add index

		public function add(string $name, string $type = null) {

			if (!isset($this->definition->params()[$name]) || isset($this->list[$name])) return;

			$this->list[$name] = new Definition\Item\Index($name, $type);
		}
	}
}
