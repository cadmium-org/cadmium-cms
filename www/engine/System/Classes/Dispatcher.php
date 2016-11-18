<?php

namespace {

	use Modules\Extend, Utils\Map, Utils\Schema;

	class Dispatcher {

		# Dispatcher handle method

		public function handle() {

			# Check installation

			if (null === ($data = Schema::get('System')->load())) {

				Request::redirect(INSTALL_PATH . '/install.php');
			}

			# Connect to database

			DB::connect(...array_values($data['database']));

			# Init addons

			Extend\Addons::init();

			# Get handler by requested url

			$handler = Map::handler($url = new Url(Request::get('url')));

			# Determine handler class

			$class = ((false !== $handler) ? $handler : 'Modules\Page');

			# ------------------------

			new $class($url);
		}
	}
}
