<?php

namespace System\Views\Site\Blocks\Contents\Profile\Auth {

	use System\Views\View, System\Utils\Extend\Templates;

	class Recover extends View {

        public function __construct($code) {

            parent::__construct(Templates::path() . '/Blocks/Contents/Profile/Auth/Recover.tpl');

			$this->set('code', $code);
        }
    }
}
