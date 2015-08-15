<?php

namespace System\Views\Admin\Blocks {

	use System\Views;

	class Menu extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Menu.tpl');
        }
    }
}
