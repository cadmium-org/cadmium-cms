<?php

namespace System\Views\Admin\Blocks\Contents\Auth {

	use System\Views;

	class Recover extends Views\Template {

        public function __construct($code) {

            parent::__construct('Blocks/Contents/Auth/Recover.tpl');

			$this->set('code', $code);
        }
    }
}
