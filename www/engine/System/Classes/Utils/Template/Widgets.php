<?php

namespace Utils\Template {

	use DB, Template;

	abstract class Widgets {

		# Generate widgets list

		public static function generate() {

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
