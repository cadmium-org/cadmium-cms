<?php

namespace Modules\Entitizer\Utils\Definition\Group {

	use Modules\Entitizer\Utils\Definition;

	class Params extends Definition\Group {

		private $secure = [];

		private $types = [

			'boolean' => 'Modules\Entitizer\Utils\Definition\Item\Param\Type\Boolean',
			'integer' => 'Modules\Entitizer\Utils\Definition\Item\Param\Type\Integer',
			'textual' => 'Modules\Entitizer\Utils\Definition\Item\Param\Type\Textual'
		];

		# Add param

		private function add(string $type, string $name, array $args) {

			if (('' === $name) || isset($this->list[$name])) return;

			$this->list[$name] = new $this->types[$type](...$args);

			if (($type !== 'textual') || $this->list[$name]->short) $this->secure[] = $name;
		}

		# Constructor

		public function __construct(Definition $definition, bool $auto_increment) {

			parent::__construct($definition);

			$this->list['id'] = new Definition\Item\Param\Id($auto_increment);

			$this->secure[] = 'id';
		}

		# Add boolean param

		public function boolean(string $name, bool $default = false) {

			$this->add('boolean', $name, func_get_args());
		}

		# Add integer param

		public function integer(string $name, bool $short = false, int $length = 0, bool $unsigned = false, int $default = 0) {

			$this->add('integer', $name, func_get_args());
		}

		# Add textual param

		public function textual(string $name, bool $short = true, int $length = 0, bool $binary = false, string $default = '') {

			$this->add('textual', $name, func_get_args());
		}

		# Return secure params list

		public function secure() {

			return $this->secure;
		}
	}
}
