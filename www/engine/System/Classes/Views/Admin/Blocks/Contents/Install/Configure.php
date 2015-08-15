<?php

namespace System\Views\Admin\Blocks\Contents\Install {

	use System\Views;

	class Configure extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/Install/Configure.tpl');
        }
    }
}
