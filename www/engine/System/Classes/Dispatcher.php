<?php

namespace System {

	use System, System\Utils\Map, DB, Explorer, Request, Url;

	class Dispatcher extends System {

		# Dispatcher handle method

		public function handle() {

			# Check installation

			if (!$this->installed) Request::redirect(INSTALL_PATH . '/install.php');

			# Try to remove install file

			// Explorer::removeFile(DIR_WWW . 'install.php');

			# Connect to database

			DB::connect (

				$this->database['server'], $this->database['user'],

				$this->database['password'], $this->database['name']
			);

			# Get handler by requested url

			$handler = (new Map())->handler($url = new Url(Request::get('url')));

			# Determine handler class

			$class = ((false !== $handler) ? ('System\Handlers\\' . $handler) : 'System\Handlers\Site\Page');

			# ------------------------

			new $class($url);
		}
	}
}
