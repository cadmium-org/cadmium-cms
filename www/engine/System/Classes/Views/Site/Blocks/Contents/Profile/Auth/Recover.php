<?php

namespace System\Views\Site\Blocks\Contents\Profile\Auth {

	use System\Views;

	class Recover extends Views\Template {

        public function __construct($code) {

            parent::__construct('Blocks/Contents/Profile/Auth/Recover.tpl');

			$this->set('code', $code);
        }
    }
}
