<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, DB;

	abstract class Treeview extends Collection {

		# Get join statement

		protected function getQueryJoin(int $parent_id) {

			return (0 !== $parent_id) ? (("JOIN " . static::$table_relations . " rel ") .

			       ("ON rel.ancestor = " . $parent_id . " AND rel.descendant = ent.id AND rel.depth >= 1")) :

				   ("JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id");
		}

		# Get select query

		private function getSelectQuery(int $parent_id, array $config, array $order_by) {

			return ("SELECT " . $this->getSelection() . ", COALESCE(par.ancestor, 0) as parent_id ") .

			       ("FROM " . static::$table . " ent " . $this->getQueryJoin($parent_id) . " ") .

			       ("LEFT JOIN " . static::$table_relations . " par ON par.descendant = ent.id AND par.depth = 1 ") .

			       (('' !== ($condition = $this->getCondition($config))) ? ("WHERE " . $condition . " ") : "") .

			       ("GROUP BY ent.id ORDER BY MAX(rel.depth) ASC, " . $this->getOrderBy($order_by));
		}

		# Get count query

		private function getCountQuery(int $parent_id) {

			return ("SELECT COUNT(DISTINCT ent.id) as count FROM " . static::$table . " ent ") .

			       $this->getQueryJoin($parent_id);
		}

		# Get depth query

		private function getDepthQuery(int $parent_id) {

			$query = ("SELECT COUNT(DISTINCT rel.depth) as depth FROM " . static::$table . " ent ") .

			         $this->getQueryJoin($parent_id);

			# ------------------------

			return $query;
		}

		# Get subtree

		public function subtree(int $parent_id = 0, array $config = [], array $order_by = []) {

			if (!(static::$nesting && ($parent_id >= 0))) return false;

			# Select entities

			$query = $this->getSelectQuery($parent_id, $config, $order_by);

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# Process results

			$items = [$parent_id => ['children' => []]];

			while (null !== ($data = DB::getLast()->getRow())) {

				$dataset = Entitizer::dataset(static::$table, $data);

				$items[$dataset->id] = ['dataset' => $dataset, 'children' => []];

				$items[intval($data['parent_id'])]['children'][] = $dataset->id;
			}

			# ------------------------

			return $items;
		}

		# Get subtree count

		public function subtreeCount(int $parent_id = 0) {

			if (!(static::$nesting && ($parent_id >= 0))) return false;

			# Get count

			$query = $this->getCountQuery($parent_id);

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# ------------------------

			return intval(DB::getLast()->getRow()['count']);
		}

		# Get subtree depth

		public function subtreeDepth(int $parent_id = 0) {

			if (!(static::$nesting && ($parent_id >= 0))) return false;

			# Get depth

			$query = $this->getDepthQuery($parent_id);

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# ------------------------

			return intval(DB::getLast()->getRow()['depth']);
		}

		# Get path

		public function path(int $parent_id = 0) {

			if (!(static::$nesting && ($parent_id >= 0))) return false;

			# Process query

			$query = ("SELECT " . $this->getSelection() . " FROM " . static::$table . " ent ") .

			         ("JOIN " . static::$table_relations . " rel ON rel.ancestor = ent.id ") .

					 ("WHERE rel.descendant = " . $parent_id . " ORDER BY rel.depth DESC");

			# Select path

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# Process results

			$path = [];

			while (null !== ($data = DB::getLast()->getRow())) $path[] = Entitizer::dataset(static::$table, $data)->data();

			# ------------------------

			return $path;
		}
	}
}
