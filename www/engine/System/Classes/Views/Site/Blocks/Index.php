<?php

namespace System\Views\Site\Blocks {

	use System\Views;

	class Index extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Index.tpl');
        }
    }
}
