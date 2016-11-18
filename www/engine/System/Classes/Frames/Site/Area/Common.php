<?php

namespace Frames\Site\Area {

	use Frames, Frames\Status, Template;

	abstract class Common extends Frames\Site\Section {

		# Common area main method

		protected function area() {

			# Handle request

			if (Template::isBlock($result = $this->handle())) return $this->displayPage($result, STATUS_CODE_200);

			# ------------------------

			return Status::error404();
		}
	}
}
