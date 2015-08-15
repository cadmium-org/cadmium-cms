<?php

namespace System\Views\Admin\Main {

	use System\Views;

	class Page extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Main/Page.tpl');
        }
    }
}
