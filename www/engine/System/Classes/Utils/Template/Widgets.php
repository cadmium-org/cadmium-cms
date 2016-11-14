<?php

namespace Utils\Template {

	use DB, Template;

	abstract class Widgets {

		# Generate widgets list

		public static function generate() {

			# Process selection

			$selection = ['name', 'contents']; $condition = ['active' => 1]; $order = ['name' => 'ASC'];

			if (!(DB::select(TABLE_WIDGETS, $selection, $condition, $order) && DB::getLast()->status)) return;

			# Process results

			while (null !== ($widget = DB::getLast()->getRow())) {

				yield $widget['name'] => Template::createBlock($widget['contents']);
			}
		}
	}
}
