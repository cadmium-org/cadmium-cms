<?php

namespace System\Views\Site\Blocks {

	use System\Views;

	class Common extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Common.tpl');
        }
    }
}
