<?php

namespace System {

	use System, System\Handlers, Request, Validate;

	class Installer extends System {

		# Installer main method

		protected function main() {

			# Check installation

			if ($this->installed) return new Handlers\Page();
		}
	}
}

?>
