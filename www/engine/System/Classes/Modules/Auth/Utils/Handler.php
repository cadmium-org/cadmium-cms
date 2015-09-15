<?php

namespace System\Modules\Auth\Utils {

	use System\Utils\View;

	trait Handler {

        private $code = '', $form = null;

        # Get contents

        private function getContents() {

            $contents = View::get($this->view);

            # Set code

			$contents->code = $this->code;

            # Implement form

            $this->form->implement($contents);

            # ------------------------

            return $contents;
        }
	}
}
