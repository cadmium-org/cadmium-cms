<?php

namespace System\Views\Site\Blocks\Contents\Profile\Auth {

	use System\Views;

	class Recover extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Contents/Profile/Auth/Recover.tpl');
        }
    }
}