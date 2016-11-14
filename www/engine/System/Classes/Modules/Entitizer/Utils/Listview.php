<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, DB;

	abstract class Listview extends Collection {

		# Get default select query

		private function getDefaultSelectQuery(array $config, array $order_by, int $index, int $display) {

			return ("SELECT SQL_CALC_FOUND_ROWS " . $this->getSelection() . " ") .

			       ("FROM " . static::$table . " ent ") .

				   (('' !== ($condition = $this->getCondition($config))) ? ("WHERE " . $condition . " ") : "") .

				   ("ORDER BY " . $this->getOrderBy($order_by) . " ") .

			       (($index > 0) ? ("LIMIT " . ((($index - 1) * $display) . ", " . $display)) : "");
		}

		# Get nesting select query

		private function getNestingSelectQuery(int $parent_id, array $config, array $order_by, int $index, int $display) {

			return ("SELECT SQL_CALC_FOUND_ROWS " . $this->getSelection() . ", COUNT(chd.descendant) as children ") .

			       ("FROM " . static::$table . " ent ") .

			       ("LEFT JOIN " . static::$table_relations . " chd ON chd.ancestor = ent.id AND chd.depth = 1 ") .

				   ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

				   ("WHERE COALESCE(rel.ancestor, 0) = " . $parent_id . " ") .

				   (('' !== ($condition = $this->getCondition($config))) ? ("AND " . $condition . " ") : "") .

				   ("GROUP BY ent.id ORDER BY " . $this->getOrderBy($order_by) . " ") .

			       (($index > 0) ? ("LIMIT " . ((($index - 1) * $display) . ", " . $display)) : "");
		}

		# Get default count query

		private function getDefaultCountQuery(array $config) {

			return ("SELECT COUNT(ent.id) as count FROM " . static::$table . " ent ") .

			       (('' !== ($condition = $this->getCondition($config))) ? ("WHERE " . $condition) : "");
		}

		# Get nesting count query

		private function getNestingCountQuery(int $parent_id, array $config) {

			return ("SELECT COUNT(ent.id) as count FROM " . static::$table . " ent ") .

			       ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

			       ("WHERE COALESCE(rel.ancestor, 0) = " . $parent_id . " ") .

			       (('' !== ($condition = $this->getCondition($config))) ? ("AND " . $condition) : "");
		}

		# Select entries from DB

		private function select(int $parent_id = null, array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			if (!((null === $parent_id) || ($parent_id >= 0))) return false;

			if (!(($index >= 0) && ($display >= 0))) return false;

			# Select entities

			$query = ((null === $parent_id) ? $this->getDefaultSelectQuery($config, $order_by, $index, $display) :

				$this->getNestingSelectQuery($parent_id, $config, $order_by, $index, $display));

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# Process results

			$items = ['list' => [], 'total' => 0];

			while (null !== ($data = DB::getLast()->getRow())) {

				$dataset = Entitizer::dataset(static::$table, $data);

				$items['list'][$dataset->id]['dataset'] = $dataset;

				if (null !== $parent_id) $items['list'][$dataset->id]['children'] = intval($data['children']);
			}

			# Count total

			if (DB::send("SELECT FOUND_ROWS() as total") && (DB::getLast()->rows === 1)) {

				$items['total'] = intval(DB::getLast()->getRow()['total']);
			}

			# ------------------------

			return $items;
		}

		# Count entries in DB

		private function count(int $parent_id = null, array $config = []) {

			if (!((null === $parent_id) || ($parent_id >= 0))) return false;

			# Count entities

			$query = ((null === $parent_id) ? $this->getDefaultCountQuery($config) :

				$this->getNestingCountQuery($parent_id, $config));

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# ------------------------

			return intval(DB::getLast()->getRow()['count']);
		}

		# Get items

		public function items(array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			return $this->select(null, $config, $order_by, $index, $display);
		}

		# Get items count

		public function itemsCount(array $config = []) {

			return $this->count(null, $config);
		}

		# Get children

		public function children(int $parent_id = 0, array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			if (!static::$nesting) return false;

			return $this->select($parent_id, $config, $order_by, $index, $display);
		}

		# Get children count

		public function childrenCount(int $parent_id = 0, array $config = []) {

			if (!static::$nesting) return false;

			return $this->count($parent_id, $config);
		}
	}
}
