<?php

namespace System\Modules\Entitizer\Utils {

	use System\Modules\Entitizer, DB;

	abstract class Lister {

		# Get query

		private function getQuery(array $select, int $index, int $display, int $parent_id, int $disable_id) {

			$selection = []; $order_by = [];

			# Process selection

			foreach ($select as $field) $selection[] = ('ent.' . $field);

			# Process order

			foreach (static::$order as $field) $order_by[] = ('ent.' . $field);

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

		# Get items

		public function select(int $index = 0, int $display = 0, int $parent_id = 0, int $disable_id = 0) {

			$items = ['list' => [], 'total' => 0];

			# Create definition

			$definition = Entitizer\Definition::get(static::$type); $params = $definition->params();

			# Select entities

			$query = $this->getQuery(array_keys($params), $index, $display, $parent_id, $disable_id);

			if (!(DB::send($query) && DB::last()->status)) return $items;

			# Process results

			while (null !== ($row = DB::last()->row())) {

				$item = ['id' => $definition->id()->cast($row['id'])];

				foreach ($params as $name => $param) $item[$name] = $param->cast($row[$name]);

				if (static::$nesting) $item['children'] = intval($row['children']);

				$items['list'][] = $item;
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
