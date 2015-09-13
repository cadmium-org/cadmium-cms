<?php

namespace {

	abstract class System extends Engine {

		protected $installed = false;

		protected $database = array('server' => '', 'user' => '', 'password' => '', 'name' => ''), $time = 0;

		# Parse system file

		private function parse($data) {

			$this->installed = true;

			# Parse database params

			foreach (array_keys($this->database) as $key) {

				$this->database[$key] = strval(Arr::get($data, array('database', $key)));
			}

			# Parse installation details

			$this->time = intabs(Arr::get($data, array('time')));
		}

        # System init method

		protected function init() {

			$system_file = (DIR_SYSTEM_DATA . 'System.json');

			if (false !== ($data = Explorer::json($system_file))) $this->parse($data);

			# Include system constants

			require_once (DIR_SYSTEM_INCLUDES . 'Config.php');
			require_once (DIR_SYSTEM_INCLUDES . 'Constants.php');
			require_once (DIR_SYSTEM_INCLUDES . 'Regex.php');
			require_once (DIR_SYSTEM_INCLUDES . 'Tables.php');

			# ------------------------

			$this->main();
		}

		# System main method interface

		abstract protected function main();
    }
}
