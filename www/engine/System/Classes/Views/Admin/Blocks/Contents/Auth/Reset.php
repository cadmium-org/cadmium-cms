<?php

namespace System\Views\Admin\Blocks\Contents\Auth {

	use System\Views;

	class Reset extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/Auth/Reset.tpl');
        }
    }
}
