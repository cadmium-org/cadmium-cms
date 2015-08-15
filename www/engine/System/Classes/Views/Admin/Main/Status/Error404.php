<?php

namespace System\Views\Admin\Main\Status {

	use System\Views;

	class Error404 extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Main/Status/Error404.tpl');
        }
    }
}
