<?php

namespace System\Views\Site\Blocks\Contents\Profile\Auth {

	use System\Views;

	class Reset extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Contents/Profile/Auth/Reset.tpl');
        }
    }
}
