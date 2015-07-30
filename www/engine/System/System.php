<?php

namespace {

	abstract class System extends Engine {

		protected $installed = false, $time = false;

		protected $database = array('server' => false, 'user' => false, 'password' => false, 'name' => false);

		# Parse system file

		private function parse($data) {

			$this->installed = true;

			# Parse installation details

			$this->time = Number::unsigned(Arr::get($data, array('time')));

			# Parse database params

			foreach (array_keys($this->database) as $key) {

				$this->database[$key] = String::validate(Arr::get($data, array('database', $key)));
			}
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
    }
}
