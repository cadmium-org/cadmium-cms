<?php

namespace System\Modules\Entitizer\Utils {

	use System\Modules\Entitizer, DB;

	abstract class Lister {

		private $definition = null;

		# Get query

		private function getQuery(int $index, int $display, int $parent_id, int $disable_id) {

			$selection = []; $order_by = [];

			# Process selection

			foreach (array_keys($this->definition->params()) as $field) {

				$selection[] = ('ent.' . $field);
			}

			# Process order

			foreach ($this->definition->orderers() as $field => $descending) {

				$order_by[] = ('ent.' . $field . ' ' . ($descending ? 'DESC' : 'ASC'));
			}

			# Process limit

			$limit = (($index > 0) ? ((($index - 1) * $display) . ", " . $display) : "");

			# Process query

			$query = ("SELECT SQL_CALC_FOUND_ROWS ent.id, " . implode(', ', $selection)) .

			         (static::$nesting ? ", COUNT(chd.id) as children " : " ") .

			         ("FROM " . static::$table . " ent ") .

			         (static::$nesting ? ("LEFT JOIN " . static::$table . " chd ON chd.parent_id = ent.id ") : "") .

			         ("WHERE ent.id != " . $disable_id . " ") .

			         (static::$nesting ? ("AND ent.parent_id = " . $parent_id . " GROUP BY ent.id ") : "") .

			         ("ORDER BY " . implode(', ', $order_by) . ", ent.id ASC" . ($limit ? (" LIMIT " . $limit) : ""));

			# ------------------------

			return $query;
		}

		# Constructor

		public function __construct() {

			$this->definition = Entitizer\Definition::get(static::$type);
		}

		# Select items from DB

		public function select(int $index = 0, int $display = 0, int $parent_id = 0, int $disable_id = 0) {

			$items = ['list' => [], 'total' => 0];

			if (!(($index >= 0) && ($display >= 0) && ($parent_id >= 0) && ($disable_id >= 0))) return $items;

			# Select entities

			$query = $this->getQuery($index, $display, $parent_id, $disable_id);

			if (!(DB::send($query) && DB::last()->status)) return $items;

			# Process results

			while (null !== ($data = DB::last()->row())) {

				$entity = Entitizer::get(static::$type); $entity->fill($data);

				$children = (static::$nesting ? ['children' => intval($data['children'])] : []);

				$items['list'][] = array_merge(['entity' => $entity], $children);
			}

			# Count total

			if (DB::send("SELECT FOUND_ROWS() as total") && (DB::last()->rows === 1)) {

				$items['total'] = intval(DB::last()->row()['total']);
			}

			# ------------------------

			return $items;
		}
	}
}
