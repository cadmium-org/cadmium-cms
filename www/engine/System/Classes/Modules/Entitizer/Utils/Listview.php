<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, DB;

	abstract class Listview extends Collection {

		/**
		 * Get the basic select query
		 */

		private function getBasicSelectQuery(array $config, array $order_by, int $index, int $display) : string {

			return ("SELECT SQL_CALC_FOUND_ROWS " . $this->getSelection() . " ") .

			       ("FROM " . static::$table . " ent ") .

				   (('' !== ($condition = $this->getCondition($config))) ? ("WHERE " . $condition . " ") : "") .

				   ("ORDER BY " . $this->getOrderBy($order_by) . " ") .

			       (($index > 0) ? ("LIMIT " . ((($index - 1) * $display) . ", " . $display)) : "");
		}

		/**
		 * Get the nesting select query
		 */

		private function getNestingSelectQuery(int $parent_id, array $config, array $order_by, int $index, int $display) : string {

			return ("SELECT SQL_CALC_FOUND_ROWS " . $this->getSelection() . ", COUNT(chd.descendant) as children ") .

			       ("FROM " . static::$table . " ent ") .

			       ("LEFT JOIN " . static::$table_relations . " chd ON chd.ancestor = ent.id AND chd.depth = 1 ") .

				   ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

				   ("WHERE COALESCE(rel.ancestor, 0) = " . $parent_id . " ") .

				   (('' !== ($condition = $this->getCondition($config))) ? ("AND " . $condition . " ") : "") .

				   ("GROUP BY ent.id ORDER BY " . $this->getOrderBy($order_by) . " ") .

			       (($index > 0) ? ("LIMIT " . ((($index - 1) * $display) . ", " . $display)) : "");
		}

		/**
		 * Get the basic count query
		 */

		private function getBasicCountQuery(array $config) : string {

			return ("SELECT COUNT(ent.id) as count FROM " . static::$table . " ent ") .

			       (('' !== ($condition = $this->getCondition($config))) ? ("WHERE " . $condition) : "");
		}

		/**
		 * Get the nesting count query
		 */

		private function getNestingCountQuery(int $parent_id, array $config) : string {

			return ("SELECT COUNT(ent.id) as count FROM " . static::$table . " ent ") .

			       ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

			       ("WHERE COALESCE(rel.ancestor, 0) = " . $parent_id . " ") .

			       (('' !== ($condition = $this->getCondition($config))) ? ("AND " . $condition) : "");
		}

		/**
		 * Select entries from DB
		 *
		 * @return array|false : the array of entities or false on failure
		 */

		private function select(int $parent_id = null, array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			if (!((null === $parent_id) || ($parent_id >= 0))) return false;

			if (!(($index >= 0) && ($display >= 0))) return false;

			# Select entities

			$query = ((null === $parent_id) ? $this->getBasicSelectQuery($config, $order_by, $index, $display) :

				$this->getNestingSelectQuery($parent_id, $config, $order_by, $index, $display));

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# Process results

			$items = ['list' => [], 'total' => 0];

			while (null !== ($data = DB::getLast()->getRow())) {

				$dataset = Entitizer::getDataset(static::$table, $data);

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

		/**
		 * Count entries in DB
		 *
		 * @return int|false : the number of entities or false on failure
		 */

		private function count(int $parent_id = null, array $config = []) {

			if (!((null === $parent_id) || ($parent_id >= 0))) return false;

			# Count entities

			$query = ((null === $parent_id) ? $this->getBasicCountQuery($config) :

				$this->getNestingCountQuery($parent_id, $config));

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# ------------------------

			return intval(DB::getLast()->getRow()['count']);
		}

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

			return $this->select(null, $config, $order_by, $index, $display);
		}

		/**
		 * Get the items count
		 *
		 * @param $config : an array of filtering options
		 *
		 * @return int|false : the number of entities or false on failure
		 */

		public function getItemsCount(array $config = []) {

			return $this->count(null, $config);
		}

		/**
		 * Get the list of children items
		 *
		 * @param $parent_id    an id of a parent entity
		 * @param $config       an array of filtering options
		 * @param $order_by     an array where each key is a field name and each value is a sorting direction (ASC or DESC)
		 * @param $index        a page index
		 * @param $display      a number of results per page
		 *
		 * @return array|false : the array of entities or false on failure
		 */

		public function getChildren(int $parent_id = 0, array $config = [], array $order_by = [], int $index = 0, int $display = 0) {

			if (!static::$nesting) return false;

			return $this->select($parent_id, $config, $order_by, $index, $display);
		}

		/**
		 * Get the children items count
		 *
		 * @param $parent_id    an id of a parent entity
		 * @param $config       an array of filtering options
		 *
		 * @return int|false : the number of entities or false on failure
		 */

		public function getChildrenCount(int $parent_id = 0, array $config = []) {

			if (!static::$nesting) return false;

			return $this->count($parent_id, $config);
		}
	}
}
