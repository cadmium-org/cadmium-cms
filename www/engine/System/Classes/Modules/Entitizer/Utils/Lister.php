<?php

namespace System\Modules\Entitizer\Utils {

    use System\Modules\Entitizer, DB;

    trait Lister {

        # Get query

        private static function getQuery($disable_id = 0) {

            # Determine selection params

            $selection = array(); $order_by = array();

            foreach (self::$select as $field) $selection[] = ('ent.' . $field);

            if (!is_array(self::$order_by)) $order_by[] = ('ent.' . self::$order_by);

            else foreach (self::$order_by as $field) $order_by[] = ('ent.' . $field);

            $limit = ((self::$index > 0) ? (((self::$index - 1) * self::$display) . ", " . self::$display) : "");

            # Select entries

            $query = ("SELECT SQL_CALC_FOUND_ROWS ent.id, " . implode(', ', $selection)) .

                     (self::$nesting ? ", COUNT(chd.id) as children " : " ") .

                     ("FROM " . self::$table . " ent ") .

                     (self::$nesting ? ("LEFT JOIN " . self::$table . " chd ON chd.parent_id = ent.id ") : "") .

                     ("WHERE ent.id != " . $disable_id . " ") .

                     (self::$nesting ? ("AND ent.parent_id = " . self::$parent->id . " GROUP BY ent.id ") : "") .

                     ("ORDER BY " . implode(', ', $order_by) . ", ent.id ASC" . ($limit ? (" LIMIT " . $limit) : ""));

            # ------------------------

            return $query;
        }

        # Get items

        private static function getItems($disable_id = 0) {

            $items = array('items' => array(), 'total' => 0);

            # Create definition

            $definition = Entitizer::definition(self::$type); $params = $definition->params();

            if (!(DB::send(self::getQuery($disable_id)) && DB::last()->status)) return $items;

            # Process results

			while (null !== ($row = DB::last()->row())) {

                $item = array('id' => $definition->id()->set($row['id']));

                foreach (self::$select as $field) $item[$field] = $definition->get($field)->set($row[$field]);

                if (self::$nesting) $item['children'] = intabs($row['children']);

                $items['items'][] = $item;
            }

			# Count total

			if (DB::send("SELECT FOUND_ROWS() as total") && (DB::last()->rows === 1)) {

				$items['total'] = intabs(DB::last()->row()['total']);
			}

            # ------------------------

            return $items;
        }
    }
}
