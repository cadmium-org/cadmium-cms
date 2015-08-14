<?php

namespace System\Views\Admin\Blocks\Contents\Auth {

	use System\Views\View, System\Utils\Extend\Templates;

	class Reset extends View {

        public function __construct() {

            parent::__construct(Templates::path() . '/Blocks/Contents/Auth/Reset.tpl');
        }
    }
}
