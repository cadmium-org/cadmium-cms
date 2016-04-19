<?php

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Pages {

		protected static $order_by = ['title' => 'ASC', 'id' => 'ASC'];

		# Init collection

		protected function init() {

			$this->config->add('active', false, function (bool $active) {

				return ($active ? ("ent.visibility = " . VISIBILITY_PUBLISHED . " AND ent.locked = 0") : '');
			});

			$this->config->add('rank', null, function (int $rank = null) {

				return ((null !== $rank) ? ("ent.access <= " . $rank) : '');
			});

			$this->config->add('slug', '', function (string $slug) {

				return (('' !== $slug) ? ("ent.slug = '" . addslashes($slug) . "'") : '');
			});

			$this->config->add('name', '', function (string $name) {

				return (('' !== $name) ? ("ent.name = '" . addslashes($name) . "'") : '');
			});

			$this->config->add('time_created >=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_created >= " . $time) : '');
			});

			$this->config->add('time_created <=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_created <= " . $time) : '');
			});

			$this->config->add('time_modified >=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_modified >= " . $time) : '');
			});

			$this->config->add('time_modified <=', 0, function (int $time) {

				return ((0 < $time) ? ("ent.time_modified <= " . $time) : '');
			});
		}
	}
}
