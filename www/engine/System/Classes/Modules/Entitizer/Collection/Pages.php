<?php

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Pages {

		protected static $order_by = ['title' => 'ASC', 'id' => 'ASC'];

		# Init collection

		protected function init() {

			$this->config->addParam('active', '', function (bool $active) {

				return ($active ? ("ent.visibility = " . VISIBILITY_PUBLISHED . " AND ent.locked = 0") : '');
			});

			$this->config->addParam('rank', '', function (int $rank = null) {

				return ((null !== $rank) ? ("ent.access <= " . $rank) : '');
			});

			$this->config->addParam('slug', '', function (string $slug) {

				return (('' !== $slug) ? ("ent.slug = '" . addslashes($slug) . "'") : '');
			});

			$this->config->addParam('name', '', function (string $name) {

				return (('' !== $name) ? ("ent.name = '" . addslashes($name) . "'") : '');
			});

			$this->config->addParam('time_created >=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_created >= " . $time) : '');
			});

			$this->config->addParam('time_created <=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_created <= " . $time) : '');
			});

			$this->config->addParam('time_modified >=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_modified >= " . $time) : '');
			});

			$this->config->addParam('time_modified <=', '', function (int $time) {

				return ((0 < $time) ? ("ent.time_modified <= " . $time) : '');
			});
		}
	}
}
