<?php

namespace System\Views\Admin\Blocks\Contents\Auth {

	use System\Views\View, System\Utils\Extend\Templates;

	class Recover extends View {

        public function __construct($code) {

            parent::__construct(DIR_SYSTEM_TEMPLATES . SECTION_ADMIN . '/' .

				Templates::active() . '/Blocks/Contents/Auth/Recover.tpl');

			$this->code = $code;
        }
    }
}
