<?php

namespace {

	abstract class System {

		protected $installed = false;

		protected $database = ['server' => '', 'user' => '', 'password' => '', 'name' => ''], $time = 0;

		# Set database value

		private function setDatabase(string $key, $string $value) {

			$this->database[$key] = $value;
		}

		# Set time

		private function setTime(int $value) {

			$this->time = $value;
		}

		# Parse system file

		private function parse(array $data) {

			$this->installed = true;

			# Parse database params

			foreach (array_keys($this->database) as $key) {

				$this->setDatabase($key, Arr::get($data, ['database', $key]));
			}

			# Parse installation details

			$this->setTime(Arr::get($data, ['time']));
		}

		# Constructor

		public function __construct() {

			$system_file = (DIR_SYSTEM_DATA . 'System.json');

			if (false !== ($data = Explorer::json($system_file))) $this->parse($data);
		}
	}
}
