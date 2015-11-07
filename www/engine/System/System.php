<?php

namespace {

	abstract class System {

		protected $installed = false;

		protected $database = ['server' => '', 'user' => '', 'password' => '', 'name' => ''], $time = 0;

		# Parse system file

		private function parse($data) {

			$this->installed = true;

			# Parse database params

			foreach (array_keys($this->database) as $key) {

				$this->database[$key] = strval(Arr::get($data, ['database', $key]));
			}

			# Parse installation details

			$this->time = intval(Arr::get($data, ['time']));
		}

		# Constructor

		public function __construct() {

			$system_file = (DIR_SYSTEM_DATA . 'System.json');

			if (false !== ($data = Explorer::json($system_file))) $this->parse($data);
		}
	}
}
