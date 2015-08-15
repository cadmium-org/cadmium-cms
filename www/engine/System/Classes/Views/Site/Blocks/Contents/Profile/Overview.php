<?php

namespace System\Views\Site\Blocks\Contents\Profile {

	use System\Views;

	class Overview extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Contents/Profile/Overview.tpl');
        }
    }
}
