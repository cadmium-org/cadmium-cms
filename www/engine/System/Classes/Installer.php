<?php

namespace System {

	use Engine, Explorer;

	class Installer extends Engine {

		# Installer main method

		protected function main() {

			# Check installation

			if (!Explorer::isFile(DIR_SYSTEM_INCLUDES . 'Install.php')) Request::redirect('/install.php');
		}
	}
}

?>
