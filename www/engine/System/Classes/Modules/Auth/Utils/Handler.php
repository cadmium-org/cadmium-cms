<?php

namespace System\Modules\Auth\Utils {

	use System\Utils\View;

	trait Handler {

        private static $code = '', $form = null;

        # Get contents

        private static function getContents() {

            $contents = View::get(self::$view);

            # Set code

			$contents->code = self::$code;

            # Implement form

            self::$form->implement($contents);

            # ------------------------

            return $contents;
        }
	}
}
