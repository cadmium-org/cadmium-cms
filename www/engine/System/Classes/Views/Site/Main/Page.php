<?php

namespace System\Views\Site\Main {

	use System\Views;

	class Page extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Main/Page.tpl');
        }
    }
}
