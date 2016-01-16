<?php

namespace {

	abstract class System {

		protected $installed = false;

		protected $database = ['server' => '', 'user' => '', 'password' => '', 'name' => ''], $time = 0;

		# Parse system file

		private function parse(array $data) {

			$this->installed = true;

			# Parse database params

			foreach (array_keys($this->database) as $key) {

				if (is_scalar($value = Arr::get($data, ['database', $key]))) $this->database[$key] = strval($value);
			}

			# Parse installation details

			if (is_numeric($time = Arr::get($data, ['time']))) $this->time = intval($time);
		}

		# Constructor

		public function __construct() {

			$system_file = (DIR_SYSTEM_DATA . 'System.json');

			if (false !== ($data = Explorer::json($system_file))) $this->parse($data);
		}
	}
}
