<?php

namespace Modules\Entitizer\Utils\Entity {

	use Modules\Entitizer;

	trait Collection {

		protected $definition = null, $dataset = null;

		# Get items

		public function items(array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			return Entitizer::listview(static::$table)->items($config, $order_by, $index, $display);
		}

		# Get items count

		public function itemsCount(array $config = []) {

			return Entitizer::listview(static::$table)->itemsCount($config);
		}

		# Get children

		public function children(array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			return Entitizer::listview(static::$table)->children($this->id, $config, $order_by, $index, $display);
		}

		# Get children count

		public function childrenCount(array $config = []) {

			return Entitizer::listview(static::$table)->childrenCount($this->id, $config);
		}

		# Get subtree

		public function subtree(array $config = [], array $order_by = []) {

			return Entitizer::treeview(static::$table)->subtree($this->id, $config, $order_by);
		}

		# Get subtree count

		public function subtreeCount() {

			return Entitizer::treeview(static::$table)->subtreeCount($this->id);
		}

		# Get subtree depth

		public function subtreeDepth() {

			return Entitizer::treeview(static::$table)->subtreeDepth($this->id);
		}

		# Get path

		public function path() {

			return Entitizer::treeview(static::$table)->path($this->id);
		}
	}
}
