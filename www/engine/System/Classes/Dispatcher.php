<?php

namespace {

	use Utils\Map;

	class Dispatcher extends System {

		# Dispatcher handle method

		public function handle() {

			# Check installation

			if (!$this->installed) Request::redirect(INSTALL_PATH . '/install.php');

			# Connect to database

			DB::connect(...array_values($this->database));

			# Get handler by requested url

			$handler = (new Map())->handler($url = new Url(Request::get('url')));

			# Determine handler class

			$class = ((false !== $handler) ? ('Handlers\\' . $handler) : 'Handlers\Site\Page');

			# ------------------------

			new $class($url);
		}
	}
}
