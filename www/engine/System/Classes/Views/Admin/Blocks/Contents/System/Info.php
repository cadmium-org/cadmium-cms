<?php

namespace System\Views\Admin\Blocks\Contents\System {

	use System\Views;

	class Info extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_ADMIN, 'Blocks/Contents/System/Info.tpl');
        }
    }
}
