<?php

namespace Modules\Entitizer\View {

	use Modules\Entitizer;

	trait Menuitems {

		protected static $order_by = ['position' => 'ASC', 'id' => 'ASC'];

		# Init view

		protected function init() {

			$this->config->add('active', false, function (bool $active) {

				return ($active ? "ent.active = 1" : '');
			});
		}
	}
}
