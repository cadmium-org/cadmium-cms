<?php

namespace System\Views\Admin\Blocks\Contents\Auth {

	use System\Views;

	class Login extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/Auth/Login.tpl');
        }
    }
}
