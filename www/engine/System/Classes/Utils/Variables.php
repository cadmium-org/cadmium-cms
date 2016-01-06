<?php

namespace Utils {

	use DB;

	class Variables {

		private $items = [];

		# Add item

		private function addItem(string $name, string $value) {

			$this->items[$name] = $value;
		}

		# Constructor

		public function __construct() {

			# Process selection

			$selection = ['name', 'value']; $order = ['name' => 'ASC'];

			if (!(DB::select(TABLE_VARIABLES, $selection, null, $order) && DB::last()->status)) return;

			# Process results

			while (null !== ($variable = DB::last()->row())) $this->addItem($variable['name'], $variable['value']);
		}

		# Return items

		public function items() {

			return $this->items;
		}
	}
}
