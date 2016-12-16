<?php

/**
 * @package Cadmium\System
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	use Modules\Extend, Utils\Map, Utils\Schema;

	class Dispatcher {

		/**
		 * Route a request to a handler
		 */

		public function route() {

			# Check installation

			if (null === ($data = Schema::get('System')->load())) {

				Request::redirect(INSTALL_PATH . '/install.php');
			}

			# Connect to database

			DB::connect(...array_values($data['database']));

			# Init addons

			Extend\Addons::init();

			# Get handler class by requested url

			$handler = Map::handler($url = new Url(Request::get('url')));

			$class = ((false !== $handler) ? $handler : 'Modules\Page');

			# ------------------------

			new $class($url);
		}
	}
}
