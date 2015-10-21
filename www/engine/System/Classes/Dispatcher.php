<?php

namespace System {

	use System, System\Utils\Map, DB, Request, Url;

	class Dispatcher extends System {

		# Dispatcher handle method

		public function handle() {

			# Check installation

			if (!$this->installed) Request::redirect(INSTALL_PATH . '/install.php');

			# Connect to database

			DB::connect (

				$this->database['server'], $this->database['user'],

				$this->database['password'], $this->database['name']
			);

			# Create url

			$url = new Url(Request::get('url'));

			# Create map

			$map = new Map(); $handler = $map->handler($url->path());

			# Determine handler class

			$class = ((false !== $handler) ? ('System\Handlers\\' . $handler) : 'System\Handlers\Site\Page');

			# ------------------------

			new $class($url->path());
		}
	}
}
