<?php

namespace System\Views\Site\Blocks\Contents {

	use System\Views;

	class Page extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Contents/Page.tpl');
        }
    }
}
