<?php

namespace System\Views\Admin\Blocks\Contents\Content\Pages\Ajax {

	use System\Views;

	class Main extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/Content/Pages/Ajax/Main.tpl');
        }
    }
}
