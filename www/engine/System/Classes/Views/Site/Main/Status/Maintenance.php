<?php

namespace System\Views\Site\Main\Status {

	use System\Views;

	class Maintenance extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Main/Status/Maintenance.tpl');
        }
    }
}
