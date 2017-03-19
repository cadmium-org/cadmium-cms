<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition {

	use Modules\Entitizer\Utils\Definition;

	abstract class Group {

		protected $definition = null, $list = [];

		/**
		 * Constructor
		 */

		public function __construct(Definition $definition) {

			$this->definition = $definition;
		}

		/**
		 * Get an item
		 *
		 * @return Entitizer\Utils\Definition\Item|false : the item object or false if the item does not exist
		 */

		public function get(string $name) {

			return ($this->list[$name] ?? false);
		}

		/**
		 * Get the items list
		 */

		public function getList() : array {

			return $this->list;
		}
	}
}
