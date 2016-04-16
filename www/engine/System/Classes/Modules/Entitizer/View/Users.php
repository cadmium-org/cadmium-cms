<?php

namespace Modules\Entitizer\View {

	use Modules\Entitizer;

	trait Users {

		protected static $order_by = ['rank' => 'DESC', 'name' => 'ASC', 'id' => 'ASC'];

		# Init view

		protected function init() {

			$this->config->add('rank', null, function (int $rank = null) {

				return ((null !== $rank) ? ("ent.rank >= " . $rank) : '');
			});

			$this->config->add('time_registered >=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_registered >= " . $time) : '');
			});

			$this->config->add('time_registered <=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_registered <= " . $time) : '');
			});

			$this->config->add('time_logged >=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_logged >= " . $time) : '');
			});

			$this->config->add('time_logged <=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_logged <= " . $time) : '');
			});
		}
	}
}
