<?php

namespace Modules\Auth\Utils {

	use Frames, Utils\View;

	abstract class Action {

		protected $view = '', $code = '', $form = null;

		# Get contents

		protected function getContents() {

			$contents = View::get($this->view);

			# Set code

			$contents->code = $this->code;

			# Implement form

			if (null !== $this->form) $this->form->implement($contents);

			# ------------------------

			return $contents;
		}
	}
}
