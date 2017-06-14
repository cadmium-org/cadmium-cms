<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Template {

	use DB;

	abstract class Variables {

		/**
		 * Generate the variables list
		 */

		public static function generate() : \Generator {

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
