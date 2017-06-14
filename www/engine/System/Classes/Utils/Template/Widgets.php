<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Template {

	use DB, Template;

	abstract class Widgets {

		/**
		 * Generate the widgets list
		 */

		public static function generate() : \Generator {

			# Process selection

			if (0 === count($name = array_keys(Template::getWidgets()))) return;

			DB::select(TABLE_WIDGETS, ['name', 'contents'], ['active' => 1, 'name' => $name], ['name' => 'ASC']);

			if (!(DB::getLast() && DB::getLast()->status)) return;

			# Process results

			while (null !== ($widget = DB::getLast()->getRow())) {

				yield $widget['name'] => Template::createBlock($widget['contents']);
			}
		}
	}
}
