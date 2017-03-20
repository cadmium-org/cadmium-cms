<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Pages {

		# Collection configuration

		protected static $order_by = ['title' => 'ASC', 'id' => 'ASC'];

		/**
		 * Initialize the collection
		 */

		protected function init() {

			$this->config->addParam('active', '', function (bool $active) {

				return ($active ? ("ent.visibility = " . VISIBILITY_PUBLISHED . " AND ent.locked = 0") : '');
			});

			$this->config->addParam('rank', '', function (int $rank = null) {

				return ((null !== $rank) ? ("ent.access <= " . $rank) : '');
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
