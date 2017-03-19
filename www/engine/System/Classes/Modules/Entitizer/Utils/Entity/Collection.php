<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Entity {

	use Modules\Entitizer;

	trait Collection {

		protected $definition = null, $dataset = null;

		/**
		 * Get the list of items
		 *
		 * @param $config       an array of filtering options
		 * @param $order_by     an array where each key is a field name and each value is a sorting direction (ASC or DESC)
		 * @param $index        a page index
		 * @param $display      a number of results per page
		 *
		 * @return array|false : the array of entities or false on failure
		 */

		public function getItems(array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			return Entitizer::getListview(static::$table)->getItems($config, $order_by, $index, $display);
		}

		/**
		 * Get the items count
		 *
		 * @param $config : an array of filtering options
		 *
		 * @return int|false : the number of entities or false on failure
		 */

		public function getItemsCount(array $config = []) {

			return Entitizer::getListview(static::$table)->getItemsCount($config);
		}

		/**
		 * Get the list of children items
		 *
		 * @param $config       an array of filtering options
		 * @param $order_by     an array where each key is a field name and each value is a sorting direction (ASC or DESC)
		 * @param $index        a page index
		 * @param $display      a number of results per page
		 *
		 * @return array|false : the array of entities or false on failure
		 */

		public function getChildren(array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			return Entitizer::getListview(static::$table)->getChildren($this->id, $config, $order_by, $index, $display);
		}

		/**
		 * Get the children items count
		 *
		 * @param $config : an array of filtering options
		 *
		 * @return int|false : the number of entities or false on failure
		 */

		public function getChildrenCount(array $config = []) {

			return Entitizer::getListview(static::$table)->getChildrenCount($this->id, $config);
		}

		/**
		 * Get the entity subtree
		 *
		 * @param $config       an array of filtering options
		 * @param $order_by     an array where each key is a field name and each value is a sorting direction (ASC or DESC)
		 *
		 * @return array|false : the multidimensional array containing the tree or false on failure
		 */

		public function getSubtree(array $config = [], array $order_by = []) {

			return Entitizer::getTreeview(static::$table)->getSubtree($this->id, $config, $order_by);
		}

		/**
		 * Get the count of items within the entity subtree
		 *
		 * @return int|false : the number of entities or false on failure
		 */

		public function getSubtreeCount() {

			return Entitizer::getTreeview(static::$table)->getSubtreeCount($this->id);
		}

		/**
		 * Get the subtree depth
		 *
		 * @return int|false : the depth or false on failure
		 */

		public function getSubtreeDepth() {

			return Entitizer::getTreeview(static::$table)->getSubtreeDepth($this->id);
		}

		/**
		 * Get the entity path
		 *
		 * @return array|false : the array of path items or false on failure
		 */

		public function getPath() {

			return Entitizer::getTreeview(static::$table)->getPath($this->id);
		}
	}
}
