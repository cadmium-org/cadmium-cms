<?php

namespace System\Views\Admin\Blocks\Contents\Extend\Templates {

	use System\Views;

	class Item extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/Extend/Templates/Item.tpl');
        }
    }
}
