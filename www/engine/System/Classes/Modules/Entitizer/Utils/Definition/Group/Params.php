<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Group {

	use Modules\Entitizer\Utils\Definition;

	class Params extends Definition\Group {

		private $secure = [];

		private $types = [

			'boolean' => 'Modules\Entitizer\Utils\Definition\Item\Param\Type\Boolean',
			'integer' => 'Modules\Entitizer\Utils\Definition\Item\Param\Type\Integer',
			'textual' => 'Modules\Entitizer\Utils\Definition\Item\Param\Type\Textual'
		];

		/**
		 * Add a param
		 */

		private function add(string $type, string $name, array $args) {

			if (('' === $name) || isset($this->list[$name])) return;

			$this->list[$name] = new $this->types[$type](...$args);

			if (($type !== 'textual') || $this->list[$name]->short) $this->secure[] = $name;
		}

		/**
		 * Constructor
		 */

		public function __construct(Definition $definition, bool $auto_increment) {

			parent::__construct($definition);

			$this->list['id'] = new Definition\Item\Param\Id($auto_increment);

			$this->secure[] = 'id';
		}

		/**
		 * Add a boolean param
		 */

		public function addBoolean(string $name, bool $default = false) {

			$this->add('boolean', $name, func_get_args());
		}

		/**
		 * Add an integer param
		 */

		public function addInteger(string $name, bool $short = false, int $length = 0, bool $unsigned = false, int $default = 0) {

			$this->add('integer', $name, func_get_args());
		}

		/**
		 * Add a textual param
		 */

		public function addTextual(string $name, bool $short = true, int $length = 0, bool $binary = false, string $default = '') {

			$this->add('textual', $name, func_get_args());
		}

		/**
		 * Get the secure params list (includes every param except of long textuals)
		 */

		public function getSecure() : array {

			return $this->secure;
		}
	}
}
