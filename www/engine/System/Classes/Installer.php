<?php

namespace System {

	use System, System\Handlers, System\Utils\Requirements, Request;

	class Installer extends System {

		# Installer main method

		protected function main() {

			# Check installation

			if ($this->installed) return new Handlers\Page();

			# Handle request

			$checked = (Requirements::status() && boolval(Request::get('checked')));

			return (!$checked ? new Handlers\Admin\Install\Check() : new Handlers\Admin\Install\Configure());
		}
	}
}
