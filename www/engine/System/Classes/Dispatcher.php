<?php

namespace System {

	use System, System\Utils\Map, DB, Request, Url;

	class Dispatcher extends System {

		# Dispatcher main method

		public function handle() {

			# Check installation

			if (!$this->installed) Request::redirect('/install.php');

			# Connect to database

			DB::connect (

				$this->database['server'], $this->database['user'],

				$this->database['password'], $this->database['name']
			);

			# Handle request

			$url = new Url(getenv('REQUEST_URI'));

			$map = new Map(); $map->handle($url->path());
		}
	}
}
