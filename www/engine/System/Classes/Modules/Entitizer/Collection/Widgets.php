<?php

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Widgets {

		protected static $order_by = ['title' => 'ASC', 'id' => 'ASC'];

		# Init collection

		protected function init() {

			$this->config->add('active', false, function (bool $active) {

				return ($active ? "ent.active = 1" : '');
			});
		}
	}
}
