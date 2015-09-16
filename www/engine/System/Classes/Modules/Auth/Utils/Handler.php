<?php

namespace System\Modules\Auth\Utils {

	use System\Utils\View;

	abstract class Handler {

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
