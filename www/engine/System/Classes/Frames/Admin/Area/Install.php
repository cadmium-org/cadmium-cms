<?php

namespace Frames\Admin\Area {

	use Frames, Frames\Status, Template;

	abstract class Install extends Frames\Admin\Section {

		protected $layout = 'Form';

		# Install area main method

		protected function area() {

			# Handle request

			if (Template::isBlock($result = $this->handle())) return $this->displayPage($result, STATUS_CODE_200);

			# ------------------------

			return Status::error404();
		}
	}
}
