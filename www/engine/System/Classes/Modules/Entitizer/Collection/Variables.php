<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Collection {

	use Modules\Entitizer;

	trait Variables {

		# Collection configuration

		protected static $order_by = ['title' => 'ASC', 'id' => 'ASC'];

		/**
		 * Initialize the collection
		 */

		protected function init() {}
	}
}
