<?php

namespace System\Views\Site\Blocks\Menu {

	use System\Views;

	class Container extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Menu/Container.tpl');
        }
    }
}
