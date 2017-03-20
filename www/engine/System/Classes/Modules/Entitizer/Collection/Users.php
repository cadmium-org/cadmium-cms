<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Users {

		# Collection configuration

		protected static $order_by = ['rank' => 'DESC', 'name' => 'ASC', 'id' => 'ASC'];

		/**
		 * Initialize the collection
		 */

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
