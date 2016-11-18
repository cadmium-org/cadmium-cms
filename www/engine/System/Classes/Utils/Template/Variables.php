<?php

namespace Utils\Template {

	use DB;

	abstract class Variables {

		# Generate variables list

		public static function generate() {

			# Process selection

			$selection = ['name', 'value']; $order = ['name' => 'ASC'];

			if (!(DB::select(TABLE_VARIABLES, $selection, null, $order) && DB::getLast()->status)) return;

			# Process results

			while (null !== ($variable = DB::getLast()->getRow())) {

				yield $variable['name'] => $variable['value'];
			}
		}
	}
}
