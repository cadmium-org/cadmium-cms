<?php

namespace System {

	use Engine, System\Utils\Map\Map, Explorer, Url;

	class Dispatcher extends Engine {

		# Dispatcher main method

		protected function main() {

			# Check installation

			//if (!Explorer::isFile(DIR_SYSTEM_INCLUDES . 'Install.php')) Request::redirect('/install.php');

			if (!Explorer::isFile(DIR_SYSTEM_INCLUDES . 'Install.php')) exit('DB settings not configured.');

			# Include constants

			require_once (DIR_SYSTEM_INCLUDES . 'Install.php');
			require_once (DIR_SYSTEM_INCLUDES . 'Config.php');
			require_once (DIR_SYSTEM_INCLUDES . 'Constants.php');
			require_once (DIR_SYSTEM_INCLUDES . 'Regex.php');
			require_once (DIR_SYSTEM_INCLUDES . 'Tables.php');

			# Handle request

			$url = new Url($_SERVER['REQUEST_URI']);

			$map = new Map(); $map->handle($url->path());
		}
	}
}

?>
