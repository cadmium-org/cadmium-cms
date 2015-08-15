<?php

namespace System\Views\Admin\Blocks\Contents {

	use System\Views;

	class Overview extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/Overview.tpl');
        }
    }
}
