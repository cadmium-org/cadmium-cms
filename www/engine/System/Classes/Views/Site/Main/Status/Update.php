<?php

namespace System\Views\Site\Main\Status {

	use System\Views;

	class Update extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Main/Status/Update.tpl');
        }
    }
}
