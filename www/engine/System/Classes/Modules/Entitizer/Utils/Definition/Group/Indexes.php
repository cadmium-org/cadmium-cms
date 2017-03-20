<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Group {

	use Modules\Entitizer\Utils\Definition;

	class Indexes extends Definition\Group {

		/**
		 * Constructor
		 */

		public function __construct(Definition $definition) {

			parent::__construct($definition);

			$this->list['id'] = new Definition\Item\Index('id', 'PRIMARY');
		}

		/**
		 * Add an index
		 */

		public function add(string $name, string $type = null) {

			if ((false === $this->definition->getParam($name)) || isset($this->list[$name])) return;

			$this->list[$name] = new Definition\Item\Index($name, $type);
		}
	}
}
