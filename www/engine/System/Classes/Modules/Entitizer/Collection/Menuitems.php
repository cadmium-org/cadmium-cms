<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Menuitems {

		# Collection configuration

		protected static $order_by = ['position' => 'ASC', 'id' => 'ASC'];

		/**
		 * Initialize the collection
		 */

		protected function init() {

			$this->config->addParam('active', '', function (bool $active) {

				return ($active ? "ent.active = 1" : '');
			});
		}
	}
}
