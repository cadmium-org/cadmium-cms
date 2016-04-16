<?php

namespace Utils\Template {

	use DB, Template;

	abstract class Widgets {

		# Generate widgets list

		public static function generate() {

			# Process selection

			$selection = ['name', 'contents']; $condition = ['active' => 1]; $order = ['name' => 'ASC'];

			if (!(DB::select(TABLE_WIDGETS, $selection, $condition, $order) && DB::last()->status)) return;

			# Process results

			while (null !== ($widget = DB::last()->row())) yield $widget['name'] => Template::block($widget['contents']);
		}
	}
}
