<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Group {

	use Modules\Entitizer\Utils\Definition;

	class Foreigns extends Definition\Group {

		/**
		 * Add a foreign
		 */

		public function add(string $name, string $table, string $field, string $delete = null, string $update = null) {

			if ((false === $this->definition->getParam($name)) || isset($this->list[$name])) return;

			$this->list[$name] = new Definition\Item\Foreign($name, $table, $field, $delete, $update);
		}
	}
}
