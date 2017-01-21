<?php

namespace Utils\Template {

	use DB;

	abstract class Variables {

		# Generate variables list

		public static function generate() {

			# Process selection

			DB::select(TABLE_VARIABLES, ['name', 'value'], null, ['name' => 'ASC']);

			if (!(DB::getLast() && DB::getLast()->status)) return;

			# Process results

			while (null !== ($variable = DB::getLast()->getRow())) {

				yield $variable['name'] => $variable['value'];
			}
		}
	}
}
