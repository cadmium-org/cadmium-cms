<?php

namespace System\Views\Admin\Blocks\Contents\System\Users\List {

	use System\Views;

	class Main extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/System/Users/List/Main.tpl');
        }
    }
}
