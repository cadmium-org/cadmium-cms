<?php

namespace System\Utils {

	use DB, Template;

	class Widgets {

		private $items = [];

		# Add item

		private function addItem(string $name, string $contents) {

			$this->items[$name] = Template::block($contents);
		}

		# Constructor

		public function __construct() {

			# Process selection

			$selection = ['name', 'contents']; $condition = ['display' => 1]; $order = ['name' => 'ASC'];

			if (!(DB::select(TABLE_WIDGETS, $selection, $condition, $order) && DB::last()->status)) return;

			# Process results

			while (null !== ($widget = DB::last()->row())) $this->addItem($widget['name'], $widget['contents']);
		}

		# Return items

		public function items() {

			return $this->items;
		}
	}
}
