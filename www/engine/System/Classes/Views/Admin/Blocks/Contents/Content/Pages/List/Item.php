<?php

namespace System\Views\Admin\Blocks\Contents\Content\Pages\List {

	use System\Views;

	class Item extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/Content/Pages/List/Item.tpl');
        }
    }
}
