<?php

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Users {

		protected static $order_by = ['rank' => 'DESC', 'name' => 'ASC', 'id' => 'ASC'];

		# Init collection

		protected function init() {

			$this->config->addParam('rank', '', function (int $rank = null) {

				return ((null !== $rank) ? ("ent.rank >= " . $rank) : '');
			});

			$this->config->addParam('time_registered >=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_registered >= " . $time) : '');
			});

			$this->config->addParam('time_registered <=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_registered <= " . $time) : '');
			});

			$this->config->addParam('time_logged >=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_logged >= " . $time) : '');
			});

			$this->config->addParam('time_logged <=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_logged <= " . $time) : '');
			});
		}
	}
}
