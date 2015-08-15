<?php

namespace System\Views\Site\Blocks\Contents\Profile {

	use System\Views;

	class Edit extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Contents/Profile/Edit.tpl');
        }
    }
}
