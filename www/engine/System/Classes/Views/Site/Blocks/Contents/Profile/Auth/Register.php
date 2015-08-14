<?php

namespace System\Views\Site\Blocks\Contents\Profile\Auth {

	use System\Views\View, System\Utils\Extend\Templates;

	class Register extends View {

        public function __construct() {

            parent::__construct(Templates::path() . '/Blocks/Contents/Profile/Auth/Register.tpl');
        }
    }
}
